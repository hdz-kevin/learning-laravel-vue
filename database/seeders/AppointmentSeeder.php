<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Service;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $patients = Patient::all();
        $services = Service::all();

        $patients->each(function (Patient $patient) use ($services) {
            $appointments = Appointment::factory(2)->create([
                'patient_id'  => $patient->id,
                'total_price' => 0,
            ]);

            $appointments->each(function (Appointment $appointment) use ($services) {
                $selectedServices = $services->random(rand(1, 3));

                $appointment->services()->attach($selectedServices->pluck('id'));

                // Calculate total price
                $appointment->update([
                    'total_price' => $selectedServices->sum('price'),
                ]);
            });
        });
    }
}
