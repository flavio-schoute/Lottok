<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Carbon;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    
    public function create(array $input)
    {
        Validator::make($input, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'birthdate' => ['required', 'date_format:Y-m-d', 'before:' . Carbon::now()->subYears(18)->format('Y-m-d')],
        ])->validate();
        
        return User::create([
            'first_name' => $input['firstname'],
            'last_name' => $input['lastname'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'birth_date' => $input['birthdate'],
            'credits' => 5,
            'is_admin' => 0,
            'is_active' => 1,
            'current_guess_streak' => 0,
        ]);

        // TODO: Add with Mollie also
    }
}
