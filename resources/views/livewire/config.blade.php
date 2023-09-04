<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="card border-0 shadow-sm container ps-none">
        <div>
            <div>
                {{-- Do your work, then step back. --}}
                <div class="rounded-4 p-4">
                    <h3 class="mb-5">{{ __('Configuración') }}</h3>
                    <br>
                    <div
                        class="d-flex justify-content-center align-items-centerd-flex justify-content-center align-items-center">
                        <div class="m-3 col-lg-6">
                            <p class="m-1">Folio</p>
                            <input wire:model="folio" class="form-control form-control-lg" type="text">

                            <div class="d-grid gap-2 mt-2">
                                <button wire:click="updateFolio" class="btn btn-lg btn-primary"
                                    type="button">Guardar</button>
                            </div>

                        </div>
                    </div>

                    <div class="my-5">
                    </div>
                    <div
                        class="d-flex mb-5 justify-content-center align-items-centerd-flex justify-content-center align-items-center">
                        <div class="m-3 col-lg-6 box-danger">
                            <div class="row">
                                <div class="col-lg-6 text-center">
                                    <p class="m-3">Restablecer plataforma</p>
                                </div>
                                <div class="col-lg-2">
                                </div>
                                <div class="col-lg-2 text-center">
                                    <a href="{{ route('backup') }}" class="btn btn-danger my-2"
                                        onclick="return confirm('¿Estás seguro de que deseas restablecer?')">Restablecer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
