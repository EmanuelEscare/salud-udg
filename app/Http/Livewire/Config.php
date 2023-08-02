<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Config extends Component
{
    public $message_notification, $folio;

    public function mount(){
        $this->folio = config('socialtest.folio');
    }

    public function render()
    {
        return view('livewire.config');
    }

    public function updateFolio()
    {
        $new_folio = $this->folio;

        config(['socialtest.folio' => $new_folio]);
        $this->saveConfigToFile();

        $this->message_notification = "El paciente ha sido creado";
        $this->dispatchBrowserEvent('notification');
    }

    private function saveConfigToFile()
    {
        $configData = var_export(config('socialtest'), true);
        file_put_contents(config_path('socialtest.php'), "<?php\n\nreturn " . $configData . ";\n");
    }
}
