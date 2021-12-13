<?php

namespace App\Actions\Fortify;

use App\Models\User;
use DebugBar\DebugBar;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Laravel\Cashier\Cashier;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Carbon;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     * @return User
     * @throws ValidationException
     */

    public function create(array $input)
    {
        Validator::make($input, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'birth_date' => ['required', 'date_format:Y-m-d', 'before:' . Carbon::now()->subYears(18)->format('Y-m-d')],
        ])->validate();

        $user = User::create([
            'first_name' => $input['first_name'],
            'last_name' => $input['last_name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'birth_date' => $input['birth_date'],
            'credits' => 5,
            'is_admin' => false,
            'is_active' => true,
            'current_guess_streak' => 0,
        ]);

        $stripeCustomer = $user->createAsStripeCustomer();
        $stripeCustomerId = $stripeCustomer->id;

        // Maybe delete this
        $stripeUser = Cashier::findBillable($stripeCustomerId);
        $stripeUser->applyBalance(500, 'Registratie bonus');

        return $user;
    }
}
