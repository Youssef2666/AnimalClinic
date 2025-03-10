<?php

namespace App\Filament\Resources\MedicineCategoryResource\Pages;

use App\Filament\Resources\MedicineCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMedicineCategory extends EditRecord
{
    protected static string $resource = MedicineCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
