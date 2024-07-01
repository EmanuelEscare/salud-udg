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
    public $emailSend;

    public $sentEmail, $appointment;

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
        $this->sentEmail = false;
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
        $this->appointment = ModelsAppointment::create([
            'name' => $this->name,
            'email' => $this->email,
            'reason' => $this->reason,
            'token' => $token,
            'status' => 'pendiente',
            'appointment_date' => $this->selectedSlot,
        ]);

        $this->sendEmail();
        $this->sentEmail = true;
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

    private function sendEmail()
    {
        $date = Carbon::parse($this->appointment->appointment_date);
        $mailData = [
            'title' => 'Confirmar cita',
            'body' => 'Programaste una cita el dia ' .$date->isoFormat('DD MMMM YYYY').' a las ' . $date->hour .'.',
            'token' => $this->appointment->token
        ];

        Mail::to($this->appointment->email)->send(new AppointmentVerifyMail($mailData));
    }

    public function resendEmail()
    {
        $now = Carbon::now();
        $this->appointment->fresh();
        if ($this->appointment->token != null) {
            if ($now->diffInMinutes($this->appointment->updated_at) >= 5) {
                $token = bin2hex(random_bytes(16));
                $this->appointment->token = $token;
                $this->appointment->save();
                $this->sendEmail();
                $this->addError('sendSuccess', 'Se envio de nuevo un correo electronico');
                $this->addError('sendError', '');
            } else {
                $this->addError('sendError', 'Falta ' . (5-$now->diffInMinutes($this->appointment->updated_at)) . ' minutos para volver enviar un correo electronico');
                $this->addError('sendSuccess', '');
            }
        }else{
            $this->addError('sendSuccess', 'Cita ya confirmada');
            $this->addError('sendError', '');
        }
    }

    public function hasAppointment($date)
    {
        if (ModelsAppointment::where('appointment_date', $date)->exists()) {
            return true;
        }
        return false;
    }

}
