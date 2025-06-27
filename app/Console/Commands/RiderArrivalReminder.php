<?php

// app/Console/Commands/RiderArrivalReminder.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;

class RiderArrivalReminder extends Command
{
    protected $signature = 'reminder:rider-arrival';
    protected $description = 'Send reminder to patients 15 minutes before rider arrives';

    public function handle()
    {
        $now = Carbon::now();
        $inFifteen = $now->copy()->addMinutes(15)->format('Y-m-d H:i');

        $appointments = Appointment::where('rider_id', '!=', null)
            ->whereDate('appointment_date', $now->format('Y-m-d'))
            ->whereTime('appointment_time', $inFifteen)
            ->get();

        foreach ($appointments as $appointment) {
            // Example: create a reminder record in DB
            \DB::table('patient_reminders')->insert([
                'patient_id' => $appointment->patient_id,
                'message' => 'Your rider is arriving in 15 minutes. Please get ready.',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Optionally: trigger SMS here if needed
            // dispatch(new SendSmsJob($appointment->patient->phone, "Your rider is arriving in 15 minutes"));
        }

        $this->info('Rider arrival reminders sent.');
    }
}
