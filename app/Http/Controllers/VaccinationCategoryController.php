<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VaccinationCategory;
use App\traits\ResponseTrait;

class VaccinationCategoryController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $vaccinations = VaccinationCategory::all();
        return $this->success($vaccinations);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vaccination = VaccinationCategory::create($request->all());
        return $this->success($vaccination);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vaccination = VaccinationCategory::find($id);
        return $this->success($vaccination);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vaccination = VaccinationCategory::find($id);
        $vaccination->update($request->all());
        return $this->success($vaccination);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vaccination = VaccinationCategory::find($id);
        $vaccination->delete();
        return $this->success($vaccination);
    }
}
