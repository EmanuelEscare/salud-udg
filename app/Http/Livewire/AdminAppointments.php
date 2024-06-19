<?php

namespace App\Http\Livewire;

use App\Models\Appointment;
use Livewire\Component;

class AdminAppointments extends Component
{

    public $appointments;
    public $nowPage = 1;
    public $pages = 10;

    protected $rules = [
        'appointments.0.status' => 'required|in:pendiente,confirmado,cancelado',
    ];

    public function render()
    {
        $this->appointments = $this->appointments->slice(($this->nowPage - 1) * $this->pages)->take($this->pages);
        return view('livewire.admin-appointments');
    }

    public function mount(){
        $this->appointments = Appointment::orderBy('id', 'DESC')->get();
    }

    public function search()
    {
        $this->appointments = Appointment::where('name', 'like', '%' . $this->query . '%')
            ->orWhere('email', 'like', '%' . $this->query . '%')
            ->get()->take($this->pages);
    }

    public function nextPage()
    {
        $this->nowPage++;
        $this->render();
    }

    public function afterPage()
    {
        $this->nowPage--;
        $this->render();
    }

    public function updateStatus($appointmentId, $newStatus)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->status = $newStatus;
        $appointment->save();
    }
}
