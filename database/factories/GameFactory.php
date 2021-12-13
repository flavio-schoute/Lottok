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
            'team_id1' => Team::all(['id'])->random(1)->first(),
            'team_id2' => Team::all(['id'])->random(1)->last(),
        ];
    }
}
