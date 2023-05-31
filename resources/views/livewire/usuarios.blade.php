<div>
    {{-- Do your work, then step back. --}}
    <div class="rounded-4 p-4">
        <h3 class="">{{ __('Usuarios') }}</h3>
        <br>
        <div class="py-2">
            <div class="input-group mb-3">
                <input class="form-control form-control-lg" wire:model="query" wire:keyup="search" type="text" placeholder="">
                <span class="input-group-text">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped mt-5">
                <thead class="border">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    @foreach ($users as $user)
                        <tr>
                            <th class="align-middle" scope="row">{{ $user->id }}</th>
                            <td class="align-middle">
                                {{ $user->name }}
                            </td>
                            <td class="align-middle">
                                {{ $user->email }}
                            </td>
                            <td class="dropdown text-center">
                                <button class="btn my-1 btn-secondary dropdown-toggle text-capitalize" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ __($user->getRoleNames()->first()) }}
                                </button>
                                <ul class="dropdown-menu text-center">
                                    <li><a class="dropdown-item" wire:click="changeRole('{{$user->id}}','{{$user->getRoleNames()->first()}}', 'admin')">{{__("Administrador")}}</a></li>
                                    <li><a class="dropdown-item" wire:click="changeRole('{{$user->id}}','{{$user->getRoleNames()->first()}}', 'usuario')">{{__("Usuario")}}</a></li>
                                </ul>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn my-1 btn-warning"> Editar <i
                                        class="fa-solid fa-pen-to-square"></i></button>
                                        
                                            @if ($confirming === $user->id)
                                                <button type="button" wire:click="delete({{ $user->id }})" class="btn my-1 btn-danger fa-fade">¿Seguro?</button>
                                            @else
                                                <button type="button" wire:click="confirmDelete({{ $user->id }})" class="btn my-1 btn-danger">Eliminar <i class="fa-solid fa-trash"></i></button>
                                            @endif
                                        
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <div class="btn-group mt-3 border" role="group" aria-label="Basic example">
            <button type="button" wire:click="afterPage" class="btn border-end"><i class="fa-solid fa-arrow-left"></i></button>
            <button type="button" wire:click="nextPage" class="btn border-start"><i class="fa-solid fa-arrow-right"></i></button>
        </div>
    </div>

        {{-- Notification --}}
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="notification" class="toast align-items-center text-bg-success border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{$mesage_notification}}
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
