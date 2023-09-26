<div>
    <!-- I have not failed. I've just found 10,000 ways that won't work. - Thomas Edison -->
    @php
        
        $psychicAnxietyItems = [1, 2, 3, 5, 6];
        $somaticAnxietyItems = [4, 7, 8, 9, 10, 11];
        
        $psychicAnxietyTotal = 0;
        $somaticAnxietyTotal = 0;
        $totalScore = 0;
        
        foreach ($test->result as $item) {
            $index = $item['index'];
            $value = $item['value'];
        
            // Calculate total score
            $totalScore += $value;
        }
        
        $test->totalScore = $totalScore;
        
    @endphp
    <style>
        th {
            background: #202945;
            color: white;
        }

        .bg-answer {
            background: #20294586;
        }

        .diag {
            background: red;
        }

        b {
            font-weight: bold !important;
        }

        .title-table {
            font-size: .9rem;
        }

        .content-table {
            font-size: .9rem;
        }

        .line-break {
            padding-top: 1rem;
            white-space: pre-wrap;
            line-height: 0.8;
        }
    </style>
    <h3 class="font-weight-normal"><b>INVENTARIO DE DEPRESIÓN DE BECK (BDI-II)</b></h3>
    <br>
    <p class="text-justify">
        Medir la severidad de depresión en adolescentes y adultos a través de la evaluación de los síntomas
        correspondientes a los criterios diagnósticos de los trastornos depresivos del Manual Diagnóstico y Estadístico
        de los Trastornos Mentales (DSM5).
        <br>
        <br>
        Evaluar de forma objetiva las manifestaciones de depresión; profundidad o intensidad de la misma.

    </p>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: ;" class="title-table align-middle text-center" scope="col">PSS</th>
                <th class="title-table text-center" scope="col">
                    <p class="line-break">No en absoluto</p>
                </th>
                <th class="title-table text-center" scope="col">
                    <p class="line-break">Levemente</p>
                </th>
                <th class="title-table text-center" scope="col">
                    <p class="line-break">Moderadamente</p>
                </th>
                <th class="title-table text-center" scope="col">
                    <p class="line-break">Severamente</p>
                </th>

            </tr>
        </thead>
        <tbody>
            @foreach ($test->result as $question)
                <tr>
                    <td class="content-table border-dark">
                        <p class="text-justify">{{ $question['index'] }}.- {{ $question['option'] }}</p>
                    </td>
                    <td
                        class="content-table border-dark text-center align-middle @if ($question['value'] == 0) bg-secondary text-white @endif">
                        0</td>
                    <td
                        class="content-table border-dark text-center align-middle @if ($question['value'] == 1) bg-secondary text-white @endif">
                        1</td>
                    <td
                        class="content-table border-dark text-center align-middle @if ($question['value'] == 2) bg-secondary text-white @endif">
                        2</td>
                    <td
                        class="content-table border-dark text-center align-middle @if ($question['value'] == 3) bg-secondary text-white @endif">
                        3</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <h5><b>Resultado</b></h5>
    <br>
    <table style="width: 40%;" class="table table-bordered border-dark">
        <tbody>
            <tr>
                <td class="border-dark text-right"><b>PUNTUACIÓN TOTAL</b></td>
                <td class="border-dark" style="width: 20%;"><b>{{ $test->totalScore }}</b></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <h5><b>Observaciones</b></h5>

    <br>
    <table>
        <tbody>
            <tr>
                <td class="text-justify">
                    {!! $test->observations !!}

                </td>
            </tr>
        </tbody>
    </table>
    <br>
    <h5><b>Diagnóstico</b></h5>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                @if ($test->diagnostic == '"Depresión mínima"')
                    <th class="text-center border-dark bg-success">
                        {{ preg_replace('/(^[\"\']|[\"\']$)/', '', $test->diagnostic) }}
                    </th>
                @endif
                @if ($test->diagnostic == '"Depresión leve"')
                    <th class="text-center border-dark text-dark bg-light">
                        {{ preg_replace('/(^[\"\']|[\"\']$)/', '', $test->diagnostic) }}
                    </th>
                @endif
                @if ($test->diagnostic == '"Depresión moderada"')
                    <th class="text-center text-dark border-dark bg-warning">
                        {{ preg_replace('/(^[\"\']|[\"\']$)/', '', $test->diagnostic) }}
                    </th>
                @endif
                @if ($test->diagnostic == '"Depresión grave"')
                    <th class="text-center border-dark bg-danger">
                        {{ preg_replace('/(^[\"\']|[\"\']$)/', '', $test->diagnostic) }}
                    </th>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                @if ($test->diagnostic == '"Depresión mínima"')
                    <td class="border-dark">
                        <p>En este rango de puntajes, generalmente se considera que la persona no está experimentando
                            síntomas significativos de depresión o que los síntomas son mínimos. Puede indicar que la
                            persona está pasando por un período de bienestar emocional o que, si ha experimentado
                            síntomas depresivos en el pasado, estos han disminuido considerablemente. No se necesita una
                            intervención terapéutica significativa en esta etapa, pero es importante seguir monitoreando
                            el estado emocional de la persona para detectar cualquier cambio.</p>
                    </td>
                @endif

                @if ($test->diagnostic == '"Depresión leve"')
                    <td class="border-dark">
                        <p>Un puntaje en este rango sugiere la presencia de síntomas de depresión, pero estos suelen ser
                            de intensidad leve. La persona puede estar experimentando cambios en el estado de ánimo,
                            desinterés en actividades previamente disfrutadas, fatiga, problemas para dormir y otros
                            síntomas depresivos leves. A menudo, la depresión leve puede manejarse eficazmente a través
                            de intervenciones como la psicoterapia (terapia de conversación) o cambios en el estilo de
                            vida, como el ejercicio regular y una dieta equilibrada.</p>
                    </td>
                @endif

                @if ($test->diagnostic == '"Depresión moderada"')
                    <td class="border-dark">
                        <p>En esta categoría, los síntomas de depresión son más pronunciados y pueden interferir
                            significativamente en la vida diaria de la persona. Los síntomas pueden incluir una tristeza
                            profunda, sentimientos de desesperanza, dificultades para concentrarse, cambios en el
                            apetito, pérdida de interés en las relaciones y actividades sociales, y posible deterioro en
                            el funcionamiento laboral o académico. Se recomienda encarecidamente buscar ayuda
                            profesional en este punto. La terapia y, en algunos casos, la medicación antidepresiva
                            pueden ser apropiadas para abordar la depresión moderada.</p>
                    </td>
                @endif

                @if ($test->diagnostic == '"Depresión grave"')
                    <td class="border-dark">
                        <p>En esta categoría, la depresión es severa y puede ser incapacitante. Los síntomas son
                            intensos y persistentes, lo que puede poner en peligro la salud física y emocional de la
                            persona. La persona puede experimentar pensamientos suicidas o autodestructivos, cambios
                            significativos en el peso corporal, insomnio grave o exceso de sueño, y una incapacidad
                            generalizada para funcionar en la vida cotidiana. La ayuda profesional inmediata es esencial
                            en este nivel de depresión. La terapia intensiva, la hospitalización o la combinación de
                            terapia y medicación pueden ser necesarios para estabilizar la condición y reducir el riesgo
                            de autolesiones o suicidio.</p>
                    </td>
                @endif
            </tr>
        </tbody>
    </table>
    <br>
</div>
