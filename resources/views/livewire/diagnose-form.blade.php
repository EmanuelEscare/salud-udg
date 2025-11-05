<div class="mx-auto space-y-2">
    <div class="row m-1">
        <div class="col-lg-7 space-y-4 mb-4">
            <div class="card p-4">
                <h1 class="h4 mb-2 fw-semibold text-slate-800">Sistema experto CBR (Case-Based Reasoning Method)</h1>
                <p class="text-muted mb-3">Busca síntomas, añádelos y obtén propuestas. Luego puedes guardar el caso.</p>

                {{-- Search symptoms --}}
                <div class="position-relative">
                    <div wire:ignore>
                        <select class="select-symptom form-select form-select-lg" style="width: 100%  height: 44px;"
                            data-placeholder="Busca síntomas ...">
                        </select>
                    </div>

                    {{-- LEGACY --}}
                    {{-- <input type="text"
                           class="form-control"
                           placeholder="Busca síntomas (ej. insomnio)…"
                           wire:model.debounce.400ms="query" /> --}}

                    {{-- Suggestions (dropdown) --}}
                    {{-- @if (!empty($suggestions))
                        <ul class="list-group position-absolute w-100 mt-1 shadow rounded-2"
                            style="max-height: 280px; overflow:auto; z-index:1080;">
                            @foreach ($suggestions as $s)
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
                    @endif --}}
                </div>

                {{-- Selects --}}
                @if (!empty($selectedSymptoms))
                    <div class="d-flex flex-wrap gap-2 my-3">
                        @foreach ($selectedSymptoms as $s)
                            <span
                                class="inline-flex items-center gap-2 px-3 py-1 rounded-full mt-1 bg-gray-200 text-slate-700 shadow-sm">
                                <span class="fw-semibold">{{ $s['name'] }}</span>
                                <span class="badge bg-secondary">{{ $s['code'] }}</span>
                                <span class="text-muted small">Cat: {{ $s['category_code'] }}</span>

                                {{-- (Opcional) pesos — los dejamos ocultos por simplicidad; si quieres sliders, habilita esto:
                                <input type="number" step="0.1" min="0" class="form-control form-control-sm w-20"
                                       wire:model.lazy="weights.{{ $s['code'] }}" />
                                --}}

                                <button type="button"
                                    class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-red-600 text-white text-xs font-medium
                                            hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2
                                            transition-colors duration-200"
                                    wire:click="removeSymptom('{{ $s['code'] }}')" aria-label="Eliminar síntoma">
                                    <i class="fa-solid fa-x"></i>
                                </button>
                            </span>
                        @endforeach
                    </div>
                @endif

                {{-- Messages --}}
                <div class="my-2">
                    @if ($errorMsg)
                        <div class="alert alert-danger alert-dismissible fade show d-flex align-items-start gap-2"
                            role="alert">
                            <div>
                                {{ $errorMsg }}
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                aria-label="Cerrar"></button>
                        </div>
                    @endif

                    @if ($successMsg)
                        <div class="alert alert-success alert-dismissible fade show d-flex align-items-start gap-2"
                            role="alert">
                            <div>
                                {{ $successMsg }}
                            </div>
                            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                                aria-label="Cerrar"></button>
                        </div>
                    @endif
                </div>

                {{-- Actions --}}
                <div class="my-2">
                    <div class="d-grid gap-2">
                        <button wire:click="diagnose" wire:loading.attr="disabled" class="btn btn-primary">
                            <span wire:loading.remove>Buscar</span>
                            <span wire:loading class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true"></span>
                        </button>
                    </div>

                    {{-- Notes --}}
                    <div class="mt-2">
                        {{-- <div class="flex-1">
                            <input type="text" class="form-control" placeholder="Notas (opcional)" wire:model.defer="notes">
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- RESULTS --}}
        <div class="col-lg-5 space-y-4">
            {{-- @if (!empty($proposals)) --}}
            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-semibold">Propuestas</span>
                    @if ($consultId)
                        <span class="badge bg-light text-dark">Consulta ID: {{ $consultId }}</span>
                    @endif
                </div>
                <div class="card-body">
                    @forelse($proposals as $i => $p)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="fw-bold">
                                    #{{ $i + 1 }}
                                    @php
                                        $dcode = $p['disease_code'] ?? '';
                                        $dname = $diseasesByCode[$dcode] ?? null;
                                    @endphp
                                    · {{ $dcode }} {!! $dname ? '<span class="text-muted">— ' . $dname . '</span>' : '' !!}
                                </div>
                                <span class="badge bg-success">
                                    similitud {{ number_format($p['similarity'] ?? 0, 2) }}
                                </span>
                            </div>

                            <div class="row mt-2 g-3">
                                <div class="col-md-6">
                                    <div class="small text-muted mb-1">Coinciden</div>
                                    <div class="bg-light p-2 rounded-2 small">
                                        @foreach ($p['matched_symptoms'] as $code)
                                            <b>{{$code}}</b>
                                            {{$this->symptoms->where('code', $code)->first()['name'] ?? ''}}                                        
                                            <br>
                                        @endforeach
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
                            @if (!empty($sols))
                                <div class="mt-3">
                                    <div class="fw-semibold">Sugerencias (soluciones)</div>
                                    <ul class="mb-0 ps-3">
                                        @foreach ($sols as $name)
                                            <li>{{ $name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mt-3">
                                <button class="btn btn-outline-primary"
                                    wire:click="openModalRetainCase({{ $i }})" data-bs-toggle="modal"
                                    data-bs-target="#retainCaseModal" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="openModalRetainCase">Guardar como caso</span>
                                    <span wire:loading wire:target="openModalRetainCase"
                                        class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="m-3">
                            <div class="alert alert-warning" role="alert">
                                <div class="text-muted small">
                                    No hay propuestas para mostrar. Añade síntomas y haz clic en "Buscar" para obtener
                                    sugerencias.
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
            {{-- @endif --}}
        </div>
    </div>

    @include('partials.cbr._add_case_modal')

    {{-- Notification --}}
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="notification" class="toast align-items-center text-bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ $mesage_notification }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script type="module">
        document.addEventListener("DOMContentLoaded", () => {
            window.addEventListener('notification', event => {
                $("#notification").toast('show');
            })
        });
    </script>

    @push('scripts')
        <script type="module">
            document.addEventListener("DOMContentLoaded", () => {
                jQ(document).ready(function() {
                    jQ('.select-symptom').select2({
                        theme: 'bootstrap-5',
                        ajax: {
                            delay: 250,
                            transport: function(params, success, failure) {
                                const q = (params.data && params.data.q) ? params.data.q : '';

                                @this.call('loadSymptoms', q)
                                    .then(function(data) {
                                        success(data);
                                    })
                                    .catch(function(e) {
                                        failure(e);
                                    });

                                return {
                                    abort: function() {}
                                };
                            },
                            processResults: function(data) {
                                return data;
                            }
                        }
                    });

                    // SELECT SYMPTOM
                    jQ('.select-symptom').on('change', function() {
                        const val = jQ(this).val();
                        if (val) {
                            @this.call('addSymptom', val);
                            jQ('.select-symptom').val(null).trigger('change');
                        }
                    });

                    // CLEAR SELECT SYMPTOM
                    // Livewire.on('addSymptom', function () {
                    //     alert('clear');
                    //     jQ('.select-symptom').val(null).trigger('change');
                    // });
                });
            });
        </script>
    @endpush
</div>
