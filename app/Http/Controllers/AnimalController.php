<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;
use App\traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AnimalResource;
use App\Http\Requests\StoreAnimalRequest;
use App\Models\MedicalRecord;

class AnimalController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        try {
        $animals = Animal::with(['user', 'category','medicalRecord'])->get();
        return AnimalResource::collection($animals);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnimalRequest $request)
    { 
        try {
            // Start a database transaction
            $animal = DB::transaction(function () use ($request) {
                // Create the animal record
                $animal = Animal::create([
                    'user_id' => Auth::id(),
                    'animal_category_id' => $request->animal_category_id,
                    'animal_type' => $request->animal_type,
                    'name' => $request->name,
                    'age' => $request->age,
                    'weight' => $request->weight,
                    'gender' => $request->gender,
                ]);

                // Create the medical record associated with the animal
                $animal->medicalRecord()->create([
                    'animal_id' => $animal->id,
                    'notes' => 'This is the medical record for the animal'
                ]);

                return $animal;
            });

            return $this->success(['animal' => $animal, 'medical_record' => $animal->medicalRecord], 'Animal created successfully', 201);

        } catch (\Throwable $th) {
            // Handle exceptions and return the error message
            return $th->getMessage();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $animal = Animal::findOrFail($id)->with('category')->first();
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

    public function getUserAnimals(Request $request, $id){
        $animals = Animal::with('appointments')->where('user_id', $id)->get();
        return AnimalResource::collection($animals);
    }

    public function getMedicalRecordByAnimalId(string $id){
        $medical_record = MedicalRecord::where('animal_id', $id)->with('animal', 'surgeries', 'vaccinations', 'medicines')->first();
        return $medical_record;       
    }
}