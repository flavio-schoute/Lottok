<?php

namespace App\Services;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class CashoutService
{

    /**
     * @throws Exception
     */
    public function handleCashout(float $amount): float|int
    {
        // If the amount is less than 20 euro we throw error message
        if ($amount < 20) {
            throw new Exception('Het minimale bedrag moet 20 euro zijn.');
        }

        $userCredits = auth()->user()->credits;

        // Calculate tax for the owner and user credits
        $cashoutTax = $amount / 100 * 7;
        $newUserCredits = $userCredits - $amount;

        // Check if the new calculated credits is not less than 0 if so, throw error message
        if (($newUserCredits - $cashoutTax) < 0) {
            throw new Exception('Je hebt niet genoeg credits.');
        }

        DB::table('cashout_customers')->insert([
            'user_id' => auth()->user()->id,
            'tax_credits' => $cashoutTax,
            'cashout_date' => Carbon::now()
        ]);

        return ($newUserCredits - $cashoutTax);
    }
}
