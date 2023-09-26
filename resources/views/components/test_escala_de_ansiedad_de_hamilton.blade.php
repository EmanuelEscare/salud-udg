<div>
    <!-- Live as if you were to die tomorrow. Learn as if you were to live forever. - Mahatma Gandhi -->
    @php
        
        $psychicAnxietyItems = [1, 2, 3, 5, 6];
        $somaticAnxietyItems = [4, 7, 8, 9, 10, 11];
        
        $psychicAnxietyTotal = 0;
        $somaticAnxietyTotal = 0;
        $totalScore = 0;
        
        foreach ($test->result as $item) {
            $index = $item['index'];
            $value = $item['value'];
        
            // Calculate psychic anxiety
            if (in_array($index, $psychicAnxietyItems)) {
                $psychicAnxietyTotal += $value;
            }
        
            // Calculate somatic anxiety
            if (in_array($index, $somaticAnxietyItems)) {
                $somaticAnxietyTotal += $value;
            }
        
            // Calculate total score
            $totalScore += $value;
        }
        $test->psychicAnxietyTotal = $psychicAnxietyTotal;
        $test->somaticAnxietyTotal = $somaticAnxietyTotal;
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

        .vertical-text {
            transform: rotate(270deg);
        }

        .th_width {
            height: 7rem;
            width: 0rem;
            margin: 0% !important;
            padding: 0% !important;
        }

        .th_p {
            padding-bottom: 1.2rem;
        }

        .diag {
            background: red;
        }
        b{
            font-weight: bold!important;
        }
        .title-table{
            font-size: .9rem;
        }
        .content-table{
            font-size: .8rem;
        }
    </style>
    <h3 class="font-weight-normal"><b>ESCALA DE ANSIEDAD DE HAMILTON</b></h3>
    <br>
    <p class="text-justify">
        <b><u>Población diana</u></b>: Población general. Se trata de una escala <b>heteroadministrada</b>
        por un clínico tras una entrevista. El entrevistador puntúa de 0 a 4 puntos cada
        ítem, valorando tanto la intensidad como la frecuencia del mismo. Se pueden
        obtener, además, dos puntuaciones que corresponden a ansiedad psíquica (ítems
        1, 2, 3, 4, 5, 6 y 14) y a ansiedad somática (ítems 7, 8, 9, 10, 11, 12 y 13). Es
        aconsejable distinguir entre ambos a la hora de valorar los resultados de la misma.
        No existen puntos de corte. Una mayor puntuación indica una mayor intensidad de
        la ansiedad. Es sensible a las variaciones a través del tiempo o tras recibir
        tratamiento.
    </p>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="th_width text-nowrap align-middle text-center" scope="col">SÍNTOMAS DE LOS ESTADOS DE
                    ANSIEDAD</th>
                <th class="th_width" scope="col">
                    <p class="vertical-text th_p text-nowrap">Ausente</p>
                </th>
                <th class="th_width" scope="col">
                    <p class="vertical-text th_p text-nowrap">Leve</p>
                </th>
                <th class="th_width" scope="col">
                    <p class="vertical-text th_p text-nowrap">Moderado</p>
                </th>
                <th class="th_width" scope="col">
                    <p class="vertical-text th_p text-nowrap">Grave</p>
                </th>
                <th class="th_width" scope="col">
                    <p class="vertical-text th_p text-nowrap">Muy grave</p>
                </th>

            </tr>
        </thead>
        <tbody>
            @foreach ($test->result as $question)
            <tr>
                <td class="border-dark">
                    @php
                        $parts = explode("<br>", $question['option']);
                    @endphp
                    <b class="title-table text-justify">
                        {{strip_tags($parts[0])}}
                    </b>
                    <br>
                    <p class="content-table text-justify">
                        {{$parts[1]}}
                    </p>
                </td>
                <td
                    class="border-dark text-center align-middle @if ($question['value'] == 0) bg-secondary text-white @endif">
                    0</td>
                <td
                    class="border-dark text-center align-middle @if ($question['value'] == 1) bg-secondary text-white @endif">
                    1</td>
                <td
                    class="border-dark text-center align-middle @if ($question['value'] == 2) bg-secondary text-white @endif">
                    2</td>
                <td
                    class="border-dark text-center align-middle @if ($question['value'] == 3) bg-secondary text-white @endif">
                    3</td>
                <td
                    class="border-dark text-center align-middle @if ($question['value'] == 4) bg-secondary text-white @endif">
                    4</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <br>
    <h5><b>Resultado</b></h5>
    <br>
    <table style="width: 40%;" class="table table-bordered border-dark">
        <tbody>
            <tr>
                <td class="border-dark"><b>Ansiedad psíquica </b></td>
                <td class="border-dark" style="width: 20%;"><b>{{$test->psychicAnxietyTotal}}</b></td>
            </tr>
            <tr>
                <td class="border-dark"><b>Ansiedad somática</b></td>
                <td class="border-dark" style="width: 20%;"><b>{{$test->somaticAnxietyTotal}}</b></td>
            </tr>
            <tr>
                <td class="border-dark text-right"><b>PUNTUACIÓN TOTAL</b></td>
                <td class="border-dark" style="width: 20%;"><b>{{$test->totalScore}}</b></td>
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
                @if ($test->diagnostic == '"Ansiedad Leve"')
                    <th class="text-center border-dark bg-success">
                        {{ preg_replace('/(^[\"\']|[\"\']$)/', '', $test->diagnostic) }}
                    </th>
                @endif
                @if ($test->diagnostic == '"Ansiedad Moderada"')
                    <th class="text-center border-dark text-dark bg-light">
                        {{ preg_replace('/(^[\"\']|[\"\']$)/', '', $test->diagnostic) }}
                    </th>
                @endif
                @if ($test->diagnostic == '"Ansiedad Moderadamente Severa"')
                    <th class="text-center text-dark border-dark bg-warning">
                        {{ preg_replace('/(^[\"\']|[\"\']$)/', '', $test->diagnostic) }}
                    </th>
                @endif
                @if ($test->diagnostic == '"Ansiedad Severa"')
                    <th class="text-center border-dark bg-danger">
                        {{ preg_replace('/(^[\"\']|[\"\']$)/', '', $test->diagnostic) }}
                    </th>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                @if ($test->diagnostic == '"Ansiedad Leve"')
                    <td class="border-dark">
                        <p class="">Este diagnóstico indica que la ansiedad del paciente es leve y generalmente
                            manejable sin necesidad de tratamiento intensivo.</p>
                    </td>
                @endif

                @if ($test->diagnostic == '"Ansiedad Moderada"')
                    <td class="border-dark">
                        <p class="">Este diagnóstico indica que la ansiedad del paciente es de intensidad
                            moderada y puede requerir intervención terapéutica o tratamiento.</p>
                    </td>
                @endif

                @if ($test->diagnostic == '"Ansiedad Moderadamente Severa"')
                    <td class="border-dark">
                        <p class="">Este diagnóstico indica que la ansiedad del paciente es moderadamente severa
                            y puede requerir tratamiento urgente para su manejo.</p>
                    </td>
                @endif

                @if ($test->diagnostic == '"Ansiedad Severa"')
                    <td class="border-dark">
                        <p class="">Este diagnóstico indica que la ansiedad del paciente es severa y puede
                            requerir atención inmediata y posiblemente hospitalización o tratamiento intensivo.</p>
                    </td>
                @endif
            </tr>
        </tbody>
    </table>
    <br>
</div>
