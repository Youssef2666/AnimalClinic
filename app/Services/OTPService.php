<?php

namespace App\Services;

use Vonage\Client;
use Vonage\Client\Credentials\Basic;
use Illuminate\Support\Facades\Cache;

class OtpService
{
    protected $vonage;

    public function __construct()
    {
        $credentials = new Basic(env('VONAGE_API_KEY'), env('VONAGE_API_SECRET'));
        $this->vonage = new Client($credentials);
    }

    public function sendOtp(string $phoneNumber): bool
    {
        $otp = rand(100000, 999999);

        Cache::put('otp_' . $phoneNumber, $otp, now()->addMinutes(5));

        try {
            $this->vonage->sms()->send(
                new \Vonage\SMS\Message\SMS($phoneNumber, env('VONAGE_FROM_NUMBER'), "Your OTP is: $otp")
            );

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function validateOtp(string $phoneNumber, int $otp): bool
    {
        return Cache::get('otp_' . $phoneNumber) == $otp;
    }
}