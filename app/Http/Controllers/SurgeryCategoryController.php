<?php

namespace App\Http\Controllers;

use App\Models\SurgeryCategory;
use App\traits\ResponseTrait;
use Illuminate\Http\Request;

class SurgeryCategoryController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $surgeries = SurgeryCategory::all();
        return $this->success($surgeries);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $surgery = SurgeryCategory::create($request->all());

        return $this->success($surgery);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $surgery = SurgeryCategory::find($id);
        return $this->success($surgery);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $surgery = SurgeryCategory::find($id);
        $surgery->update($request->all());
        return $this->success($surgery);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $surgery = SurgeryCategory::find($id);
        $surgery->delete();
        return $this->success($surgery);
    }
}