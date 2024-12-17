<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPhone;
use App\Services\OTPService;
use Illuminate\Http\Request;
use App\traits\ResponseTrait;
use App\Services\VonageService;
use Illuminate\Support\Facades\Auth;

class UserPhoneController extends Controller
{
    use ResponseTrait;

    public function __construct(private OTPService $otpService){
    }
    public function index()
    {
        $phones = Auth::user()?->phones()->get();
        return $this->success($phones);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|unique:user_phones,phone_number',
        ]);

        $user = Auth::user();

        if ($user->phones()->count() >= 2) {
            return response()->json(['error' => 'لا يمكن إضافة أكثر من 2 رقم هاتف'], 422);
        }

        $user->phones()->create($request->only('phone_number'));

        return response()->json(['success' => 'تم إضافة رقم الهاتف بنجاح'], 201);
    }

    
    public function show(string $id)
    {
        $phone = User::findOrFail($id)->phones()->first();
        return $this->success($phone);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $phone = UserPhone::where('id', $id)->where('user_id', Auth::user()->id)->first();
        $phone->update($request->all());
        return $this->success($phone, 'تم تحديث رقم الهاتف بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $phone = User::findOrFail($id)->phones()->first();
        $phone->delete();
        return $this->success(null, 'phone deleted successfully');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['phone_number' => 'required|exists:user_phones,phone_number']);

        $phone = UserPhone::where('phone_number', $request->phone_number)->first();

        if ($phone->isVerified()) {
            return response()->json(['error' => 'This phone number is already verified.'], 422);
        }

        if ($this->otpService->sendOtp($phone->phone_number)) {
            return response()->json(['success' => 'OTP sent successfully.']);
        }

        return response()->json(['error' => 'Failed to send OTP.'], 500);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|exists:user_phones,phone_number',
            'otp' => 'required|integer',
        ]);

        $phone = UserPhone::where('phone_number', $request->phone_number)->first();

        if ($this->otpService->validateOtp($phone->phone_number, $request->otp)) {
            $phone->update(['verified_at' => now()]);

            return response()->json(['success' => 'Phone number verified successfully.']);
        }

        return response()->json(['error' => 'Invalid OTP.'], 422);
    }
}
