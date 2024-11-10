<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\traits\ResponseTrait;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $paymentMethods = PaymentMethod::all();
        return $this->success($paymentMethods);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paymentMethod = PaymentMethod::find($id);
        return $this->success($paymentMethod);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
