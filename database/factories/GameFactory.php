<?php

namespace Database\Factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'game_date' => $this->faker->dateTimeBetween('+0 days', '+1 month'),
            'team_id1' => $this->faker->randomElement(Team::pluck('id')->toArray()),
            'team_id2' => $this->faker->randomElement(Team::pluck('id')->toArray()),
        ];
    }
}
