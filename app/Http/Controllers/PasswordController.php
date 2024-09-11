<?php

namespace App\Http\Controllers;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Requests\ForgotRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class PasswordController extends Controller
{
    use ResponseTrait;

    protected $otp;

    public function __construct(Otp $otp)
    {
        $this->otp = $otp;
    }

    public function forgotPassword(ForgotRequest $request)
{
    try {
        // Validation is handled by the request; we don't need to check for the user again.
        $input = $request->validated();

        // Generate OTP and store it
        $otpDetails = $this->otp->generate($input['email'], 'numeric', 6, 60);
        $user = User::where('email', $input['email'])->first();

        // Send OTP via notification
        $user->notify(new ResetPasswordNotification($user->email, $otpDetails->token));

        return $this->success($otpDetails->token, 'Password reset link sent to your email');
    } catch (\Exception $exception) {
        return $this->error($exception->getMessage());
    }
}

    public function resetPassword(ResetPasswordRequest $request)
    {
        $input = $request->validated();

        try {
            // Validate OTP
            $otpValid = $this->otp->validate($request->email, $request->otp);

            if (!$otpValid->status) {
                return $this->error('Invalid or expired OTP', 400);
            }

            $user = User::where('email', $input['email'])->first();

            if (!$user) {
                return $this->error('User not found', 404);
            }

            // Update the user's password
            $user->update(['password' => Hash::make($input['password'])]);

            return $this->success(message:'Password reset successfully');
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
}