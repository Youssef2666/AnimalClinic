<?php

namespace App\Filament\Resources\MedicineResource\Pages;

use App\Filament\Resources\MedicineResource;
use App\Models\Medicine;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateMedicine extends CreateRecord
{
    protected static string $resource = MedicineResource::class;

    protected function handleRecordCreation(array $data): Medicine
    {
        return Medicine::create([
            'medicine_category_id' => $data['category_id'],
            'description' => $data['description'],
            'medical_record_id' => $data['medical_record_id'],
            'user_id' => Auth::id(),
        ]);
    }
}
