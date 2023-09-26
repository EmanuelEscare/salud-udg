<div>
    <!-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin -->
    @php
        
        $copingWithStress = [4,5,6,7,8,10,13];
        $perceivedStress = [1,2,3,8,11,12,14];
        
        $copingWithStressTotal = 0;
        $perceivedStressTotal = 0;
        
        foreach ($test->result as $item) {
            $index = $item['index'];
            $value = $item['value'];
        
            // Calculate psychic anxiety
            if (in_array($index, $copingWithStress)) {
                $copingWithStressTotal += (4 - $value);
            }
        
            // Calculate somatic anxiety
            if (in_array($index, $perceivedStress)) {
                $perceivedStressTotal += $value;
            }
        
        }
        $totalScore = $perceivedStressTotal+$copingWithStressTotal;

        $test->copingWithStressTotal = $copingWithStressTotal;
        $test->perceivedStressTotal = $perceivedStressTotal;
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
    <h3 class="font-weight-normal text-justify"><b>ESCALA DE ESTRÉS PERCIBIDO <br>(PSS, PERCEIVED STRESS SCALE)</b></h3>
    <br>
    <p class="text-justify">
        Medir el grado en que, durante el último mes, las personas se
        han sentido molestas o preocupadas o, por el contrario, se han sentido
        seguras de su capacidad para controlar sus problemas personales.

    </p>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: ;" class="title-table align-middle text-center" scope="col">PSS</th>
                <th class="title-table text-center" scope="col">
                    <p class="line-break">Nunca</p>
                </th>
                <th class="title-table text-center" scope="col">
                    <p class="line-break">Casi nunca</p>
                </th>
                <th class="title-table text-center" scope="col">
                    <p class="line-break">De vez en cuando</p>
                </th>
                <th class="title-table text-center" scope="col">
                    <p class="line-break">Frecuente</p>
                </th>
                <th class="title-table text-center" scope="col">
                    <p class="line-break">Muy frecuente</p>
                </th>

            </tr>
        </thead>
        <tbody>
            @foreach ($test->result as $question)
                <tr>
                    <td class="content-table border-dark">
                        <p class="text-justify">{{$question['index']}}.- {{ $question['option'] }}</p>
                    </td>
                    <td class="content-table border-dark text-center align-middle @if ($question['value'] == 0) bg-secondary text-white @endif">
                        0</td>
                    <td class="content-table border-dark text-center align-middle @if ($question['value'] == 1) bg-secondary text-white @endif">
                        1</td>
                    <td class="content-table border-dark text-center align-middle @if ($question['value'] == 2) bg-secondary text-white @endif">
                        2</td>
                    <td class="content-table border-dark text-center align-middle @if ($question['value'] == 3) bg-secondary text-white @endif">
                        3</td>
                    <td class="content-table border-dark text-center align-middle @if ($question['value'] == 4) bg-secondary text-white @endif">
                        4</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
    <br>
    <h5><b>Resultado</b></h5>
    <br>
    <table style="width: 70%;" class="table table-bordered border-dark">
        <tbody>
            <tr>
                <td class="border-dark"><b>Estrés percibido </b></td>
                <td class="border-dark" style="width: 20%;"><b>{{$test->perceivedStressTotal}}</b></td>
            </tr>
            <tr>
                <td class="border-dark"><b>Afrontamiento del estrés percibido</b></td>
                <td class="border-dark" style="width: 20%;"><b>{{$test->copingWithStressTotal}}</b></td>
            </tr>
            <tr>
                <td class="border-dark text-right"><b>PUNTUACIÓN TOTAL</b></td>
                <td class="border-dark" style="width: 20%;"><b>{{$test->totalScore}}</b></td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <br>
    <br>
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
    <br>
    <h5><b>Diagnóstico</b></h5>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                @if ($test->diagnostic == '"Nivel de estrés: Bajo estrés percibido."')
                    <th class="text-center border-dark bg-success">
                        {{ preg_replace('/(^[\"\']|[\"\']$)/', '', $test->diagnostic) }}
                    </th>
                @endif
                @if ($test->diagnostic == '"Nivel de estrés: Estrés percibido moderado."')
                    <th class="text-center border-dark text-dark bg-light">
                        {{ preg_replace('/(^[\"\']|[\"\']$)/', '', $test->diagnostic) }}
                    </th>
                @endif
                @if ($test->diagnostic == '"Nivel de estrés: Estrés percibido alto."')
                    <th class="text-center text-dark border-dark bg-warning">
                        {{ preg_replace('/(^[\"\']|[\"\']$)/', '', $test->diagnostic) }}
                    </th>
                @endif
                @if ($test->diagnostic == '"Nivel de estrés: Muy alto estrés percibido."')
                    <th class="text-center border-dark bg-danger">
                        {{ preg_replace('/(^[\"\']|[\"\']$)/', '', $test->diagnostic) }}
                    </th>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                @if ($test->diagnostic == '"Nivel de estrés: Bajo estrés percibido."')
                    <td class="border-dark">
                        <p class="">Este diagnóstico indica que la ansiedad del paciente es leve y generalmente
                            manejable sin necesidad de tratamiento intensivo.</p>
                    </td>
                @endif

                @if ($test->diagnostic == '"Nivel de estrés: Estrés percibido moderado."')
                    <td class="border-dark">
                        <p class="">Este diagnóstico indica que la ansiedad del paciente es de intensidad
                            moderada y puede requerir intervención terapéutica o tratamiento.</p>
                    </td>
                @endif

                @if ($test->diagnostic == '"Nivel de estrés: Estrés percibido alto."')
                    <td class="border-dark">
                        <p class="">Este diagnóstico indica que la ansiedad del paciente es moderadamente severa
                            y puede requerir tratamiento urgente para su manejo.</p>
                    </td>
                @endif

                @if ($test->diagnostic == '"Nivel de estrés: Muy alto estrés percibido."')
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
