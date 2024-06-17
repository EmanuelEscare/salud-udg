<div>
    {{-- In work, do what you enjoy. --}}
    @php
        use Carbon\Carbon;
    @endphp
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card border-0 rounded-2xl shadow-sm container ps-none p-5">
                <div class="modal-body">
                    <div class="col-lg-11 m-auto">
                        <div>
                            <h2 class="text-center">Agenda tu cita</h2>
                            <br>
                            @if (session()->has('message'))
                                <div class="alert alert-success">
                                    {{ session('message') }}
                                </div>
                            @endif

                            <form wire:submit.prevent="schedule">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        id="name" wire:model="name">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" wire:model="email">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="reason" class="form-label">Motivo de la Cita</label>
                                    <select class="form-control @error('reason') is-invalid @enderror" name="reason" wire:model="reason" id="reason">
                                        <option value="" selected>...</option>
                                        <option value="Evaluación inicial">Evaluación inicial</option>
                                        <option value="Consejeria">Consejeria</option>
                                    </select>
                                    @error('reason')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <br>
                                <div class="mb-3">
                                    <label for="appointment_date" class="form-label">Seleccione Fecha y Hora</label>
                                    <br>
                                    <small class="text-secondary">
                                    Del {{ Carbon::parse($slots['Lunes'][0]['datetime'])->isoFormat('D') }}
                                     al 
                                    {{ Carbon::parse($slots['Domingo'][0]['datetime'])->isoFormat('D [de] MMMM [del] YYYY') }}
                                    </small>
                                    <br>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    @foreach (array_keys($slots) as $day)
                                                        <th>{{ $day }}</th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @for ($i = 0; $i < count($slots[array_key_first($slots)]); $i++)
                                                    <tr>
                                                        @foreach ($slots as $dayIndex => $daySlots)
                                                            <td>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio"
                                                                        name="selectedSlot"
                                                                        id="slot{{ $dayIndex }}{{ $i }}"
                                                                        wire:model="selectedSlot"
                                                                        value="{{ $daySlots[$i]['datetime'] }}">
                                                                    <label class="form-check-label"
                                                                        for="slot{{ $dayIndex }}{{ $i }}">
                                                                        <small>{{ $daySlots[$i]['label'] }}</small>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                    </div>
                                    @error('selectedSlot')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <button type="submit" class="btn btn-primary">Agendar Cita</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card border-0 rounded-2xl shadow-sm container ps-none p-5">
                <div class="modal-body">
                    <div class="col-lg-9 m-auto">
                        <div class="text-center">
                            <h2 class="text-center">Confirma tu cita</h2>
                            <br>
                            <p>Te enviamos un correo, confirma tu cita</p>
                            <br>
                            <p class="m-1">Volver enviar <a href=""> email</a></p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
