@php
    use Carbon\Carbon;
@endphp
<div>
    <div class="rounded-4 p-4">
        <h3>{{ __('Citas') }}</h3>
        <br>
        <div class="py-2">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                          <th scope="col">Nombre</th>
                          <th scope="col">Email</th>
                          <th scope="col">Fecha cita</th>
                          <th scope="col">Estado</th>
                          <th scope="col"></th>
                        </tr>
                      </thead>
                      <tbody class="table-group-divider">
                        @foreach ($appointments as $appointment)
                        <tr>
                            <td>{{ $appointment->name }}</td>
                            <td>{{ $appointment->email }}</td>
                            <td>{{ Carbon::parse($appointment->appointment_date)->isoFormat('D [de] MMMM [del] YYYY [a las] HH:mm') }}</td>
                            <td>
                                <select wire:model="appointments.{{ $loop->index }}.status" wire:change="updateStatus({{ $appointment->id }}, $event.target.value)" class="form-select">
                                    <option value="Pendiente" @if ($appointment->status == 'Pendiente') selected @endif>Pendiente</option>
                                    <option value="Asistio" @if ($appointment->status == 'Asistio') selected @endif>Asistio</option>
                                    <option value="No asistio" @if ($appointment->status == 'No asistio') selected @endif>No asistio</option>
                                </select>
                            </td>
                            <td>
                              <button type="button" class="btn btn-danger" wire:click="deleteAppointment({{ $appointment->id }})">
                                <i class="fa-solid fa-trash"></i>
                              </button>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                </table>
              </div>
        </div>

        <div class="btn-group mt-3 border" role="group" aria-label="Basic example">
          <button type="button" wire:click="previousPage" class="btn border-end"><i
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
                      {{ $mesage_notification }}
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
  
      <script>
          window.addEventListener('openModal', event => {
              $("#openModal").modal('show');
          })
  
          window.addEventListener('closeModal', event => {
              $("#openModal").modal('hide');
          })
  
          window.addEventListener('openModalUpdate', event => {
              $("#openModalUpdate").modal('show');
          })
  
          window.addEventListener('closeModalUpdate', event => {
              $("#openModalUpdate").modal('hide');
          })
      </script>
</div>
