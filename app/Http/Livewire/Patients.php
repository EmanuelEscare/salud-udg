<?php

namespace App\Http\Livewire;

use App\Models\Patient;
use App\Models\Test;
use Dotenv\Store\File\Paths;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Patients extends Component
{
    public $patientsData, $test_patient, $now_patient, $patient;
    public $nowPage = 1;
    public $pages = 10;
    public $confirming;
    public $message_notification;  
    public $query;
    public $patient_id;
    public $tests;
    public $invoice;


    public function rules()
    {

        return [
            'patient.name' => 'required',
            'patient.birth_date' => 'required',
            'patient.code' => 'required',
            'patient.sex' => 'required',
            'patient.email' => 'required',
            'patient.phone' => 'required',
        ];
    }
    

    protected $messages = [
        'patient.name' => 'El campo nombre es requerido',
        'patient.birth_date' => 'El campo fecha de nacimiento es requerido',
        'patient.code' => 'El campo código es requerido',
        'patient.sex' => 'El campo sexo es requerido',
        'patient.email' => 'El campo email es requerido',
        'patient.phone' => 'El campo teléfono es requerido',
    ];

    public function render()
    {
        $patients = $this->patientsData->slice(($this->nowPage - 1) * $this->pages)->take($this->pages);
        return view('livewire.patients', ['patients' => $patients]);
    }

    public function mount($patient_id)
    {
        // Load invoice
        $this->invoice = config('socialtest.folio');

        if (Auth::user()->hasRole('user')){
            if ($this->patient_id != null) {
                $this->patientsData = Patient::where('user_id', Auth::user()->id)->where('id', $this->patient_id)->get();
            } else {
                $this->patientsData = Patient::where('user_id', Auth::user()->id)->get();
            }
        }else{
            if ($this->patient_id != null) {
                $this->patientsData = Patient::orWhere('id', $this->patient_id)->get();
            } else {
                $this->patientsData = Patient::get();
            }
        }

    }

    public function search()
    {
        $this->patientsData = Patient::where('name', 'like', '%' . $this->query . '%')
            ->orWhere('email', 'like', '%' . $this->query . '%')
            ->orWhere('invoice', 'like', '%' . $this->query . '%')
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

    public function test($id, $user_id)
    {
        return redirect()->route('test', ['id' => $id, 'user_id' => $user_id]);
    }

    public function testsPatient($id)
    {
        $this->now_patient = Patient::find($id);

        $this->dispatchBrowserEvent('openModal');
    }

    public function infoPatient($id)
    {
        $this->now_patient = Patient::find($id);

        $this->dispatchBrowserEvent('modalDetails');
    }

    public function editPatient($id)
    {
        $this->now_patient = Patient::find($id);
        $this->patient = $this->now_patient;

        $this->dispatchBrowserEvent('openModalEdit');
    }

    public function formEditPatient(){
        $this->validate();

        DB::beginTransaction();
        try {
            $patient = Patient::find($this->patient->id);
            $patient->name = $this->patient['name'];
            $patient->birth_date = $this->patient['birth_date'];
            $patient->email = $this->patient['email'];
            $patient->phone = $this->patient['phone'];
            $patient->code = $this->patient['code'];
            $patient->sex = $this->patient['sex'];

            $patient->save();

            DB::commit();

            $this->message_notification = "El paciente ha sido editado";
            $this->dispatchBrowserEvent('notification');
            $this->dispatchBrowserEvent('closeModalEdit');
            $this->clean();
            $this->mount(null);
            return;
        } catch (\Exception $e) {
            DB::rollback();

            $this->message_notification = "Error: " . $e;
            $this->dispatchBrowserEvent('notification');
            $this->dispatchBrowserEvent('closeModalEdit');
            return;
        }
    }

    public function formNewPatient()
    {
        $this->clean();
        $this->dispatchBrowserEvent('modalAdd');
    }

    public function saveNewPatient()
    {
        $this->validate();
        DB::beginTransaction();

        try {
            $patient = new Patient;
            $patient->name = $this->patient['name'];
            $patient->code = $this->patient['code'];
            $patient->user_id = Auth::user()->id;
            $patient->email = $this->patient['email'];
            $patient->phone = $this->patient['phone'];
            $patient->sex = $this->patient['sex'];
            $patient->birth_date = $this->patient['birth_date'];

            $patient->save();

            // Generate Invoice
            $patient_id = $patient->id;
            $patientIdFormatted = str_pad($patient_id, 2, '0', STR_PAD_LEFT);
            $patient->invoice = $this->invoice.$patientIdFormatted;
            $patient->save();
            
            DB::commit();

            $this->message_notification = "El paciente ha sido creado";
            $this->dispatchBrowserEvent('notification');
            $this->dispatchBrowserEvent('closeModalAdd');
            $this->clean();
            $this->mount(null);
            return;
        } catch (\Exception $e) {
            DB::rollback();

            $this->message_notification = "Error: " . $e;
            $this->dispatchBrowserEvent('notification');
            $this->dispatchBrowserEvent('closeModalAdd');
            $this->mount(null);
            return;
        }
    }

    public function clean()
    {
        $this->patient['name'] = null;
        $this->patient['code'] = null;
        $this->patient['birth_date'] = null;
        $this->patient['email'] = null;
        $this->patient['phone'] = null;
        $this->patient['sex'] = null;
        return;
    }

    public function delete($id)
    {
        $this->now_patient = null;
        $this->patientsData->find($id)->delete();
        $this->message_notification = "El paciente ha sido eliminado";
        $this->dispatchBrowserEvent('notification');
        $this->mount(null);
    }

    public function confirmDelete($id)
    {
        $this->confirming = $id;
    }
}
