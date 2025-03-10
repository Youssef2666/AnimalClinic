<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnimalRequest;
use App\Http\Resources\AnimalResource;
use App\Models\Animal;
use App\Models\MedicalRecord;
use App\traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnimalController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        try {
            $animals = Animal::with(['user', 'category', 'medicalRecord'])->get();
            return AnimalResource::collection($animals);
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function store(StoreAnimalRequest $request)
    {
        try {
            $animal = DB::transaction(function () use ($request) {
                $data = [
                    'user_id' => Auth::id(),
                    'animal_category_id' => $request->animal_category_id,
                    'animal_type' => $request->animal_type,
                    'name' => $request->name,
                    'age' => $request->age,
                    'weight' => $request->weight,
                    'gender' => $request->gender,
                ];

                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('animals', 'public');
                    $data['image'] = $imagePath;
                }

                $animal = Animal::create($data);

                $animal->medicalRecord()->create([
                    'animal_id' => $animal->id,
                    'notes' => 'This is the medical record for the animal',
                ]);

                return $animal;
            });

            return $this->success(
                ['animal' => $animal, 'medical_record' => $animal->medicalRecord],
                'Animal created successfully',
                201
            );

        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }
    }

    public function show(string $id)
    {
        $animal = Animal::findOrFail($id)->with('category')->first();
        return new AnimalResource($animal);
    }

    public function update(Request $request, string $id)
    {
        $animal = Animal::findOrFail($id);
        $animal->update($request->all());
        return $this->success($animal, 'animal updated successfully');
    }

    public function destroy(string $id)
    {
        Animal::destroy($id);
        return $this->success(null, 'animal deleted successfully');
    }

    public function getUserAnimals(Request $request, $id)
    {
        $animals = Animal::with([
            'appointments' => function ($query) {
                $query->orderBy('updated_at', 'desc');
            },
            'category',
            'appointments.zoomAppointment' => function ($query) {
                $query->withoutGlobalScope('doctor_appointments');
            },
        ])->where('user_id', $id)->get();

        return AnimalResource::collection($animals);
    }

    public function getMedicalRecordByAnimalId(string $id)
    {
        $medical_record = MedicalRecord::where('animal_id', $id)->with('animal', 'surgeries','surgeries.surgeryCategory',  'vaccinations', 'vaccinations.vaccinationCategory', 'medicines', 'medicines.category')->first();
        return $medical_record;
    }
}
