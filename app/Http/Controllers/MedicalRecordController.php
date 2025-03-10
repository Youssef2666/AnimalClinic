<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicalRecord;
use App\traits\ResponseTrait;
use App\Http\Resources\MedicalRecordResource;

class MedicalRecordController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $medicalRecords = MedicalRecord::with('surgeries.surgeryCategory', 'vaccinations.vaccinationCategory', 'medicines.category')->get();
        return MedicalRecordResource::collection($medicalRecords);
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
