<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Config extends Component
{
    public $message_notification, $folio;

    
    public $days = [
        'monday' => false,
        'tuesday' => false,
        'wednesday' => false,
        'thursday' => false,
        'friday' => false,
        'saturday' => false,
        'sunday' => false,
    ];

    public $translateDays = [
        'monday' =>  'Lunes',
        'tuesday' =>  'Martes',
        'wednesday' =>  'Miércoles',
        'thursday' =>  'Jueves',
        'friday' =>  'Viernes',
        'saturday' =>  'Sábado',
        'sunday' =>  'Domingo',
    ];

    public $startMorning;
    public $endMorning;
    public $startAfternoon;
    public $endAfternoon;

    public $messages = [
        'startMorning.required' => 'En el horario matutino el inicio es obligatorio.',
        'startMorning.date_format' => 'En el horario matutino el inicio debe tener un formato válido (HH:MM).',
        'endMorning.required' => 'En el horario matutino el fin es obligatorio.',
        'endMorning.date_format' => 'En el horario matutino el fin debe tener un formato válido (HH:MM).',
        'endMorning.after' => 'En el horario matutino el fin debe ser posterior al horario de inicio.',
        'startAfternoon.required' => 'En el horario vespertino el inicio es obligatorio.',
        'startAfternoon.date_format' => 'En el horario vespertino el inicio debe tener un formato válido (HH:MM).',
        'startAfternoon.after' => 'En el horario vespertino el inicio debe ser posterior al horario de fin matutino.',
        'endAfternoon.required' => 'En el horario vespertino el fin es obligatorio.',
        'endAfternoon.date_format' => 'En el horario vespertino el fin debe tener un formato válido (HH:MM).',
        'endAfternoon.after' => 'En el horario vespertino el fin debe ser posterior al horario de inicio vespertino.',
    ];

    public function mount(){
        $config = config('psy-config');

        $this->folio = $config['folio'];

        $this->days['monday'] = $config['monday'];
        $this->days['tuesday'] = $config['tuesday'];
        $this->days['wednesday'] = $config['wednesday'];
        $this->days['thursday'] = $config['thursday'];
        $this->days['friday'] = $config['friday'];
        $this->days['saturday'] = $config['saturday'];
        $this->days['sunday'] = $config['sunday'];

        $this->startMorning = $config['startMorning'];
        $this->endMorning = $config['endMorning'];
        $this->startAfternoon = $config['startAfternoon'];
        $this->endAfternoon = $config['endAfternoon'];
    }

    public function render()
    {
        return view('livewire.config');
    }

    // Days --------------------------------------------------
    public function updatedDays($value, $key)
    {
        // Update the configuration dynamically when a switch is toggled
        $config = config('psy-config');
        $config[$key] = $value;

        // Save the updated configuration (this is an example; you'll need to implement this)
        file_put_contents(config_path('psy-config.php'), '<?php return ' . var_export($config, true) . ';');

        $this->message_notification = "Horario guardado";
        $this->dispatchBrowserEvent('notification');
    }
    // Time
    public function updateAttentionHours(){
        $this->validate($this->attentionHoursRules(), $this->messages);

        config(['psy-config.startMorning' => $this->startMorning]);
        config(['psy-config.endMorning' => $this->endMorning]);
        config(['psy-config.startAfternoon' => $this->startAfternoon]);
        config(['psy-config.endAfternoon' => $this->endAfternoon]);

        $this->saveConfigToFile();

        $this->message_notification = "El horario ha sido actualizado";
        $this->dispatchBrowserEvent('notification');
    }

    protected function attentionHoursRules()
    {
        return [
            'startMorning' => 'required|date_format:H:i',
            'endMorning' => 'required|date_format:H:i|after:startMorning',
            'startAfternoon' => 'required|date_format:H:i|after:endMorning',
            'endAfternoon' => 'required|date_format:H:i|after:startAfternoon',
        ];
    }

    // Folio --------------------------------------------------
    public function updateFolio()
    {
        $new_folio = $this->folio;

        config(['psy-config.folio' => $new_folio]);
        $this->saveConfigToFile();

        $this->message_notification = "El folio ha sido actualizado";
        $this->dispatchBrowserEvent('notification');
    }

    private function saveConfigToFile()
    {
        $configData = var_export(config('psy-config'), true);
        file_put_contents(config_path('psy-config.php'), "<?php\n\nreturn " . $configData . ";\n");
    }
}
