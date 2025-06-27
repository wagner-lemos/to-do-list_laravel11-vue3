<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nome' => $this->faker->sentence(3),
            'descricao' => $this->faker->paragraph(),
            'data_limite' => now()->addDays(rand(1, 5)),
            'finalizado' => false,
        ];
    }
}
