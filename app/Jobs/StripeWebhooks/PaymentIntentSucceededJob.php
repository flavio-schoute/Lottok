<?php

namespace App\Jobs\StripeWebhooks;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Models\WebhookCall;

class PaymentIntentSucceededJob implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /** @var WebhookCall */

    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // TODO: 503 service
        User::query()->update(['credits' => 200]);

        $data = $this->webhookCall->payload['data']['object'];

        $user = User::where('stripe_id', $data['customer'])->get();

        if ($user) {
            $currentUserCredits = $user->credits;
            $credits = $data['amount_total'] / 100;

            $newUserCredits = $currentUserCredits + $credits;

            User::query()->where('id', $user->id)->update(['credits' => $newUserCredits]);
        }
    }
}
