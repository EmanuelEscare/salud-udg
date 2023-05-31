<div>
    {{-- Do your work, then step back. --}}
    <div class="rounded-4 p-4">
        <h3 class="">{{ __('Pacientes') }}</h3>
        <br>
        @php
            $date = new DateTime();
        @endphp
        <div class="py-2">
            <div class="input-group mb-3">
                <input class="form-control form-control-lg" wire:model="query" wire:keyup="search" type="text"
                    placeholder="">
                <span class="input-group-text">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
            </div>
        </div>
        <div class="table-responsive table-padding">
            <table class="table table-bordered table-hover table-striped mt-5">
                <thead class="border">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Edad</th>
                        <th scope="col">Sexo</th>
                        <th scope="col">Contacto</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($patients as $patient)
                        <tr>
                            <th class="align-middle text-center" scope="row">{{ $patient->id }}</th>
                            <td class="align-middle text-center">
                                {{ $patient->name }}
                            </td>
                            <td class="align-middle text-center">
                                @php
                                    $birth = new DateTime($patient->birth_date);
                                @endphp
                                {{ $date->diff($birth)->y }}
                            </td>
                            <td class="fs-4 align-middle text-center">
                                @if ($patient->sex == 'male')
                                    <i class="fa-solid fa-mars text-info"></i>
                                @endif
                                @if ($patient->sex == 'female')
                                    <i class="fa-solid fa-venus text-pink"></i>
                                @endif
                                @if ($patient->sex == 'other')
                                    <i class="fa-solid fa-venus-mars text-secondary"></i>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <a class="text-decoration-none fw-bold link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                    href="mailto: {{ $patient->email }}">{{ $patient->email }}</a>
                                <br>
                                <br>
                                <a class="text-decoration-none fw-bold link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                    href="tel:+ {{ $patient->phone }}">{{ $patient->phone }}</a>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn my-1 btn-primary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Aplicar prueba
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item"
                                                wire:click="test('1','{{ $patient->id }}')">SCL-90-R</a></li>
                                        <li><a class="dropdown-item"
                                                wire:click="test('1','{{ $patient->id }}')">Inventario de Depresión de
                                                Beck (BDI-2)</a></li>
                                        <li><a class="dropdown-item"
                                                wire:click="test('1','{{ $patient->id }}')">Escala
                                                de ansiedad de Hamilton</a></li>

                                    </ul>
                                </div>

                                <button type="button" wire:click="testsPatient({{ $patient->id }})"
                                    class="btn my-1 btn-secondary"> Pruebas <i class="fa-solid fa-file"></i>
                                </button>

                                <button type="button" wire:click="editPatient({{ $patient->id }})" class="btn my-1 btn-warning"> Editar <i
                                        class="fa-solid fa-pen-to-square"></i></button>

                                @if ($confirming === $patient->id)
                                    <button type="button" wire:click="delete({{ $patient->id }})"
                                        class="btn my-1 btn-danger fa-fade">¿Seguro?</button>
                                @else
                                    <button type="button" wire:click="confirmDelete({{ $patient->id }})"
                                        class="btn my-1 btn-danger">Eliminar <i class="fa-solid fa-trash"></i></button>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div class="btn-group mt-3 border" role="group" aria-label="Basic example">
            <button type="button" wire:click="afterPage" class="btn border-end"><i
                    class="fa-solid fa-arrow-left"></i></button>
            <button type="button" wire:click="nextPage" class="btn border-start"><i
                    class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>

    <!-- Modal View Tests-->
    <div class="modal fade" wire:ignore.self id="openModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            @if ($now_patient)
                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h3 class="">Pruebas - {{ $now_patient->name }}</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row border-secondary">
                            @foreach ($now_patient->tests as $test)
                                <div class="col-lg-6 py-2 text-center text-nowrap">
                                    {{ $test->test }}
                                </div>
                                <div class="col-lg-3 py-2 text-center">
                                    {{ date('d/M/Y', strtotime($test->created_at)) }}
                                </div>
                                <div class="col-lg-3">
                                    <div class="d-grid gap-2">
                                        <a class="btn btn-secondary" href=""> Resultados <i
                                                class="fa-solid fa-file"></i></a>
                                    </div>
                                </div>
                                <hr class="my-2">
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Edit Patient -->
    <div class="modal fade" wire:ignore.self id="openModalEdit" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            @if ($now_patient)
                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h3 class="">Editar - {{ $now_patient->name }}</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row border-secondary">

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    {{-- Notification --}}
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="notification" class="toast align-items-center text-bg-success border-0" role="alert"
            aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    {{ $message_notification }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('notification', event => {
            $("#notification").toast('show');
        })
  
        window.addEventListener('openModal', event => {
            $("#openModal").modal('show');
        })

        window.addEventListener('openModalEdit', event => {
            $("#openModalEdit").modal('show');
        })
        
    </script>
</div>
