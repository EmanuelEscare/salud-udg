<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class DiagnoseForm extends Component
{
    public $query = '';
    public $suggestions = [];
    /** @var array<int, array{code:string,name:string,category_code:string}> */
    public $selectedSymptoms = []; // ahora guardamos code + name + category_code
    public $weights = [];          // opcional: pesos por síntoma (por ahora default 1.0)
    public $proposals = [];        // respuesta de /v1/diagnose
    public $consultId = null;      // id de consulta (útil para trazabilidad)
    public $errorMsg = null;
    public $successMsg = null;
    public $notes = '';            // notas para POST /v1/cases

    /** índices auxiliares */
    public $solutionsByName = [];  // "nombre" => "code" (para convertir al guardar)
    public $diseasesByCode = [];   // "code" => "name" (para mostrar más bonito)

    protected $updatesQueryString = ['query'];

    public function mount()
    {
        $this->cargarIndices();
    }

    protected function cargarIndices(): void
    {
        try {
            $base = config('services.psych_cbr.base');
            $timeout = config('services.psych_cbr.timeout');

            // soluciones (para convertir nombres -> codes al guardar el caso)
            $solResp = Http::timeout($timeout)->baseUrl($base)->get('/v1/solutions');
            if ($solResp->successful()) {
                foreach ($solResp->json() as $s) {
                    // asumimos nombres únicos
                    $this->solutionsByName[$s['name']] = $s['code'];
                }
            }

            // enfermedades (para mostrar nombre en propuestas)
            $disResp = Http::timeout($timeout)->baseUrl($base)->get('/v1/diseases');
            if ($disResp->successful()) {
                foreach ($disResp->json() as $d) {
                    $this->diseasesByCode[$d['code']] = $d['name'];
                }
            }
        } catch (\Throwable $e) {
            // no rompemos el flujo si falla, solo seguimos sin índices
        }
    }

    public function updatedQuery()
    {
        $this->suggestions = [];
        $this->errorMsg = null;

        if (mb_strlen($this->query) < 2) return;

        try {
            $resp = Http::timeout(config('services.psych_cbr.timeout'))
                ->baseUrl(config('services.psych_cbr.base'))
                ->get('/v1/symptoms', ['q' => $this->query]);

            if ($resp->successful()) {
                $this->suggestions = $resp->json(); // trae code, name, category_code
            } else {
                $this->errorMsg = "No se pudieron cargar síntomas (" . $resp->status() . ")";
            }
        } catch (\Throwable $e) {
            $this->errorMsg = "Error de red: " . $e->getMessage();
        }
    }

    public function addSymptom(string $code)
    {
        // buscar el síntoma en suggestions
        $found = collect($this->suggestions)->firstWhere('code', $code);
        if (!$found) return;

        // evitar duplicados
        $exists = collect($this->selectedSymptoms)->contains(fn ($s) => $s['code'] === $code);
        if (!$exists) {
            $this->selectedSymptoms[] = [
                'code' => $found['code'],
                'name' => $found['name'],
                'category_code' => $found['category_code'] ?? null,
            ];
            $this->weights[$found['code']] = $this->weights[$found['code']] ?? 1.0;
        }

        // limpiar buscador
        $this->query = '';
        $this->suggestions = [];
    }

    public function removeSymptom(string $code)
    {
        $this->selectedSymptoms = array_values(array_filter(
            $this->selectedSymptoms,
            fn ($s) => $s['code'] !== $code
        ));
        unset($this->weights[$code]);
    }

    public function diagnose()
    {
        $this->errorMsg = null;
        $this->successMsg = null;
        $this->proposals = [];
        $this->consultId = null;

        if (empty($this->selectedSymptoms)) {
            $this->errorMsg = "Selecciona al menos un síntoma.";
            return;
        }

        $codes = array_map(fn ($s) => $s['code'], $this->selectedSymptoms);

        $payload = [
            'symptoms' => $codes, // el backend generará pesos = 1.0 por cada síntoma
            'top_k'    => 3,
        ];

        try {
            $resp = Http::timeout(config('services.psych_cbr.timeout'))
                ->baseUrl(config('services.psych_cbr.base'))
                ->post('/v1/diagnose', $payload);

            if ($resp->successful()) {
                $data = $resp->json();
                $this->consultId = $data['consult_id'] ?? null;
                $this->proposals  = $data['proposals'] ?? [];
                if (empty($this->proposals)) {
                    $this->errorMsg = "No hubo propuestas. Ajusta los síntomas e intenta de nuevo.";
                }
            } else {
                $this->errorMsg = "Diagnóstico falló (" . $resp->status() . "): " . $resp->body();
            }
        } catch (\Throwable $e) {
            $this->errorMsg = "Error de red: " . $e->getMessage();
        }
    }

    public function retainCase(int $idx)
    {
        $this->errorMsg = null;
        $this->successMsg = null;

        if (!isset($this->proposals[$idx])) {
            $this->errorMsg = "Propuesta inválida.";
            return;
        }
        $p = $this->proposals[$idx];

        // construir weights por síntoma seleccionado
        $symptomWeights = [];
        foreach ($this->selectedSymptoms as $s) {
            $symptomWeights[$s['code']] = (float)($this->weights[$s['code']] ?? 1.0);
        }

        // convertir nombres de soluciones -> codes (si la API /v1/diagnose devuelve nombres)
        $solutionsNames = $p['solutions'] ?? [];
        $solutionsCodes = [];
        foreach ($solutionsNames as $name) {
            if (isset($this->solutionsByName[$name])) {
                $solutionsCodes[] = $this->solutionsByName[$name];
            }
        }
        $solutionsCodes = array_values(array_unique($solutionsCodes));

        $payload = [
            'disease_code'    => $p['disease_code'],
            'notes'           => trim($this->notes) ?: null,
            'symptom_weights' => $symptomWeights,
            'solutions'       => $solutionsCodes, // puede ser [] si no hay mapping
        ];

        try {
            $resp = Http::timeout(config('services.psych_cbr.timeout'))
                ->baseUrl(config('services.psych_cbr.base'))
                ->post('/v1/cases', $payload);

            if ($resp->status() === 201) {
                $this->successMsg = "Caso guardado (ID ".$resp->json('id').") ✅";
                // si quieres, limpiar notas:
                // $this->notes = '';
            } else {
                $this->errorMsg = "No se pudo guardar el caso (" . $resp->status() . "): " . $resp->body();
            }
        } catch (\Throwable $e) {
            $this->errorMsg = "Error de red al guardar: " . $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.diagnose-form');
    }
}
