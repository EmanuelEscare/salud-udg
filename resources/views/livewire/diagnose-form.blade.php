<div class="max-w-3xl mx-auto p-4 space-y-4">
    <h1 class="h4 mb-2 fw-semibold text-slate-800">Diagnóstico sistema experto CBR (Case-Based Reasoning Method)</h1>
    <p class="text-muted mb-3">Busca síntomas, añádelos y obtén propuestas. Luego puedes guardar el caso.</p>

    {{-- Buscador de síntomas --}}
    <div class="position-relative">
        <input type="text"
               class="form-control"
               placeholder="Busca síntomas (ej. insomnio)…"
               wire:model.debounce.400ms="query" />

        {{-- Sugerencias (dropdown) --}}
        @if(!empty($suggestions))
            <ul class="list-group position-absolute w-100 mt-1 shadow rounded-2"
                style="max-height: 280px; overflow:auto; z-index:1080;">
                @foreach($suggestions as $s)
                    <li class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                        wire:click="addSymptom('{{ $s['code'] }}')"
                        style="cursor:pointer;">
                        <div>
                            <div class="fw-semibold">{{ $s['name'] }}</div>
                            <div class="text-muted small">Código: {{ $s['code'] }} · Cat: {{ $s['category_code'] }}</div>
                        </div>
                        <span class="badge bg-primary">Agregar</span>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    {{-- Seleccionados --}}
    @if(!empty($selectedSymptoms))
        <div class="d-flex flex-wrap gap-2">
            @foreach($selectedSymptoms as $s)
                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white text-slate-700 shadow-sm">
                    <span class="fw-semibold">{{ $s['name'] }}</span>
                    <span class="badge bg-secondary">{{ $s['code'] }}</span>
                    <span class="text-muted small">Cat: {{ $s['category_code'] }}</span>

                    {{-- (Opcional) pesos — los dejamos ocultos por simplicidad; si quieres sliders, habilita esto:
                    <input type="number" step="0.1" min="0" class="form-control form-control-sm w-20"
                           wire:model.lazy="weights.{{ $s['code'] }}" />
                    --}}

                    <button type="button" class="btn btn-sm btn-outline-danger"
                            wire:click="removeSymptom('{{ $s['code'] }}')">x</button>
                </span>
            @endforeach
        </div>
    @endif

    {{-- Error / Éxito --}}
    @if($errorMsg)
        <div class="alert alert-danger" role="alert">
            {{ $errorMsg }}
        </div>
    @endif
    @if($successMsg)
        <div class="alert alert-success" role="alert">
            {{ $successMsg }}
        </div>
    @endif

    {{-- Acciones --}}
    <div class="d-flex align-items-center gap-2">
        <button wire:click="diagnose"
                wire:loading.attr="disabled"
                class="btn btn-primary">
            <span wire:loading.remove>Diagnosticar</span>
            <span wire:loading class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        </button>

        {{-- Notas para guardar el caso --}}
        <div class="flex-1">
            <input type="text" class="form-control" placeholder="Notas (opcional)" wire:model.defer="notes">
        </div>
    </div>

    {{-- Resultados --}}
    @if(!empty($proposals))
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Propuestas</span>
                @if($consultId)
                    <span class="badge bg-light text-dark">Consult ID: {{ $consultId }}</span>
                @endif
            </div>
            <div class="card-body">
                @foreach($proposals as $i => $p)
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="fw-bold">
                                #{{ $i+1 }}
                                @php
                                    $dcode = $p['disease_code'] ?? '';
                                    $dname = $diseasesByCode[$dcode] ?? null;
                                @endphp
                                · {{ $dcode }} {!! $dname ? '<span class="text-muted">— '.$dname.'</span>' : '' !!}
                            </div>
                            <span class="badge bg-success">
                                similitud {{ number_format($p['similarity'] ?? 0, 2) }}
                            </span>
                        </div>

                        <div class="row mt-2 g-3">
                            <div class="col-md-6">
                                <div class="small text-muted mb-1">Coinciden</div>
                                <div class="bg-light p-2 rounded-2 small">
                                    {{ implode(', ', $p['matched_symptoms'] ?? []) ?: '—' }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="small text-muted mb-1">Faltantes</div>
                                <div class="bg-light p-2 rounded-2 small">
                                    {{ implode(', ', $p['missing_from_query'] ?? []) ?: '—' }}
                                </div>
                            </div>
                        </div>

                        @php $sols = $p['solutions'] ?? []; @endphp
                        @if(!empty($sols))
                            <div class="mt-3">
                                <div class="fw-semibold">Sugerencias (soluciones)</div>
                                <ul class="mb-0 ps-3">
                                    @foreach($sols as $name)
                                        <li>{{ $name }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mt-3">
                            <button class="btn btn-outline-primary"
                                    wire:click="retainCase({{ $i }})"
                                    wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="retainCase({{ $i }})">Guardar como caso</span>
                                <span wire:loading wire:target="retainCase({{ $i }})"
                                      class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </button>
                        </div>
                    </div>
                @endforeach
                <div class="text-muted small">* El caso se guarda con los síntomas seleccionados y sus pesos (1.0 por defecto) y las soluciones propuestas cuando sea posible mapearlas a sus códigos.</div>
            </div>
        </div>
    @endif
</div>
