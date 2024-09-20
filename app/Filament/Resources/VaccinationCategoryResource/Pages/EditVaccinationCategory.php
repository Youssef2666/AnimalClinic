<?php

namespace App\Filament\Resources\VaccinationCategoryResource\Pages;

use App\Filament\Resources\VaccinationCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVaccinationCategory extends EditRecord
{
    protected static string $resource = VaccinationCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
