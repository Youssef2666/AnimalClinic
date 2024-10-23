<?php

namespace App\Console\Commands;

use App\Jobs\SendSubscriptionExpireMessage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SubscriptionExpiryNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:subscription-expiry-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check which users have subscription expired.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::where('email', 'youssefalmerash76@gmail.com')
            ->orWhere('email', 'youssefboss266@gmail.com')
            ->get();
        foreach ($users as $user) {
            $expireDate = Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->toDateString();
            dispatch(new SendSubscriptionExpireMessage($user, $expireDate))->onQueue('youssef');
        }
    }
}
