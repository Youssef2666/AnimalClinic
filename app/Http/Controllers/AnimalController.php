<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimalRequest;
use App\Http\Resources\AnimalResource;
use App\Models\Animal;
use App\traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnimalController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $animals = Animal::with('user')->get();
        return AnimalResource::collection($animals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnimalRequest $request)
    {
        $animal = Animal::create([
            'name' => $request->name,
            'age' => $request->age,
            'user_id' => Auth::id(),
            'animal_type' => $request->animal_type,
        ]);
        return $this->success($animal, 'animal created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $animal = Animal::findOrFail($id);
        return new AnimalResource($animal);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $animal = Animal::findOrFail($id);
        $animal->update($request->all());
        return $this->success($animal, 'animal updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Animal::destroy($id);
        return $this->success(null, 'animal deleted successfully');
    }
}
