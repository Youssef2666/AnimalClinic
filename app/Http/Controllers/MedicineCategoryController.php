<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicineCategory;
use App\traits\ResponseTrait;

class MedicineCategoryController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $medicines = MedicineCategory::all();
        return $this->success($medicines);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $medicine = MedicineCategory::create($request->all());
        return $this->success($medicine);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $medicine = MedicineCategory::find($id);
        return $this->success($medicine);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $medicine = MedicineCategory::find($id);
        $medicine->update($request->all());
        return $this->success($medicine);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $medicine = MedicineCategory::find($id);
        $medicine->delete();
        return $this->success($medicine);
    }
}
