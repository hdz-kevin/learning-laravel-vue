<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'  => 'Test',
            'email' => 'test@test.com',
        ]);

        // Order matters: independent ones first, then those that depend on them
        $this->call([
            ServiceSeeder::class,
            PatientSeeder::class,
            AppointmentSeeder::class,
        ]);
    }
}
