<div>
    {{-- In work, do what you enjoy. --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card border-0 rounded-2xl shadow-sm container ps-none p-5">
                <div>
                    <h2 class="text-center">¿Es la primera vez que agendas una cita?</h2>
                    <br>
                    <div class="m-auto max-w-max">
                        <button type="button" class="btn btn-primary btn-lg">Si</button>
                        <button type="button" class="btn btn-success btn-lg">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="card border-0 rounded-2xl shadow-sm container ps-none p-5">
                <div>
                    <h2 class="text-center">Llena el formulario</h2>
                    <br>
                    <div class="modal-body">
                        <div class="col-lg-9 m-auto">
                            <p class="m-1">Nombre</p>
                            <input wire:model="patient.name" class="form-control form-control-lg" type="text">
                            <br>
                            <p class="m-1">Fecha de nacimiento</p>
                            <input wire:model="patient.birth_date" type="date" class="form-control form-control-lg"
                                type="text">
                            <br>
                            <p class="m-1">Código de Estudiante</p>
                            <input wire:model="patient.code" class="form-control form-control-lg" type="text">
                            <br>
                            <p class="m-1">Sexo</p>
                            <select wire:model="patient.sex" class="form-control form-control-lg">
                                <option value="female">...
                                </option>
                                <option value="female">Mujer
                                </option>
                                <option value="male">Hombre
                                </option>
                                <option value="other">Otro
                                </option>
                            </select>
                            <br>
                            <p class="m-1">Estado Civil</p>
                            <select wire:model="patient.sex" class="form-control form-control-lg">
                                <option value="female">...
                                </option>
                                <option value="female">Mujer
                                </option>
                                <option value="male">Hombre
                                </option>
                                <option value="other">Otro
                                </option>
                            </select>
                            <br>
                            <p class="m-1">Email Institucional</p>
                            <input wire:model="patient.email" class="form-control form-control-lg" type="text">
                            <br>
                            <p class="m-1">Teléfono</p>
                            <input wire:model="patient.phone" class="form-control form-control-lg" type="text">
                            <br>
                            {{--  --}}
                            <p class="m-1">¿Cual es tu carrera?</p>
                            <select wire:model="patient.sex" class="form-control form-control-lg">
                                <option value="female">...
                                </option>
                                <option value="female">Mujer
                                </option>
                                <option value="male">Hombre
                                </option>
                                <option value="other">Otro
                                </option>
                            </select>
                            <br>
                            <p class="m-1">¿Su semestre actual de estudio?</p>
                            <select wire:model="patient.sex" class="form-control form-control-lg">
                                <option value="female">...
                                </option>
                                <option value="female">Mujer
                                </option>
                                <option value="male">Hombre
                                </option>
                                <option value="other">Otro
                                </option>
                            </select>
                            <br>
                            <p class="m-1">¿Su promedio actual?</p>
                            <select wire:model="patient.sex" class="form-control form-control-lg">
                                <option value="female">...
                                </option>
                                <option value="female">Mujer
                                </option>
                                <option value="male">Hombre
                                </option>
                                <option value="other">Otro
                                </option>
                            </select>
                            <br>
                            {{--  --}}
                            <p class="m-1">¿Tienes depresión?</p>
                            <select wire:model="patient.sex" class="form-control form-control-lg">
                                <option value="female">...
                                </option>
                                <option value="female">Mujer
                                </option>
                                <option value="male">Hombre
                                </option>
                                <option value="other">Otro
                                </option>
                            </select>
                            <br>
                            <p class="m-1">¿Tienes ansiedad?</p>
                            <select wire:model="patient.sex" class="form-control form-control-lg">
                                <option value="female">...
                                </option>
                                <option value="female">Mujer
                                </option>
                                <option value="male">Hombre
                                </option>
                                <option value="other">Otro
                                </option>
                            </select>
                            <br>
                            <p class="m-1">¿Tienes ataque de pánico?</p>
                            <select wire:model="patient.sex" class="form-control form-control-lg">
                                <option value="female">...
                                </option>
                                <option value="female">Mujer
                                </option>
                                <option value="male">Hombre
                                </option>
                                <option value="other">Otro
                                </option>
                            </select>
                            <br>
                            <p class="m-1">¿Buscaste algún especialista para un tratamiento?</p>
                            <select wire:model="patient.sex" class="form-control form-control-lg">
                                <option value="female">...
                                </option>
                                <option value="female">Mujer
                                </option>
                                <option value="male">Hombre
                                </option>
                                <option value="other">Otro
                                </option>
                            </select>
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
                                <button type="submit" class="btn btn-lg btn-primary">Guardar datos</button>
                            </div>
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
                        <div>
                            <h2 class="text-center">Agenda tu cita</h2>
                            <br>
                            <p class="m-1">Dia</p>
                            <input wire:model="patient.birth_date" type="date"
                                class="form-control form-control-lg" type="text">
                            <br>
                            <p class="m-1">Hora</p>
                            <select wire:model="patient.sex" class="form-control form-control-lg">
                                <option value="female">...
                                </option>
                                <option value="female">Mujer
                                </option>
                                <option value="male">Hombre
                                </option>
                                <option value="other">Otro
                                </option>
                            </select>
                            <br>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-lg btn-success">Agendar cita</button>
                            </div>
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
