<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\RedirectResponse;
use Illuminate\Queue\InteractsWithQueue;
use Laravel\Cashier\Events\WebhookReceived;
use Spatie\WebhookClient\Models\WebhookCall;

class StripeEventListener
{
    /**
     * Handle the event.
     *
     * @param WebhookCall $webhookCall
     * @return RedirectResponse
     */
    public function handle(WebhookCall $webhookCall): RedirectResponse
    {
        $unitAmount = $webhookCall['data']['unit_amount'];

        $payedCreditsAmount = $unitAmount / 100;
        $newUserCredits = auth()->user()->credits += $payedCreditsAmount;

        User::query()->update(['credits' => $newUserCredits]);
    }
}
