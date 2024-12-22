<?php

namespace App\Http\Controllers;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Requests\ForgotRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\ResetPasswordRequest;
use App\Notifications\ResetPasswordNotification;

class PasswordController extends Controller
{
    use ResponseTrait;


    public function __construct(private Otp $otp)
    {
        $this->otp = $otp;
    }

    public function forgotPassword(ForgotRequest $request)
{
    try {
        $input = $request->validated();

        $otpDetails = $this->otp->generate($input['email'], 'numeric', 6, 60);
        $user = User::where('email', $input['email'])->first();

        $user->notify(new ResetPasswordNotification($user->email, $otpDetails->token));

        return $this->success($otpDetails->token, 'Email verification OTP sent');
    } catch (\Exception $exception) {
        return $this->error($exception->getMessage());
    }
}

    public function resetPassword(ResetPasswordRequest $request)
    {
        $input = $request->validated();

        try {
            $otpValid = $this->otp->validate($request->email, $request->otp);

            if (!$otpValid->status) {
                return $this->error('Invalid or expired OTP', 400);
            }

            $user = User::where('email', $input['email'])->first();

            if (!$user) {
                return $this->error('User not found', 404);
            }

            $user->update(['password' => Hash::make($input['password'])]);

            return $this->success(message:'Password reset successfully');
        } catch (\Exception $exception) {
            return $this->error($exception->getMessage());
        }
    }
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $response = Password::sendResetLink(
            $request->only('email')
        );

        return response()->json([
            'status' => $response == Password::RESET_LINK_SENT
                ? 'Password reset link sent.'
                : 'Failed to send reset link.',
        ]);
    }
}