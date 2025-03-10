<?php

namespace App\Http\Controllers;

use App\Models\Surgery;
use Illuminate\Http\Request;
use App\traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class SurgeryController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $surgeries = Surgery::all();
        return $this->success($surgeries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $surgery = Surgery::create([
            'name' => $request->name,
            'description' => $request->description,
            'surgery_category_id' => $request->surgery_category_id,
            'medical_record_id' => $request->medical_record_id,
            'user_id' => Auth::id(),
            'surgery_date' => $request->surgery_date,
            'notes' => $request->notes,
            'cost' => $request->cost
        ]);

        return $this->success($surgery);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $surgery = Surgery::find($id);
        return $this->success($surgery);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $surgery = Surgery::find($id);
        $surgery->update($request->all());
        return $this->success($surgery);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $surgery = Surgery::find($id);
        $surgery->delete();
        return $this->success($surgery);
    }
}