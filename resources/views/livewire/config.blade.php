<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="card border-0 shadow-sm container ps-none">
        <div>
            <div>
                {{-- Do your work, then step back. --}}
                <div class="rounded-4 p-4">
                    <h3 class="mb-5">{{ __('Configuración') }}</h3>
                    <br>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="m-3 col-lg-6">
                            <h5 class="text-dark-emphasis"><b>Horario de atención</b></h5>
                            <br>
                            <label for="" class="form-label">Matutino</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="time" class="form-control" id="" wire:model="startMorning"
                                        aria-describedby="">
                                    @error('startMorning')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <input type="time" class="form-control" id="" wire:model="endMorning"
                                        aria-describedby="">
                                    @error('endMorning')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <label for="" class="form-label">Vespertino</label>
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="time" class="form-control" id=""
                                        wire:model="startAfternoon" aria-describedby="">
                                    @error('startAfternoon')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <input type="time" class="form-control" id="" wire:model="endAfternoon"
                                        aria-describedby="">
                                    @error('endAfternoon')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <br>
                            <div class="d-grid gap-2 mt-2">
                                <button wire:click="updateAttentionHours" class="btn btn-lg btn-primary"
                                    type="button">Guardar horario</button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="m-3 col-lg-6">
                            <h5 class="text-dark-emphasis"><b>Dias de atención</b></h5>
                            <br>
                            @foreach ($days as $day => $isActive)
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                        id="flexSwitchCheck{{ ucfirst($translateDays[$day]) }}" wire:model="days.{{ $day }}">
                                    <label class="form-check-label"
                                        for="flexSwitchCheckDefault">{{ ucfirst($translateDays[$day]) }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <br>
                    <br>
                    <div
                        class="d-flex justify-content-center align-items-centerd-flex justify-content-center align-items-center">
                        <div class="m-3 col-lg-6">
                            <h5 class="text-dark-emphasis"><b>Configuración de la plataforma</b></h5>
                            <br>
                            <p class="m-1">Folio</p>
                            <input wire:model="folio" class="form-control form-control-lg" type="text">

                            <div class="d-grid gap-2 mt-2">
                                <button wire:click="updateFolio" class="btn btn-lg btn-primary" type="button">Guardar
                                    Folio</button>
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
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
