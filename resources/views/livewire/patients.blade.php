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
        <table class="table table-bordered table-hover table-striped mt-5">
            <thead class="border">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Edad</th>
                    <th scope="col">Sexo</th>
                    <th scope="col">Email</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Acción</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">
                @foreach ($patients as $patient)
                    <tr>
                        <th scope="row">{{ $patient->id }}</th>
                        <td>
                            {{ $patient->name }}
                        </td>
                        <td>
                            @php
                                $birth = new DateTime($patient->birth_date);
                            @endphp
                            {{ $date->diff($birth)->y }}
                        </td>
                        <td class="text-center fs-4">
                            @if ($patient->sex == 'female')
                                <i class="fa-solid fa-mars text-info"></i>
                            @endif
                            @if ($patient->sex == 'male')
                                <i class="fa-solid fa-venus text-pink"></i>
                            @endif
                            @if ($patient->sex == 'other')
                                <i class="fa-solid fa-venus-mars text-secondary"></i>
                            @endif
                        </td>
                        <td>
                            {{ $patient->email }}
                        </td>
                        <td>
                            {{ $patient->phone }}
                        </td>
                        <td class="text-center">
                            <button type="button" class="btn btn-lg btn-primary"> Prueba - SCL-90-R
                                 <i class="fa-solid fa-file-pen"></i></button>

                            <button type="button" class="btn btn-lg btn-warning"> Editar <i
                                    class="fa-solid fa-pen-to-square"></i></button>

                            @if ($confirming === $patient->id)
                                <button type="button" wire:click="delete({{ $patient->id }})"
                                    class="btn btn-lg btn-danger fa-fade">¿Seguro?</button>
                            @else
                                <button type="button" wire:click="confirmDelete({{ $patient->id }})"
                                    class="btn btn-lg btn-danger">Eliminar <i class="fa-solid fa-trash"></i></button>
                            @endif

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="btn-group mt-3 border" role="group" aria-label="Basic example">
            <button type="button" wire:click="afterPage" class="btn border-end"><i
                    class="fa-solid fa-arrow-left"></i></button>
            <button type="button" wire:click="nextPage" class="btn border-start"><i
                    class="fa-solid fa-arrow-right"></i></button>
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
    </script>
</div>
