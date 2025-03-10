<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\traits\ResponseTrait;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $medicines = Medicine::all();
        return $medicines;
    }


    public function store(Request $request)
    {
        $medicine = Medicine::create($request->all());
        return $this->success($medicine, 'medicine created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $medicine = Medicine::find($id);
        return $medicine;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->update($request->all());
        return $this->success($medicine, 'medicine updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->delete();
        return $this->success($medicine, 'medicine deleted successfully');
    }
}
