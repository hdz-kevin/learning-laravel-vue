<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Revisión general',             'price' => 300],
            ['name' => 'Corte de uñas especial',       'price' => 150],
            ['name' => 'Tratamiento de hongos',        'price' => 250],
            ['name' => 'Extracción de uña encarnada',  'price' => 400],
            ['name' => 'Plantillas ortopédicas',       'price' => 800],
            ['name' => 'Tratamiento de callos',        'price' => 200],
            ['name' => 'Limpieza de pies',             'price' => 180],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
