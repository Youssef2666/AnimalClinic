<?php

namespace App\Http\Controllers;

use App\Models\Vaccination;
use App\traits\ResponseTrait;
use Illuminate\Http\Request;

class VaccinationController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $vaccintaions = Vaccination::all();
        return $this->success($vaccintaions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $vaccination = Vaccination::create($request->all());
        return $this->success($vaccination);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vaccination = Vaccination::find($id);
        return $this->success($vaccination);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vaccination = Vaccination::find($id);
        $vaccination->update($request->all());
        return $this->success($vaccination);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vaccination = Vaccination::find($id);
        $vaccination->delete();
        return $this->success($vaccination);
    }
}
