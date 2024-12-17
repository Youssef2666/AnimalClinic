<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserPhone;
use App\Services\OTPService;
use App\traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserPhoneController extends Controller
{
    use ResponseTrait;

    public function __construct(private OTPService $otpService)
    {
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
            'phone_number' => [
                'required',
                'unique:user_phones,phone_number',
                'regex:/^(092|091|093)[0-9]{7}$/',
            ],
        ]);

        $user = Auth::user();

        if ($user->phones()->count() >= 2) {
            return response()->json(['error' => 'لا يمكن إضافة أكثر من 2 رقم هاتف'], 422);
        }

        $formattedPhoneNumber = preg_replace('/^0/', '+218', $request->phone_number);

        $user->phones()->create(['phone_number' => $formattedPhoneNumber]);

        return response()->json(['success' => 'تم إضافة رقم الهاتف بنجاح'], 201);
    }

    public function show(string $id)
    {
        $phone = User::findOrFail($id)->phones()->first();
        return $this->success($phone);
    }

    public function update(Request $request, string $id)
    {
        $phone = UserPhone::where('id', $id)->where('user_id', Auth::user()->id)->first();

        if (!$phone) {
            return response()->json(['error' => 'رقم الهاتف غير موجود'], 404);
        }

        try {
            $request->validate([
                'phone_number' => [
                    'required',
                    'regex:/^(092|091|093)[0-9]{7}$/',
                    Rule::unique('user_phones', 'phone_number')->ignore($phone->id),
                ],
            ]);

            $formattedPhoneNumber = preg_replace('/^0/', '+218', $request->phone_number);

            $phone->update(['phone_number' => $formattedPhoneNumber]);

            return response()->json(['success' => 'تم تحديث رقم الهاتف بنجاح'], 200);
        } catch (\Exception $e) {
            return $this->error($e->getMessage());
        }
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
