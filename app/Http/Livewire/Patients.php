<?php

namespace App\Http\Livewire;

use App\Models\Patient;
use Livewire\Component;

class Patients extends Component
{
    public $patientsData;
    public $nowPage = 1;
    public $pages = 10;
    public $confirming;
    public $message_notification;
    public $query;

    public function render()
    {
        $patients = $this->patientsData->slice(($this->nowPage - 1) * $this->pages)->take($this->pages);
        return view('livewire.patients', ['patients' => $patients]);
    }

    public function mount()
    {
        $this->patientsData = Patient::get();
    }

    public function search()
    {
        $this->patientsData = Patient::where('name', 'like', '%' . $this->query . '%')
            ->orWhere('email', 'like', '%' . $this->query . '%')
            ->get()->take($this->pages);
    }
}
