<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Board>
 */
class BoardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cells' => '[[71,false],[19,false],[25,false],[69,false],[22,false],[44,false],[99,false],[90,false],[64,false],[92,false],[35,false],[4,false],["FREE",false],[21,false],[57,false],[16,false],[1,false],[59,false],[91,false],[72,false],[81,false],[70,false],[78,false],[18,false],[54,false]]',
            'user_id' => User::inRandomOrder()->first()->id,
            'type' => 'new',
            'roulette'=> implode(',', range(1, 100))
        ];
    }

    public function scored(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'score' => rand(1,100)
            ];
        });
    }
}
