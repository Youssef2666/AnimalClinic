<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\OtpVerifyRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\traits\ResponseTrait;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    use ResponseTrait;

    public function __construct(private Otp $otp)
    {
        $this->otp = $otp;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create($request->validated());
            $token = $user->createToken('auth_token')->plainTextToken;
            // $user->notify(new EmailVerificationNotification($user->email, $this->otp));
            return $this->successWithToken($user, token: $token);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $request->validated($request->all());
            if (!Auth::attempt($request->only('email', 'password'))) {
                return $this->error('Credentials do not match', 401);
            }
            $user = User::where('email', $request['email'])->firstOrFail();
            $token = $user->createToken('auth_token')->plainTextToken;
            return $this->successWithToken($user, token: $token);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function verifyOtp(OtpVerifyRequest $request)
    {
        try {
            $email = $request->input('email');
            $otpCode = $request->input('otp');

            $otpValidation = $this->otp->validate($email, $otpCode);

            if (!$otpValidation->status) {
                return $this->error('Invalid or expired OTP.', 400);
            }

            // OTP is valid, mark the user as verified
            $user = User::where('email', $email)->first();
            $user->email_verified_at = now(); // Mark the user as verified
            $user->save();

            return $this->success('OTP verified successfully.');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function authme()
    {
        $user = Auth::user();
        return $this->success($user, 'U are authinticated');
    }

    public function sendEmailVerification(Request $request)
    {
        $user = $request->user();
        $user->sendEmailVerificationNotification();
        return $this->success('Verification link sent on your email');
    }

    // public function verifyEmail(Request $request)
    // {
    //     $user = User::where('email', $request->email)->first();

    //     if (!$user) {
    //         return $this->error('User not found', 404);
    //     }

    //     if ($user->hasVerifiedEmail()) {
    //         return response()->json(['message' => 'Email already verified']);
    //     }

    //     if ($user->markEmailAsVerified()) {
    //         return $this->success('Email verified successfully', code: 200);
    //     } else {
    //         return $this->error('Unable to verify email', 500);
    //     }
    // }

    public function logout(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();
            return $this->success('Logged out successfully');
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
    public function index()
    {
        $users = User::all();
        return $this->success(UserResource::collection($users));
    }

    public function sendNotification()
    {
        // Replace with the actual FCM token you want to send to
        $fcmToken = 'f_4Xj9sKQXuELSpHzVXgNU:APA91bGCqM-UqUBKPwsk-hlYH8XuOE1kOI6QimQbHuGdA6RKQJ1N9b1FAer-CWQ-vOB61Gp5wF1vAiVNYODcRukLFoK2lTZd3w9tVfk_uU-aSqpGicPObGSiKiyE6gXq-8g6DrVprxOa'; // Replace with the actual token

        // Replace with your access token
        $accessToken = 'ya29.c.c0ASRK0GboJdNGKzEK6fMATUiAvue7CoOldzYdY-CtUEtAAEIEkAmf_avlRQFncboWnVaSkznCZ4MbDqapLBSzwps0AVfjj3Js-3vXtrQT56tYQMCcc539zO_0COLktd81SD43zOW2j1fvmedsL3ytA8aFo8Oc7--Fi9XgC4NGpefOsrLaj5rTlUd6dqz-aQTGWbZePU_ZUMThKdRMmWranHQv6jvOx3cdJ4AyFRwRkYBE09JDYwqPrLZ0YMf44GVuns_7gmMcQXhN7xc-lipCoF8olfFTpGqk1nmi505Q-c1VcJOme4VytGosE4PLjd7x6DxljB_DFdo_EEiLSVZIiIaPR8kZwFm7S87pmsdEIu4eRswFqfV0QIhlFEVG0gH391CXkbxp520ai3FXWrujbtz02bz0R4cr7v_hOSVchXVQyIbuw36MyM7mUh807WpdeBXuMSap6u6BuvjxMqmWqvl4ndgiezm7wqn6716lr-pOSjco05VRmepY9ysJvR3FUwt1jkpdnJBv-nJdsBtUlUwsRdn_Xiy0B6-1X-b3cem53OBVRh145lFYInFhyy-eQ3U6_p5p3Y1IRoW03qXs083bBOSeu0UpkhQypj6Owm096bBJSl8SXJJda97Xyslmb8pwQ64sg_rar73wo_MWWltygsQ-S0yk3p3fb5ha4eaOv1jBJqemd2MmhnvJyrzth2eX1rg3caIn90eOouJeVcykOfdi-k5sXzRSbhgbRjFBchZmUUyi49edxVoIwhze_F5dumcnn_48357Flg76R9eXfjkx7x_BRU-Mw15v6Yo3wVjovY5J7fU6rn00yj-_0uqhM3hQqaZdyx_vw4dsoWcyaVtvZig-Js65B56Sc9rJ1kU-y90nVbf01zwdtIdeazu8voSWmR7kQfRQZs8c5o6iqOSWgB2rZq3_phunYijXQqo2qUxvtw-e2SyezWfX1qFi5m8Qcpu8mnsUqtdgb9-BvmwdFMZx4qi_y9cXn4wah6qe35XaYU'; // Replace with the actual access token

        // Build the notification message
        $message = [
            'message' => [
                'token' => $fcmToken,
                'notification' => [
                    'title' => 'Al-tcham eating indomi',
                    'body' => 'Alooooooooo ardddddddddaaaaaaaaaa is online, check him out!',
                ],
                'data' => [
                    'key1' => 'value1',
                    'key2' => 'value2',
                ],
            ],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $accessToken,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/v1/projects/vetcare-c8e34/messages:send', $message);

        if ($response->successful()) {
            return response()->json(['message' => 'Notification sent successfully!']);
        } else {
            return response()->json(['error' => 'Failed to send notification.', 'details' => $response->json()], 500);
        }
    }
}

//notification in (appointments status, your order has been received, when add something to the medical record)
