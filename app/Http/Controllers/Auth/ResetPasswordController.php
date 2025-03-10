<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Laravel\Jetstream\ConfirmsPasswords;
use Illuminate\Auth\Passwords\CanResetPassword;

class ResetPasswordController extends Controller
{
    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
            'token' => 'required',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return view('auth.password-reset-success')->with('message', 'تم تغيير كلمة المرور, تستطيع تسجيل الدخول في التطبيق'); 
            }
            return view('auth.password-reset-failure')->with('message', 'فشل تغيير كلمة المرور، تحقق من صحة البيانات وحاول مرة أخرى');
        }
}
