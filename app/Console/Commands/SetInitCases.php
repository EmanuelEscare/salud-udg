<?php

namespace App\Console\Commands;

use App\Models\Cases;
use App\Models\Symptom;
use Illuminate\Console\Command;

class SetInitCases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'set:cases';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set initial cases in the database';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $diseases = [
            "P01" => "Ansiedad",
            "P02" => "Anorexia nerviosa",
            "P03" => "Trastorno bipolar",
            "P04" => "Trastorno de conversión",
            "P05" => "Depresión",
            "P06" => "Enosimanía",
            "P07" => "Fobia",
            "P08" => "Hipocondría",
            "P09" => "Histeria",
            "P10" => "Trastorno de identidad disociativo",
            "P11" => "Estrés"
        ];

        $this->createCaseWithSymptoms("P02", $diseases["P02"], [
            'G06' => ['weight' => 5],
            'G18' => ['weight' => 4],
            'G15' => ['weight' => 3],
            'G22' => ['weight' => 2],
            'G08' => ['weight' => 1],
            'G18' => ['weight' => 3],
            'G40' => ['weight' => 2],
        ]);

        $this->createCaseWithSymptoms("P03", $diseases["P03"], [
            'G26' => ['weight' => 5],// euforia / muy excitado (manía/hipomanía)
            'G04' => ['weight' => 4],// inestabilidad/irritabilidad
            'G08' => ['weight' => 4],// insomnio / ↓ necesidad de dormir
            'G23' => ['weight' => 4],// desesperanza (fase depresiva)
            'G18' => ['weight' => 4],// baja autoestima (fase depresiva)
            'G09' => ['weight' => 4],// ideas suicidas (bandera clínica)
            'G25' => ['weight' => 3],// culpa / miedo a equivocarse
            'G24' => ['weight' => 3],// sentimiento de pecado/auto-reproche
            'G20' => ['weight' => 3],// fatiga/debilidad
            'G12' => ['weight' => 2],// actividad repetitiva/agitación inespecífica
            'G10' => ['weight' => 2],// fallos de memoria/concentración
            'G16' => ['weight' => 2],// pesadez en extremidades (retardo psicomotor)
            'G17' => ['weight' => 2],// sospecha/paranoide (posible psicosis bipolar)
            'G15' => ['weight' => 1],// malestar GI inespecífico
            'G02' => ['weight' => 1],// rigidez/inflexibilidad (rasgo, no núcleo)
            'G03' => ['weight' => 1],// “egoísmo” (no clínico/inespecífico)
        ]);

        $this->createCaseWithSymptoms("P04", $diseases["P04"], [
            'G13' => ['weight' => 5], // convulsiones (no epilépticas) / episodios similares
            'G16' => ['weight' => 4], // sensación de pesadez/debilidad en extremidades (debilidad motora)
            'G01' => ['weight' => 4], // habla menos fluida / problemas del habla (disfonía/afonía)
            'G22' => ['weight' => 3], // dolor en partes del cuerpo (síntomas sensoriales)
            'G05' => ['weight' => 2], // dificultad respiratoria/“no me entra el aire” (síntoma funcional)
            'G10' => ['weight' => 2], // pérdida de memoria / episodios disociativos
            'G20' => ['weight' => 2], // fatiga/debilidad inespecífica
            'G04' => ['weight' => 2], // inestabilidad emocional (desencadenante/maintainer)
            'G18' => ['weight' => 1], // baja autoestima
            'G23' => ['weight' => 1], // desesperanza
        ]);

        $this->createCaseWithSymptoms("P05", $diseases["P05"], [
            'G09' => ['weight' => 5], // ideas suicidas 
            'G23' => ['weight' => 5], // desesperanza
            'G18' => ['weight' => 4], // baja autoestima
            'G08' => ['weight' => 4], // insomnio / sueño no reparador
            'G20' => ['weight' => 4], // fatiga / debilidad fácil
            'G25' => ['weight' => 4], // culpa excesiva / miedo a equivocarse
            'G24' => ['weight' => 3], // sentirse muy pecador / auto-reproche
            'G10' => ['weight' => 3], // problemas de memoria / concentración
            'G16' => ['weight' => 3], // pesadez en extremidades (retardo psicomotor)
            'G06' => ['weight' => 2], // trastornos de la dieta (↑/↓ apetito, peso)
            'G22' => ['weight' => 2], // dolor corporal inespecífico
            'G15' => ['weight' => 2], // malestares GI (indigestión)
            'G04' => ['weight' => 2], // inestabilidad emocional / labilidad
            'G01' => ['weight' => 1], // habla menos fluida (ralentización)
        ]);

        $this->createCaseWithSymptoms("P06", $diseases["P06"], [
            'G24' => ['weight' => 5], // sentirse muy pecador (núcleo)
            'G25' => ['weight' => 5], // culpa excesiva / miedo a equivocarse (núcleo)
            'G23' => ['weight' => 4], // desesperanza
            'G18' => ['weight' => 4], // baja autoestima
            'G09' => ['weight' => 4], // ideas suicidas ⚠️ prioridad de seguridad
            'G12' => ['weight' => 3], // conductas repetitivas/rituales (p.ej., confesión/oración compulsiva)
            'G08' => ['weight' => 3], // insomnio
            'G20' => ['weight' => 3], // fatiga / debilidad
            'G04' => ['weight' => 2], // inestabilidad emocional
            'G10' => ['weight' => 2], // problemas de memoria/concentración
            'G06' => ['weight' => 2], // trastornos de la dieta (apoyo, no núcleo)
            'G15' => ['weight' => 1], // malestares GI (inespecífico)
            'G22' => ['weight' => 1], // dolor corporal (inespecífico)
            'G01' => ['weight' => 1], // habla menos fluida / enlentecimiento (inespecífico)
        ]);

        $this->createCaseWithSymptoms("P07", $diseases["P07"], [
            'G05' => ['weight' => 4], // disnea / falta de aire (síntoma de pánico ante el estímulo fóbico)
            'G04' => ['weight' => 3], // inestabilidad/ansiedad marcada al exponerse o anticipar
            'G26' => ['weight' => 2], // activación/euforia nerviosa (arousal)
            'G08' => ['weight' => 2], // insomnio por anticipación/temor
            'G20' => ['weight' => 2], // debilidad/cansancio tras picos de ansiedad
            'G15' => ['weight' => 2], // malestar GI (frecuente en ansiedad aguda)
            'G01' => ['weight' => 2], // habla menos fluida / balbuceo por miedo
            'G22' => ['weight' => 1], // dolor corporal inespecífico (somatización)
        ]);

        $this->createCaseWithSymptoms("P08", $diseases["P08"], [
            'G19' => ['weight' => 5], // preocupación excesiva por enfermedades (núcleo)
            'G21' => ['weight' => 5], // sensación de padecer una enfermedad grave (núcleo)
            'G04' => ['weight' => 4], // inestabilidad/ansiedad elevada
            'G08' => ['weight' => 4], // insomnio por rumiación/anticipación
            'G22' => ['weight' => 3], // dolor corporal inespecífico (somatización)
            'G15' => ['weight' => 3], // indigestión/molestias GI
            'G20' => ['weight' => 3], // debilidad/cansancio fácil
            'G05' => ['weight' => 3], // disnea/falta de aire (picos de ansiedad)
            'G17' => ['weight' => 2], // sospecha excesiva/paranoide (sesgo de amenaza)
            'G12' => ['weight' => 2], // conductas repetitivas de chequeo (baja especificidad)
            'G14' => ['weight' => 2], // higiene excesiva (si la preocupación es contaminación)
            'G10' => ['weight' => 1], // dificultades cognitivas por ansiedad (inespecífico)
            'G09' => ['weight' => 2], // ideas suicidas (comorbilidad depresiva; alerta clínica)
        ]);

        $this->createCaseWithSymptoms("P09", $diseases["P09"], [
            'G22' => ['weight' => 5], // dolor en partes del cuerpo (somatización nuclear)
            'G15' => ['weight' => 4], // indigestión / malestares GI frecuentes
            'G16' => ['weight' => 4], // pesadez/debilidad en extremidades (síntoma funcional)
            'G04' => ['weight' => 3], // inestabilidad/labilidad emocional
            'G10' => ['weight' => 3], // pérdida de memoria / episodios disociativos
            'G05' => ['weight' => 3], // dificultad respiratoria subjetiva (síntoma funcional)
            'G13' => ['weight' => 3], // “convulsiones” no epilépticas / episodios conversivos
            'G19' => ['weight' => 2], // preocupación excesiva por enfermedad (menos que en hipocondría)
            'G21' => ['weight' => 2], // sensación de padecer enfermedad grave (apoyo)
            'G08' => ['weight' => 2], // insomnio por malestar/ansiedad
            'G20' => ['weight' => 2], // debilidad/cansancio fácil
            'G18' => ['weight' => 2], // baja autoestima (factor de vulnerabilidad)
            'G01' => ['weight' => 2], // habla menos fluida / disfonía funcional
            'G17' => ['weight' => 1], // sospecha excesiva (inespecífico)
            'G06' => ['weight' => 1], // trastornos de la dieta (inespecífico)
        ]);

        $this->createCaseWithSymptoms("P10", $diseases["P10"], [
            'G10' => ['weight' => 5], // pérdida de memoria / lagunas temporales (núcleo)
            'G04' => ['weight' => 4], // inestabilidad/labilidad emocional
            'G09' => ['weight' => 4], // ideas suicidas ⚠️ riesgo elevado en DID
            'G08' => ['weight' => 3], // insomnio / alteraciones del sueño
            'G18' => ['weight' => 3], // baja autoestima
            'G23' => ['weight' => 3], // desesperanza
            'G20' => ['weight' => 3], // debilidad/cansancio fácil
            'G22' => ['weight' => 2], // dolor corporal inespecífico
            'G01' => ['weight' => 2], // habla menos fluida / cambios en el discurso
            'G13' => ['weight' => 2], // episodios tipo convulsivos no epilépticos (posible comorbilidad)
            'G15' => ['weight' => 1], // malestares GI (inespecífico)
            'G17' => ['weight' => 1], // sospecha/paranoide (baja especificidad)
            'G12' => ['weight' => 1], // conductas repetitivas/automatismos (inespecífico)
        ]);

        $this->createCaseWithSymptoms("P11", $diseases["P11"], [
            'G04' => ['weight' => 4], // inestabilidad/labilidad emocional
            'G08' => ['weight' => 4], // insomnio / sueño no reparador
            'G20' => ['weight' => 4], // fatiga / debilidad fácil
            'G15' => ['weight' => 3], // malestares GI / indigestión
            'G05' => ['weight' => 3], // disnea / sensación de falta de aire
            'G22' => ['weight' => 3], // dolor corporal / tensional
            'G19' => ['weight' => 2], // preocupación excesiva por la salud (somatización por estrés)
            'G06' => ['weight' => 2], // trastornos de la dieta (apetito ↑/↓ por estrés)
            'G26' => ['weight' => 2], // activación elevada (arousal/agitacion)
            'G12' => ['weight' => 2], // conductas repetitivas/automatismos (nerviosismo)
            'G01' => ['weight' => 2], // habla menos fluida (bloqueo por tensión)
            'G10' => ['weight' => 2], // fallos de memoria/atención (sobrecarga)
            'G18' => ['weight' => 2], // baja autoestima (vulnerabilidad)
            'G23' => ['weight' => 2], // desesperanza (si el estrés se cronifica)
            'G17' => ['weight' => 1], // sospecha/hipervigilancia (inespecífico)
            'G09' => ['weight' => 1], // ideas suicidas (no propio del estrés; monitorear si aparece) ⚠️
        ]);

        return Command::SUCCESS;
    }

    protected function createCaseWithSymptoms($code, $name, $symptomWeights)
    {
        $case = Cases::firstOrCreate(
            [
                'disease_code' => $code,
                'notes' => "Caso inicial de $name"
            ],
            ['is_active' => true]
        );

        $case->symptoms()->syncWithoutDetaching(
            $symptomWeights
        );

    }
}
