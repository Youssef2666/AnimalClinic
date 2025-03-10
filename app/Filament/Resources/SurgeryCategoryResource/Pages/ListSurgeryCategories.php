<?php

namespace App\Filament\Resources\SurgeryCategoryResource\Pages;

use App\Filament\Resources\SurgeryCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSurgeryCategories extends ListRecords
{
    protected static string $resource = SurgeryCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
