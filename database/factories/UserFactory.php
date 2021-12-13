<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Cashier\Cashier;
use Laravel\Jetstream\Features;
use Stripe\Stripe;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'birth_date' => $this->faker->date(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'credits' => $this->faker->randomFloat(2, 0, 100),
            'is_admin' => $this->faker->boolean(5),
            'is_active' => 1,
            'current_guess_streak' => $this->faker->numberBetween(0, 9),
        ];
    }

    public function configure(): UserFactory
    {
        return $this->afterMaking(function (User $user) {
            //
        })->afterCreating(function (User $user) {
            $user->createAsStripeCustomer();
        });
    }


    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withPersonalTeam()
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->name.'\'s Team', 'user_id' => $user->id, 'personal_team' => true];
                }),
            'ownedTeams'
        );
    }
}
