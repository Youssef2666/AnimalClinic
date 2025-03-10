<?php

namespace App\Filament\Resources\AppointmentResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\AppointmentResource\Widgets\AppointmentOverview;
use App\Filament\Resources\AppointmentResource\Widgets\AppointmentInterviewOverview;

class ListAppointments extends ListRecords
{
    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AppointmentOverview::class,
            AppointmentInterviewOverview::class
        ];
    }

    
}
