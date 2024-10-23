<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendSubscriptionExpireMessage implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public $user, public $expireDate)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        sendMail('emails.subscription.expiration', $this->user->email, 'Subscription Expired', [
            'user' => $this->user,
            'expireDate' => $this->expireDate,
        ]);
    }
}
