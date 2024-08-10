<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use Livewire\Component;

class AdminAppointments extends Component
{
    public $appointments;
    public $nowPage = 1;
    public $pages = 10;
    public $mesage_notification;
    public $query;

    protected $rules = [
        'appointments.*.status' => 'required|in:Pendiente,Asistio,No asistio',
    ];

    public function mount()
    {
        $this->loadAppointments();
    }

    public function loadAppointments()
    {
        $this->appointments = Appointment::orderBy('id', 'DESC')->get();
    }

    public function render()
    {
        $pagedAppointments = $this->appointments->slice(($this->nowPage - 1) * $this->pages, $this->pages);
        return view('livewire.admin-appointments', ['appointments' => $pagedAppointments]);
    }

    public function search()
    {
        $this->appointments = Appointment::where('name', 'like', '%' . $this->query . '%')
            ->orWhere('email', 'like', '%' . $this->query . '%')
            ->orderBy('id', 'DESC')
            ->get();
    }

     public function nextPage()
    {
        if (($this->nowPage * $this->pages) < $this->appointments->count()) {
            $this->nowPage++;
        }
    }

    public function previousPage()
    {
        if ($this->nowPage > 1) {
            $this->nowPage--;
        }
    }

    public function updateStatus($appointmentId, $status)
    {
        $this->validate();

        $appointment = Appointment::find($appointmentId);
        if ($appointment) {
            $appointment->status = $status;
            $appointment->save();
            $this->mesage_notification = "El estatus de la cita ha cambiado";
            $this->dispatchBrowserEvent('notification');
        }
    }

    public function deleteAppointment($appointmentId)
    {
        $appointment = Appointment::find($appointmentId);
        if ($appointment) {
            $appointment->delete();
            $this->mesage_notification = "La cita ha sido eliminada";
            $this->dispatchBrowserEvent('notification');
            $this->mount();
        }
    }
}

