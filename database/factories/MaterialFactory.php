<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MaterialFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [            
            'nome' => $this->faker->name(),
            'descricao' => $this->faker->paragraph(),
            'marca' => $this->faker->name(),
            'valor' => $this->faker->numberBetween($min = 1, $max = 300)
        ];
    }
}
