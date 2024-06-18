<?php

namespace App\Http\Livewire;

use App\Mail\AppointmentVerifyMail;
use App\Models\Appointment as ModelsAppointment;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Appointment extends Component
{
    public $name;
    public $email;
    public $reason;
    public $selectedSlot, $slots;

    public $sendEmail;

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

    public function mount()
    {
        $this->sendEmail = false;
    }

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
        }

        $currentDate = now();

        if ($this->selectedSlot <= $currentDate) {
            $this->addError('selectedSlot', 'La hora seleccionada no está dentro del horario de atención.');
            return;
        }

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

        //session()->flash('message', 'Cita agendada exitosamente.');
        $mailData = [
            'title' => 'Confirmar cita',
            'body' => 'Programaste una cita a las (' . $this->selectedSlot . ').',
            'token' => $token
        ];

        Mail::to($this->email)->send(new AppointmentVerifyMail($mailData));
        $this->sendEmail = true;
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
        // Obtener la configuración de psy-config.php
        $config = config('psy-config');

        // Obtener los valores de configuración
        $startMorning = $config['startMorning'];
        $endMorning = $config['endMorning'];
        $startAfternoon = $config['startAfternoon'];
        $endAfternoon = $config['endAfternoon'];

        // Definir los días de la semana y sus traducciones
        $daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        $daysOfWeekTranslated = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];

        // Generar la estructura de la tabla con fechas y horas
        $slots = [];

        foreach ($daysOfWeek as $index => $day) {
            // Verificar si el día está habilitado en la configuración
            if (!isset($config[strtolower($day)]) || !$config[strtolower($day)]) {
                continue; // Saltar el día si no está habilitado
            }

            $dayName = $daysOfWeekTranslated[$index];

            // Generar los rangos de la mañana
            $currentTime = Carbon::parse("this $day $startMorning");
            while ($currentTime->lt(Carbon::parse("this $day $endMorning"))) {
                $nextTime = $currentTime->copy()->addHour();
                $timeRange = $currentTime->format('H:i') . ' - ' . $nextTime->format('H:i');
                $slots[$dayName][] = [
                    'datetime' => $currentTime->format('Y-m-d H:i:s'),
                    'label' => $timeRange
                ];
                $currentTime = $nextTime;
            }

            // Generar los rangos de la tarde
            $currentTime = Carbon::parse("this $day $startAfternoon");
            while ($currentTime->lt(Carbon::parse("this $day $endAfternoon"))) {
                $nextTime = $currentTime->copy()->addHour();
                $timeRange = $currentTime->format('H:i') . ' - ' . $nextTime->format('H:i');
                $slots[$dayName][] = [
                    'datetime' => $currentTime->format('Y-m-d H:i:s'),
                    'label' => $timeRange
                ];
                $currentTime = $nextTime;
            }
        }

        // Ordenar las ranuras por fecha y hora
        foreach ($slots as &$slot) {
            usort($slot, function ($a, $b) {
                return strtotime($a['datetime']) - strtotime($b['datetime']);
            });
        }

        // Asignar los slots a la propiedad de la clase
        $this->slots = $slots;

        // Retornar la vista con los datos
        return view('livewire.appointment', [
            'slots' => $slots
        ]);
    }
}
