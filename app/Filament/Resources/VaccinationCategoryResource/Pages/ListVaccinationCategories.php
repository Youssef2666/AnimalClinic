<?php

namespace App\Filament\Resources\VaccinationCategoryResource\Pages;

use App\Filament\Resources\VaccinationCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVaccinationCategories extends ListRecords
{
    protected static string $resource = VaccinationCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
