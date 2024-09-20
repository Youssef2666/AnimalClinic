<?php

namespace App\Filament\Resources\SurgeryCategoryResource\Pages;

use App\Filament\Resources\SurgeryCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSurgeryCategory extends EditRecord
{
    protected static string $resource = SurgeryCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
