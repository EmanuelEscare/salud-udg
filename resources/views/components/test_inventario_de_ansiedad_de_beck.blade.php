<div>
    <!-- Simplicity is the consequence of refined emotions. - Jean D'Alembert -->
    @php
        $test->diagnostic = json_decode($test->diagnostic);
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
    <h3 class="font-weight-normal"><b>INVENTARIO DE ANSIEDAD DE BECK (BAI)</b></h3>
    <br>
    <p class="text-justify">
        El BAI se construyó con la intención de disponer de una medida de ansiedad clínica que a su vez permitiera
        discriminar la ansiedad de la depresión. Según el análisis de su validez de contenido realizado por Sanz y
        Navarro (2003), el BAI se distingue, en cuanto a su contenido, por evaluar sobre todo síntomas fisiológicos: 14
        de sus 21 ítems (el 67%) se refieren a síntomas fisiológicos, mientras que sólo 4 de sus ítems evalúan aspectos
        cognitivos y 3 aspectos afectivos. Por otro lado, 19 de los 21 ítems del BAI (el 90%) se refieren a síntomas
        característicos de las crisis de angustia o pánico.
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
                @if ($test->diagnostic == 'Ansiedad mínima')
                    <th class="text-center border-dark bg-success">
                        {{ $test->diagnostic }}
                    </th>
                @endif
                @if ($test->diagnostic == 'Ansiedad leve')
                    <th class="text-center border-dark text-dark bg-light">
                        {{ $test->diagnostic }}
                    </th>
                @endif
                @if ($test->diagnostic == 'Ansiedad moderada')
                    <th class="text-center text-dark border-dark bg-warning">
                        {{ $test->diagnostic }}
                    </th>
                @endif
                @if ($test->diagnostic == 'Ansiedad severa')
                    <th class="text-center border-dark bg-danger">
                        {{ $test->diagnostic }}
                    </th>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                @if ($test->diagnostic == 'Ansiedad mínima')
                <td class="border-dark">
                    <p class="">El nivel de ansiedad es mínimo. No se observan síntomas significativos de ansiedad en este momento.</p>
                </td>
            @endif
            
            @if ($test->diagnostic == 'Ansiedad leve')
                <td class="border-dark">
                    <p class="">Se observan síntomas leves de ansiedad. Puede ser útil seguir monitorizando la situación y considerar estrategias de manejo del estrés.</p>
                </td>
            @endif
            
            @if ($test->diagnostic == 'Ansiedad moderada')
                <td class="border-dark">
                    <p class="">La ansiedad se encuentra en un nivel moderado. Es importante considerar el apoyo y la posible intervención para abordar estos síntomas.</p>
                </td>
            @endif
            
            @if ($test->diagnostic == 'Ansiedad severa')
                <td class="border-dark">
                    <p class="">La ansiedad es severa y puede estar afectando significativamente la vida diaria. Se recomienda una evaluación más detallada y una intervención profesional.</p>
                </td>
            @endif            
            </tr>
        </tbody>
    </table>
    <br>
</div>
