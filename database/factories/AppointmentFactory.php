<?php

namespace Database\Factories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            // patient_id is assigned from the seeder
            'patient_id'  => Patient::factory(),
            'date'        => fake()->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
            'time'        => fake()->time('H:i:s'),
            'total_price' => 0,
        ];
    }
}
