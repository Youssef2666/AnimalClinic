<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimalCategoryRequest;
use App\Models\AnimalCategory;
use App\traits\ResponseTrait;
use Illuminate\Http\Request;

class AnimalCategoryController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $categories = AnimalCategory::all();
        return $categories;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnimalCategoryRequest $request)
    {
        $category = AnimalCategory::create($request->all());
        return $this->success($category, 'category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
