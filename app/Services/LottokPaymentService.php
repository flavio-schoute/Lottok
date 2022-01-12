<?php

namespace App\Services;

use Exception;
use Stripe\Checkout\Session;
use Stripe\Customer;

class LottokPaymentService
{

    /**
     * @throws Exception
     */
    public function pay(float $amount, string $stripeCustomerId): Session
    {
        // If the amount is less than 20 euro we throw error message
        if ($amount < 5) {
            throw new Exception('Het minimale bedrag moet 20 euro zijn.');
        }

        // Get the customer and the currency
        $customer = Customer::retrieve($stripeCustomerId);
        $currency = config('cashier.currency');

        // The url the user will be redirected to if the payment succeed or canceled
        $returnUrl = redirect()->route('pay.index')->getTargetUrl();

        $unitAmount = $amount * 100;

        // Checkout session
        return Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => $currency,
                    'product_data' => [
                        'name' => 'Credits Lottok',
                    ],
                    'unit_amount_decimal' => $unitAmount,
                ],
                'quantity' => 1,
            ]],
            'payment_method_types' => ['ideal'],
            'metadata' => [
                'product' => 'Credit Lottok'
            ],
            'mode' => 'payment',
            'customer' => $customer,
            'billing_address_collection' => 'required',
            'phone_number_collection' => [
                'enabled' => true
            ],
            'submit_type' => 'pay',
            'success_url' => $returnUrl . '?succes=true&amount=' . $amount,
            'cancel_url' => $returnUrl
        ]);
    }

}
