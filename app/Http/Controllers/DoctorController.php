<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Http\Resources\DoctorResource;
use App\Models\Doctor;
use App\traits\ResponseTrait;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        try {
            $doctors = Doctor::all();
            return DoctorResource::collection($doctors);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDoctorRequest $request)
    {
        try {
            $doctor = Doctor::create($request->validated());
        } catch (\Throwable $th) {
            return $this->error($th->getMessage());
        }
        return $this->success($doctor, 'doctor created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = Doctor::findOrFail($id);
        return $this->success($doctor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update($request->all());
        return $this->success($doctor, 'doctor updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Doctor::destroy($id);
        return $this->success(null, 'doctor deleted successfully');
    }
}