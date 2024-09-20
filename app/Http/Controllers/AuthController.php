<?php

namespace App\Http\Controllers;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use App\Mail\ConfirmEmail;
use Illuminate\Http\Request;
use App\traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\OtpVerifyRequest;
use App\Notifications\EmailVerificationNotification;

class AuthController extends Controller
{
    use ResponseTrait;

    public function __construct(private Otp $otp){
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
        }