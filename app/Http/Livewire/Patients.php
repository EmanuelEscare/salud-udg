<?php

namespace App\Http\Livewire;

use App\Models\Patient;
use App\Models\Test;
use Livewire\Component;

class Patients extends Component
{
    public $patientsData, $test_patient, $now_patient;
    public $nowPage = 1;
    public $pages = 10;
    public $confirming;
    public $message_notification;
    public $query;
    public $patient_id;
    public $tests;


    public function render()
    {
        $patients = $this->patientsData->slice(($this->nowPage - 1) * $this->pages)->take($this->pages);
        return view('livewire.patients', ['patients' => $patients]);
    }

    public function mount($patient_id)
    {   
        if($this->patient_id != null){
            $this->patientsData = Patient::orWhere('id', $this->patient_id)->get();
        }else{
            $this->patientsData = Patient::get();
        }
    }

    public function search()
    {
        $this->patientsData = Patient::where('name', 'like', '%' . $this->query . '%')
            ->orWhere('email', 'like', '%' . $this->query . '%')
            ->get()->take($this->pages);
    }

    public function test($id, $user_id)
    {
        return redirect()->route('react', ['id' => $id, 'user_id' => $user_id]);
    }

    public function testsPatient($id)
    {
        $this->now_patient = Patient::find($id);
        
        $this->dispatchBrowserEvent('openModal');
    }

    public function editPatient($id)
    {
        $this->now_patient = Patient::find($id);
        
        $this->dispatchBrowserEvent('openModalEdit');
    }
}
