<?php

namespace App\Services;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;

class VonageService
{
    protected $vonage;

    public function __construct()
    {
        $credentials = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
        $this->vonage = new Client($credentials);
    }

    public function sendSms(string $to, string $message)
    {
        try {
            $response = $this->vonage->sms()->send(
                new \Vonage\SMS\Message\SMS($to, env('VONAGE_FROM_NUMBER'), $message)
            );

            $message = $response->current();

            if ($message->getStatus() == 0) {
                return ['success' => true, 'message' => 'SMS sent successfully.'];
            } else {
                return ['success' => false, 'message' => 'Failed to send SMS: ' . $message->getStatus()];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

}
