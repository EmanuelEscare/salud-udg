@php
    use Carbon\Carbon;
@endphp
<div>
    {{-- Do your work, then step back. --}}
    <div class="rounded-4 p-4">
        <h3 class="">{{ __('Citas') }}</h3>
        <br>
        <div class="py-2">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                          <th scope="col">Nombre</th>
                          <th scope="col">Email</th>
                          <th scope="col">Fecha cita</th>
                          <th scope="col"></th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody class="table-group-divider">
                        @foreach ($this->appointments as $key => $appointment)
                        <tr>
                            <td>{{$appointment->name}}</td>
                            <td>{{$appointment->email}}</td>
                            <td>{{ Carbon::parse($appointment->appointment_date)->isoFormat('D [de] MMMM [del] YYYY [a las] HH:mm') }}</td>
                            <td>
                                <select wire:model="appointments.{{ $appointment->id }}.status" wire:change="updateStatus({{ $appointment->id }}, $event.target.value)" class="form-select">
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Asistio">Asistio</option>
                                    <option value="No asistio">No asistio</option>
                                </select>
                            </td>
                            <td>
                              <button type="button" class="btn btn-danger">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                </table>
              </div>
        </div>
    </div>
</div>

