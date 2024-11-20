<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPhoneController extends Controller
{
    use ResponseTrait;
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

    /**
     * Display the specified resource.
     */
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
        $phone = User::findOrFail($id)->phones()->first();
        $phone->update($request->all());
        return $this->success($phone, 'phone updated successfully');
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
}
