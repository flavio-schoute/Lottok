<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Cashier\Events\WebhookReceived;

class StripeEventListener
{
    /**
     * Handle the event.
     *
     * @param WebhookReceived $event
     * @return RedirectResponse
     */
    public function handle(WebhookReceived $event): RedirectResponse
    {
        if ($event->payload['type'] === 'checkout.session.completed') {
            $session = $event->data->object;

            $payedCreditsAmount = $session->unit_amount;
            $newUserCredits = auth()->user()->credits += $payedCreditsAmount;

            User::query()->update(['credits' => $newUserCredits]);

            return redirect()->route('pay.index')->with('succes', 'Je betaling van '. $payedCreditsAmount . ' is geslaagd!');
        }

        return redirect()->route('pay.index')->withErrors(['payment_error_webhook' => 'Er ging iets mis met de betaling, neem contact op!']);
    }
}
