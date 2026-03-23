<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    private array $podiatryServices = [
        ['name' => 'Revisión general',          'price' => 300],
        ['name' => 'Corte de uñas especial',    'price' => 150],
        ['name' => 'Tratamiento de hongos',     'price' => 250],
        ['name' => 'Extracción de uña encarnada', 'price' => 400],
        ['name' => 'Plantillas ortopédicas',    'price' => 800],
        ['name' => 'Tratamiento de callos',     'price' => 200],
        ['name' => 'Limpieza de pies',          'price' => 180.00],
    ];

    public function definition(): array
    {
        $service = fake()->randomElement($this->podiatryServices);

        return [
            'name'  => $service['name'],
            'price' => $service['price'],
        ];
    }
}
