<div>
    <!-- Simplicity is the consequence of refined emotions. - Jean D'Alembert -->
    @php
        
        $scales = [
            'SOM' => 'Somatizaciones',
            'OBS' => 'Obsesión-Compulsión',
            'SI' => 'Sensibilidad Interpersonal',
            'DEP' => 'Depresión',
            'ANS' => 'Ansiedad',
            'HOS' => 'Hostilidad',
            'FOB' => 'Fobia',
            'PAR' => 'Paranoidismo',
            'PSIC' => 'Psicoticismo',
            'IGS' => 'Índice Global de Severidad',
            'TSP' => 'Total de Síntomas Positivos',
            'IMSP' => 'Índice de Malestar Psicológico',
        ];
        
        $test->diagnostic = json_decode($test->diagnostic, true);
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

        .vertical-text {
            transform: rotate(270deg);
            height: 4.5rem;
        }

        .indices {
            font-size: .9rem;
        }

        .bg-secondary {
            background-color: rgb(170, 170, 170) !important;
        }
    </style>
    <h3 class="font-weight-normal"><b>EL INVENTARIO DE SÍNTOMAS SCL-90-R de L. Derogatis</b></h3>
    <br>
    <p class="text-justify">
        Evaluar patrones de síntomas presentes psicológicos y psicopatológicos, tanto en población clínica como en
        población normal, obteniendo el grado de malestar subjetivo.
    </p>
    <p>
        En términos generales una persona que ha completado su escolaridad primaria lo puede
responder sin mayores dificultades. En caso de que el sujeto evidencie dificultades lectoras es
aconsejable que el examinador le lea cada uno de los ítems en voz alta.
</p><p>
En circunstancias normales su administración no requiere más de quince minutos. Se le pide a
la persona que está siendo evaluada que responda en función de cómo se ha sentido durante
los últimos siete días, incluyendo el día de hoy (el de la administración del inventario). Los
pacientes con retraso mental, ideas delirantes o trastorno psicótico son malos candidatos para
responder el SCL-90. Es aplicable a personas entre 13 y 65 años de edad.
    </p>
    <br>
    <br>
    <br>
    <br>
    <br>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th style="width: ;" class="title-table align-middle text-center" scope="col">PSS</th>
                <th class="title-table text-center" scope="col">
                    <p class="vertical-text th_p text-nowrap">Nada</p>
                </th>
                <th class="title-table text-center" scope="col">
                    <p class="vertical-text th_p text-nowrap">Muy poco</p>
                </th>
                <th class="title-table text-center" scope="col">
                    <p class="vertical-text th_p text-nowrap">Poco</p>
                </th>
                <th class="title-table text-center" scope="col">
                    <p class="vertical-text th_p text-nowrap">Bastante</p>
                </th>
                <th class="title-table text-center" scope="col">
                    <p class="vertical-text th_p text-nowrap">Mucho</p>
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
                    <td
                        class="content-table border-dark text-center align-middle @if ($question['value'] == 4) bg-secondary text-white @endif">
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
                @foreach ($test->diagnostic as $indices)
                    @if (isset($indices['indicator']))
                        <td class="border-dark indices"><b>{{ $indices['indicator'] }} </b></td>
                    @endif
                @endforeach
            </tr>


            <tr>
                @foreach ($test->diagnostic as $indices)
                    @if (isset($indices['indicator']))
                        <td class="border-dark indices"><b>{{ number_format($indices['result'], 2) }}</b></td>
                    @endif
                @endforeach
            </tr>
        </tbody>
    </table>
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
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <h5><b>Diagnóstico</b></h5>
    <br>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Índice</th>
                <th>Puntaje</th>
                <th>Diagnóstico</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($test->diagnostic as $indices)
                <tr>
                    @if (isset($indices['indicator']))
                        <td class="border-dark indices"><b>{{ $scales[$indices['indicator']] }}
                                ({{ $indices['indicator'] }})</b></td>
                        <td class="border-dark indices"><b>{{ number_format($indices['result'], 2) }}</b></td>
                        <td class="border-dark indices">
                            @php
                                $indice_value = number_format($indices['result'], 2);
                            @endphp
                            @if ($indices['indicator'] == 'SOM')
                                @if ($indice_value > 0 && $indice_value <= 1)
                                    <span class="badge badge-success">Puntuación Baja</span><br> Indica que el individuo
                                    experimenta pocos síntomas somáticos
                                    y es
                                    poco probable que haya una preocupación significativa en esta área.
                                @endif


                                @if ($indice_value > 1.8 && $indice_value <= 3)
                                    <span class="badge badge-warning">Puntuación Moderada</span><br> Sugiere una
                                    presencia moderada de síntomas somáticos.
                                    Puede
                                    ser útil explorar más a fondo para determinar si estos síntomas tienen una causa
                                    médica
                                    o están relacionados con factores emocionales.
                                @endif

                                @if ($indice_value > 3 && $indice_value <= 5)
                                    <span class="badge badge-danger">Puntuación Alta</span><br> Indica una alta
                                    presencia de síntomas somáticos. Esto puede ser
                                    una
                                    señal de que el individuo está experimentando una cantidad significativa de síntomas
                                    físicos que podrían estar relacionados con problemas emocionales o psicológicos. Se
                                    recomienda una evaluación más detallada.
                                @endif
                            @endif
                            @if ($indices['indicator'] == 'OBS')
                                @if ($indice_value >= 0 && $indice_value <= 1.8)
                                    <p><span class="badge badge-success">Puntuación Baja</span><br> Indica que el
                                        individuo experimenta pocos síntomas
                                        obsesivos y compulsivos y es poco probable que haya una preocupación
                                        significativa en esta área.</p>
                                @elseif ($indice_value > 1.8 && $indice_value <= 3)
                                    <p><span class="badge badge-warning">Puntuación Moderada</span><br> Sugiere la
                                        presencia de síntomas obsesivos y
                                        compulsivos de intensidad moderada. Puede ser útil explorar más a fondo para
                                        determinar si estos síntomas tienen un impacto significativo en la vida del
                                        individuo.</p>
                                @elseif ($indice_value >= 4)
                                    <p><span class="badge badge-danger">Puntuación Alta</span><br> Indica una presencia
                                        significativa de síntomas
                                        obsesivos y compulsivos. Se recomienda una evaluación más detallada por parte de
                                        un profesional de la salud mental.</p>
                                @else
                                    <p>La puntuación no está en un rango válido.</p>
                                @endif
                            @endif
                            @if ($indices['indicator'] == 'SI')
                                @if ($indice_value >= 0 && $indice_value <= 1.8)
                                    <p><span class="badge badge-success">Puntuación Baja</span><br> Indica que el
                                        individuo experimenta poca sensibilidad
                                        interpersonal y es poco probable que haya una preocupación significativa en esta
                                        área.</p>
                                @elseif ($indice_value >= 1.8 && $indice_value <= 3)
                                    <p><span class="badge badge-warning">Puntuación Moderada</span><br> Sugiere una
                                        presencia moderada de sensibilidad
                                        interpersonal. Puede ser útil explorar más a fondo para determinar si esta
                                        sensibilidad afecta las relaciones del individuo.</p>
                                @elseif ($indice_value >= 4)
                                    <p><span class="badge badge-danger">Puntuación Alta</span><br> Indica una alta
                                        sensibilidad interpersonal. Esto puede
                                        ser una señal de que el individuo experimenta una cantidad significativa de
                                        sensibilidad en sus relaciones interpersonales y puede requerir apoyo adicional
                                        para manejar esta sensibilidad.</p>
                                @else
                                    <p>La puntuación no está en un rango válido.</p>
                                @endif
                            @endif
                            @if ($indices['indicator'] == 'DEP')
                                @if ($indice_value >= 0 && $indice_value <= 1.8)
                                    <p><span class="badge badge-success">Puntuación Baja</span><br> Indica que el
                                        individuo experimenta pocos síntomas de
                                        depresión y es poco probable que haya una preocupación significativa en esta
                                        área.</p>
                                @elseif ($indice_value >= 1.8 && $indice_value <= 3)
                                    <p><span class="badge badge-warning">Puntuación Moderada</span><br> Sugiere una
                                        presencia moderada de síntomas de
                                        depresión. Puede ser útil explorar más a fondo para determinar si estos síntomas
                                        están afectando la calidad de vida del individuo.</p>
                                @elseif ($indice_value >= 4)
                                    <p><span class="badge badge-danger">Puntuación Alta</span><br> Indica una alta
                                        presencia de síntomas de depresión.
                                        Esto puede ser una señal de que el individuo está experimentando una cantidad
                                        significativa de síntomas depresivos y puede requerir una evaluación y apoyo
                                        adicionales por parte de un profesional de la salud mental.</p>
                                @else
                                    <p>La puntuación no está en un rango válido. {{ $indice_value }}</p>
                                @endif
                            @endif
                            @if ($indices['indicator'] == 'ANS')
                                @if ($indices['result'] >= 0 && $indices['result'] <= 1.8)
                                    <p><span class="badge badge-success">Puntuación Baja</span><br> Indica que el
                                        individuo experimenta pocos síntomas de ansiedad y
                                        es poco probable que haya una preocupación significativa en esta área.</p>
                                @elseif ($indices['result'] >= 1.8 && $indices['result'] <= 3)
                                    <p><span class="badge badge-warning">Puntuación Moderada</span><br> Sugiere una
                                        presencia moderada de síntomas de ansiedad.
                                        Puede ser útil explorar más a fondo para determinar si estos síntomas están
                                        afectando la calidad de vida del individuo.</p>
                                @elseif ($indices['result'] >= 4)
                                    <p><span class="badge badge-danger">Puntuación Alta</span><br> Indica una alta
                                        presencia de síntomas de ansiedad. Esto puede
                                        ser una señal de que el individuo está experimentando una cantidad significativa
                                        de síntomas de ansiedad y puede requerir una evaluación y apoyo adicionales por
                                        parte de un profesional de la salud mental.</p>
                                @else
                                    <p>La puntuación no está en un rango válido.</p>
                                @endif
                            @endif
                            @if ($indices['indicator'] == 'HOS')
                                @if ($indices['result'] >= 0 && $indices['result'] <= 1.8)
                                    <p><span class="badge badge-success">Puntuación Baja</span><br> Indica que el
                                        individuo experimenta pocos síntomas de hostilidad
                                        y es poco probable que haya una preocupación significativa en esta área.</p>
                                @elseif ($indices['result'] > 1.8 && $indices['result'] <= 3)
                                    <p><span class="badge badge-warning">Puntuación Moderada</span><br> Sugiere una
                                        presencia moderada de síntomas de hostilidad.
                                        Puede ser útil explorar más a fondo para determinar si estos síntomas están
                                        afectando la calidad de vida del individuo.</p>
                                @elseif ($indices['result'] > 3)
                                    <p><span class="badge badge-danger">Puntuación Alta</span><br> Indica una alta
                                        presencia de síntomas de hostilidad. Esto puede
                                        ser una señal de que el individuo está experimentando una cantidad significativa
                                        de síntomas de hostilidad y puede requerir una evaluación y apoyo adicionales
                                        por parte de un profesional de la salud mental.</p>
                                @else
                                    <p>La puntuación no está en un rango válido.</p>
                                @endif
                            @endif
                            @if ($indices['indicator'] == 'FOB')
                                @if ($indices['result'] >= 0 && $indices['result'] <= 1.8)
                                    <p><span class="badge badge-success">Puntuación Baja</span><br> Indica que el
                                        individuo experimenta pocos síntomas de fobia y es
                                        poco probable que haya una preocupación significativa en esta área.</p>
                                @elseif ($indices['result'] > 1.8 && $indices['result'] <= 3)
                                    <p><span class="badge badge-warning">Puntuación Moderada</span><br> Sugiere una
                                        presencia moderada de síntomas de fobia. Puede
                                        ser útil explorar más a fondo para determinar si estos síntomas están afectando
                                        la calidad de vida del individuo.</p>
                                @elseif ($indices['result'] > 3)
                                    <p><span class="badge badge-danger">Puntuación Alta</span><br> Indica una alta
                                        presencia de síntomas de fobia. Esto puede ser
                                        una señal de que el individuo está experimentando una cantidad significativa de
                                        síntomas de fobia y puede requerir una evaluación y apoyo adicionales por parte
                                        de un profesional de la salud mental.</p>
                                @else
                                    <p>La puntuación no está en un rango válido.</p>
                                @endif
                            @endif
                            @if ($indices['indicator'] == 'PAR')
                                @if ($indices['result'] >= 0 && $indices['result'] <= 1.8)
                                    <p><span class="badge badge-success">Puntuación Baja</span><br> Indica que el
                                        individuo experimenta pocos síntomas de paranoia y
                                        es poco probable que haya una preocupación significativa en esta área.</p>
                                @elseif ($indices['result'] > 1.8 && $indices['result'] <= 3)
                                    <p><span class="badge badge-warning">Puntuación Moderada</span><br> Sugiere una
                                        presencia moderada de síntomas de paranoia.
                                        Puede ser útil explorar más a fondo para determinar si estos síntomas están
                                        afectando la calidad de vida del individuo.</p>
                                @elseif ($indices['result'] > 3)
                                    <p><span class="badge badge-danger">Puntuación Alta</span><br> Indica una alta
                                        presencia de síntomas de paranoia. Esto puede
                                        ser una señal de que el individuo está experimentando una cantidad significativa
                                        de síntomas de paranoia y puede requerir una evaluación y apoyo adicionales por
                                        parte de un profesional de la salud mental.</p>
                                @else
                                    <p>La puntuación no está en un rango válido.</p>
                                @endif
                            @endif
                            @if ($indices['indicator'] == 'PSIC')
                                @if ($indices['result'] >= 0 && $indices['result'] <= 1.8)
                                    <p><span class="badge badge-success">Puntuación Baja</span><br> Indica que el
                                        individuo experimenta pocos síntomas psicóticos y
                                        es poco probable que haya una preocupación significativa en esta área.</p>
                                @elseif ($indices['result'] > 1.8 && $indices['result'] <= 3)
                                    <p><span class="badge badge-warning">Puntuación Moderada</span><br> Sugiere una
                                        presencia moderada de síntomas psicóticos. Puede
                                        ser útil explorar más a fondo para determinar si estos síntomas están afectando
                                        la calidad de vida del individuo.</p>
                                @elseif ($indices['result'] > 3)
                                    <p><span class="badge badge-danger">Puntuación Alta</span><br> Indica una alta
                                        presencia de síntomas psicóticos. Esto puede ser
                                        una señal de que el individuo está experimentando una cantidad significativa de
                                        síntomas psicóticos y puede requerir una evaluación y apoyo adicionales por
                                        parte de un profesional de la salud mental.</p>
                                @else
                                    <p>La puntuación no está en un rango válido.</p>
                                @endif
                            @endif
                            @if ($indices['indicator'] == 'IGS')
                                @if ($indices['result'] >= 0 && $indices['result'] <= 1.8)
                                    <p><span class="badge badge-success">Puntuación Baja</span><br> Indica que el
                                        individuo experimenta pocos síntomas de ideas de
                                        grandeza (grandiosidad) y es poco probable que haya una preocupación
                                        significativa en esta área.</p>
                                @elseif ($indices['result'] > 1.8 && $indices['result'] <= 3)
                                    <p><span class="badge badge-warning">Puntuación Moderada</span><br> Sugiere una
                                        presencia moderada de síntomas de ideas de
                                        grandeza. Puede ser útil explorar más a fondo para determinar si estos síntomas
                                        están afectando la calidad de vida del individuo.</p>
                                @elseif ($indices['result'] > 3)
                                    <p><span class="badge badge-danger">Puntuación Alta</span><br> Indica una alta
                                        presencia de síntomas de ideas de grandeza. Esto
                                        puede ser una señal de que el individuo está experimentando una cantidad
                                        significativa de síntomas de ideas de grandeza y puede requerir una evaluación y
                                        apoyo adicionales por parte de un profesional de la salud mental.</p>
                                @else
                                    <p>La puntuación no está en un rango válido.</p>
                                @endif
                            @endif
                            @if ($indices['indicator'] == 'TSP')
                                <p>
                                    Este indicador no se categoriza en niveles específicos, ya que simplemente suma la
                                    presencia de síntomas en todas las escalas. Una puntuación más alta en el TSP indica
                                    una mayor cantidad de síntomas psicológicos experimentados por el individuo en las
                                    diferentes áreas evaluadas por el cuestionario (8-85).</p>
                            @endif
                            @if ($indices['indicator'] == 'IMSP')
                                @if ($indices['result'] >= 0 && $indices['result'] <= 1.8)
                                    <p><span class="badge badge-success">Puntuación Baja</span><br> Indica que el
                                        individuo experimenta pocos síntomas de ítems
                                        impropios (pensamientos extraños o inapropiados) y es poco probable que haya una
                                        preocupación significativa en esta área.</p>
                                @elseif ($indices['result'] > 1.8 && $indices['result'] <= 3)
                                    <p><span class="badge badge-warning">Puntuación Moderada</span><br> Sugiere una
                                        presencia moderada de síntomas de ítems
                                        impropios. Puede ser útil explorar más a fondo para determinar si estos síntomas
                                        están afectando la calidad de vida del individuo.</p>
                                @elseif ($indices['result'] > 3)
                                    <p><span class="badge badge-danger">Puntuación Alta</span><br> Indica una alta
                                        presencia de síntomas de ítems impropios. Esto
                                        puede ser una señal de que el individuo está experimentando una cantidad
                                        significativa de síntomas de ítems impropios y puede requerir una evaluación y
                                        apoyo adicionales por parte de un profesional de la salud mental.</p>
                                @else
                                    <p>La puntuación no está en un rango válido.</p>
                                @endif
                            @endif
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
    <br>
</div>
