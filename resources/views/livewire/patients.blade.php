<div>
    {{-- Do your work, then step back. --}}
    <div class="rounded-4 p-4">
        <h3 class="">{{ __('Pacientes') }}</h3>
        <br>
        @php
            $date = new DateTime();
        @endphp
        <div class="py-2">
            <div class="row">
                <div class="col-lg-9">
                    <div class="input-group mb-3 ps-none">
                        <input class="form-control form-control-lg ps-none" wire:model="query" wire:keyup="search"
                            type="text" placeholder="">
                        <span class="input-group-text">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </span>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="d-grid gap-2">
                        @if (Auth::user()->hasPermissionTo('patient_update'))
                            <button wire:click="formNewPatient" class="btn btn-lg btn-success">
                                Registrar paciente
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive table-padding">
            <table class="table table-bordered table-hover table-striped mt-5">
                <thead class="border">
                    <tr>
                        <th class="text-center" scope="col">#</th>
                        <th class="text-center" scope="col">Nombre</th>
                        <th class="text-center" scope="col">Sexo</th>
                        <th class="text-center" scope="col">Información</th>
                        <th class="text-center" scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($patients as $patient)
                        <tr>
                            <th class="align-middle text-center" scope="row">
                                <p>
                                    {{ $patient->code }}
                                </p>
                            </th>
                            <td class="align-middle text-center">
                                <p>
                                    {{ $patient->name }}
                                </p>
                            </td>
                            {{-- @php
                                    $birth = new DateTime($patient->birth_date);
                                @endphp
                                {{ $date->diff($birth)->y }} --}}
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
                                <button type="button" wire:click="infoPatient({{ $patient->id }})"
                                    class="btn my-1 btn-light border"> Ver detalle
                                </button>
                                {{-- <a class="text-nowrap text-decoration-none fw-bold link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                    href="mailto: {{ $patient->email }}">{{ $patient->email }} <i
                                        class="fa-solid fa-envelope"></i></a>
                                <br>
                                <br>
                                <a class="text-nowrap text-decoration-none fw-bold link-secondary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover"
                                    href="tel:+ {{ $patient->phone }}">{{ $patient->phone }} <i
                                        class="fa-solid fa-phone-flip"></i></a> --}}
                            </td>
                            <td class="text-center">
                                <div class="dropdown ps-none" style="display: inline-block;">
                                    <button class="btn my-1 btn-primary dropdown-toggle" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        Aplicar prueba
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" wire:click="test('1','{{ $patient->id }}')">
                                                Inventario de Depresión de Beck (BDI-2)
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" wire:click="test('2','{{ $patient->id }}')">
                                                SCL-90-R
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" wire:click="test('3','{{ $patient->id }}')">
                                                Inventario de Ansiedad de Beck
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" wire:click="test('4','{{ $patient->id }}')">
                                            Escala de Estrés Percibido (PSS, Perceived Stress Scale)
                                        </a>
                                    </li>
                                        <li>
                                            <a class="dropdown-item" wire:click="test('5','{{ $patient->id }}')">
                                            Escala de ansiedad de Hamilton
                                        </a>
                                    </li>
                                    </ul>
                                </div>

                                <button type="button" wire:click="testsPatient({{ $patient->id }})"
                                    class="btn my-1 btn-secondary"> Pruebas <i class="fa-solid fa-file"></i>
                                </button>

                                @if (Auth::user()->hasPermissionTo('patient_update'))
                                    <button type="button" wire:click="editPatient({{ $patient->id }})"
                                        class="btn my-1 btn-warning"> Editar <i
                                            class="fa-solid fa-pen-to-square"></i></button>
                                @endif

                                @if (Auth::user()->hasPermissionTo('patient_delete'))
                                    @if ($confirming === $patient->id)
                                        <button type="button" wire:click="delete({{ $patient->id }})"
                                            class="btn my-1 btn-danger fa-fade">¿Seguro?</button>
                                    @else
                                        <button type="button" wire:click="confirmDelete({{ $patient->id }})"
                                            class="btn my-1 btn-danger">Eliminar <i
                                                class="fa-solid fa-trash"></i></button>
                                    @endif
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

    <!-- Modal View Info-->
    <div class="modal fade" wire:ignore.self id="modalDetails" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            @if ($now_patient)
                <div class="modal-content border-0 shadow">
                    <div class="modal-header">
                        <h3 class="">Información - {{ $now_patient->name }}</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row border-secondary">
                            <p><span class="fw-bold">Nombre</span>: {{ $now_patient->name }}</p>
                            <p><span class="fw-bold">Código</span>: {{ $now_patient->code }}</p>
                            <p><span class="fw-bold">Edad</span>: @php
                                $birth = new DateTime($patient->birth_date);
                            @endphp
                                {{ $date->diff($birth)->y }} años</p>
                            <p><span class="fw-bold">Sexo</span>: @if ($now_patient->sex == 'male')
                                    <i class="fa-solid fa-mars text-info"></i>
                                @endif
                                @if ($now_patient->sex == 'female')
                                    <i class="fa-solid fa-venus text-pink"></i>
                                @endif
                                @if ($now_patient->sex == 'other')
                                    <i class="fa-solid fa-venus-mars text-secondary"></i>
                                @endif
                            </p>
                            <p><span class="fw-bold">Email</span>: {{ $now_patient->email }}</p>
                            <p><span class="fw-bold">Teléfono</span>: {{ $now_patient->phone }}</p>
                            <p><span class="fw-bold">Estado civil</span>: {{ $now_patient->civil_status }}</p>
                            <p><span class="fw-bold">Educación</span>: {{ $now_patient->education }}</p>
                            <p><span class="fw-bold">Ocupación</span>: {{ $now_patient->occupation }}</p>
                        </div>
                    </div>
                </div>
            @endif
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
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
                                        <a class="btn btn-secondary" href="https://social.test/result"> Resultado <i
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

    <!-- Modal New Patient-->
    <div class="modal fade" wire:ignore.self id="modalAdd" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow">
                <form wire:submit.prevent="saveNewPatient">
                    <div class="modal-header">
                        <h3 class="">Nuevo paciente</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="col-lg-9 m-auto">
                            <p class="m-1">Nombre</p>
                            <input wire:model="patient.name" class="form-control form-control-lg" type="text">
                            <br>
                            <p class="m-1">Fecha de nacimiento</p>
                            <input wire:model="patient.birth_date" type="date"
                                class="form-control form-control-lg" type="text">
                            <br>
                            <p class="m-1">Código</p>
                            <input wire:model="patient.code" class="form-control form-control-lg" type="text">
                            <br>
                            <p class="m-1">Sexo</p>
                            <select wire:model="patient.sex" class="form-control form-control-lg">
                                <option value="female">Mujer
                                </option>
                                <option value="male">Hombre
                                </option>
                                <option value="other">Otro
                                </option>
                            </select>
                            <br>
                            <p class="m-1">Email</p>
                            <input wire:model="patient.email" class="form-control form-control-lg" type="text">
                            <br>
                            <p class="m-1">Teléfono</p>
                            <input wire:model="patient.phone" class="form-control form-control-lg" type="text">
                            <br>
                            @if ($errors->any())
                                <div class="my-3">
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            @endif
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-lg btn-primary">Guardar paciente</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Patient -->
    <div class="modal fade" wire:ignore.self id="openModalEdit" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            @if ($now_patient)
                <div class="modal-content border-0 shadow">
                    <form wire:submit.prevent="formEditPatient">
                        <div class="modal-header">
                            <h3 class="">Editar - {{ $now_patient->name }}</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="col-lg-9 m-auto">
                                <p class="m-1">Nombre</p>
                                <input wire:model="patient.name" class="form-control form-control-lg" type="text">
                                <br>
                                <p class="m-1">Fecha de nacimiento</p>
                                <input wire:model="patient.birth_date" type="date"
                                    class="form-control form-control-lg" type="text">
                                <br>
                                <p class="m-1">Código</p>
                                <input wire:model="patient.code" class="form-control form-control-lg" type="text">
                                <br>
                                <p class="m-1">Sexo</p>
                                <select wire:model="patient.sex" class="form-control form-control-lg">
                                    <option {{ $patient->sex == 'female' ? 'selected' : '' }} value="female">Mujer
                                    </option>
                                    <option {{ $patient->sex == 'male' ? 'selected' : '' }} value="male">Hombre
                                    </option>
                                    <option {{ $patient->sex == 'other' ? 'selected' : '' }} value="other">Otro
                                    </option>
                                </select>
                                <br>
                                <p class="m-1">Email</p>
                                <input wire:model="patient.email" class="form-control form-control-lg"
                                    type="text">
                                <br>
                                <p class="m-1">Teléfono</p>
                                <input wire:model="patient.phone" class="form-control form-control-lg"
                                    type="text">
                                <br>
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-lg btn-primary">Guardar cambios</button>
                                </div>
                            </div>
                        </div>
                    </form>
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

        window.addEventListener('closeModal', event => {
            $("#openModal").modal('show');
        })

        window.addEventListener('openModalEdit', event => {
            $("#openModalEdit").modal('show');
        })

        window.addEventListener('closeModalEdit', event => {
            $("#openModalEdit").modal('hide');
        })

        window.addEventListener('modalAdd', event => {
            $("#modalAdd").modal('show');
        })

        window.addEventListener('closeModalAdd', event => {
            $("#modalAdd").modal('hide');
        })

        window.addEventListener('modalDetails', event => {
            $("#modalDetails").modal('show');
        })

        window.addEventListener('closeModalDetails', event => {
            $("#modalDetails").modal('hide');
        })
    </script>
</div>
