<?php

namespace App\Http\Livewire;

use App\Models\Appointment as ModelsAppointment;
use Illuminate\Support\Carbon;
use Livewire\Component;

class Appointment extends Component
{
    public $name;
    public $email;
    public $reason;
    public $selectedSlot, $slots;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'reason' => 'required|string|max:500',
        'selectedSlot' => 'required|date_format:Y-m-d H:i:s',
    ];

    protected $messages = [
        'selectedSlot.required' => 'Debe seleccionar una fecha y hora para la cita.',
        'selectedSlot.date_format' => 'El formato de la fecha y hora seleccionadas es inválido.',
    ];

    public function schedule()
    {
        $this->validate();
        // Verificar conflictos con citas existentes
        if (ModelsAppointment::where('appointment_date', $this->selectedSlot)->exists()) {
            $this->addError('selectedSlot', 'Ya existe una cita para la fecha y hora seleccionadas.');
            return;
        }

        // Obtener configuraciones
        $config = config('psy-config');

        // Validar la fecha y hora seleccionadas
        $selectedDateTime = Carbon::parse($this->selectedSlot);
        $dayOfWeek = strtolower($selectedDateTime->format('l')); // 'monday', 'tuesday', etc.
        
        if (!$config[$dayOfWeek]) {
            $this->addError('selectedSlot', 'El día seleccionado no está habilitado para agendar citas.');
            return;
        }

        $startMorning = Carbon::parse($config['startMorning']);
        $endMorning = Carbon::parse($config['endMorning']);
        $startAfternoon = Carbon::parse($config['startAfternoon']);
        $endAfternoon = Carbon::parse($config['endAfternoon']);

        $selectedTime = $selectedDateTime->format('H:i:s');

        if (!(
            ($selectedTime >= $startMorning->format('H:i:s') && $selectedTime < $endMorning->format('H:i:s')) ||
            ($selectedTime >= $startAfternoon->format('H:i:s') && $selectedTime < $endAfternoon->format('H:i:s'))
        )) {
            $this->addError('selectedSlot', 'La hora seleccionada no está dentro del horario de atención.');
            return;
        }dd(true, $this->selectedSlot, $this->slots, $this->reason);

        // Generar un token único para la cita
        $token = bin2hex(random_bytes(16));

        // Guardar la cita
        ModelsAppointment::create([
            'name' => $this->name,
            'email' => $this->email,
            'reason' => $this->reason,
            'token' => $token,
            'status' => 'pendiente',
            'appointment_date' => $this->selectedSlot,
        ]);

        session()->flash('message', 'Cita agendada exitosamente.');
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->name = '';
        $this->email = '';
        $this->reason = '';
        $this->selectedSlot = '';
    }

    public function render()
    {
         // Definir las horas de trabajo
         $timeRanges = [
            '07:00 - 08:00', '08:00 - 09:00', '09:00 - 10:00', '10:00 - 11:00',
            '11:00 - 12:00', '12:00 - 13:00', '13:00 - 14:00', '14:00 - 15:00',
            '15:00 - 16:00', '16:00 - 17:00', '17:00 - 18:00', '18:00 - 19:00',
            '19:00 - 20:00', '20:00 - 21:00'
        ];

        // Definir los días de la semana
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $daysOfWeekTranslated = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

        // Generar la estructura de la tabla con fechas y horas
        $slots = [];
        foreach ($daysOfWeek as $index => $day) {
            $dayName = $daysOfWeekTranslated[$index];
            foreach ($timeRanges as $timeRange) {
                [$start, $end] = explode('-', $timeRange);
                $dateTime = Carbon::parse("this $day $start");
                $slots[$dayName][] = [
                    'datetime' => $dateTime->format('Y-m-d H:i:s'),
                    'label' => $timeRange
                ];
            }
        }
        $this->slots = $slots;
        return view('livewire.appointment',[
            'slots' => $slots
        ]);
    }
}
