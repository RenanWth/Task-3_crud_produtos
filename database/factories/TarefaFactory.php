<?php

namespace Database\Factories;

use App\Models\Tarefa;
use Illuminate\Database\Eloquent\Factories\Factory;

class TarefaFactory extends Factory
{
    protected $model = Tarefa::class;

    public function definition()
    {
        return [
            'nome' => $this->faker->sentence(3),
            'observacao' => $this->faker->paragraph(),
            'estado' => $this->faker->randomElement(['pendente', 'em andamento', 'concluida']),
        ];
    }
}
