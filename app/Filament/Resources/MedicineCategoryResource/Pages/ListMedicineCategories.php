<?php

namespace App\Filament\Resources\MedicineCategoryResource\Pages;

use App\Filament\Resources\MedicineCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMedicineCategories extends ListRecords
{
    protected static string $resource = MedicineCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
