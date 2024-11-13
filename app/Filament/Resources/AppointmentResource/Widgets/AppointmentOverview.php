<?php

namespace App\Filament\Resources\AppointmentResource\Widgets;

use App\Models\Appointment;
use App\Enums\AppointmentStatus;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class AppointmentOverview extends BaseWidget
{

    protected static bool $isLazy = true;
    protected function getStats(): array
    {
        return [
            Stat::make('المواعيد', Appointment::count())
                ->description('العدد الكلي للمواعيد'),
            Stat::make('المواعيد المقبولة', Appointment::where('status', AppointmentStatus::CONFIRMED->value)->count()),
            Stat::make('المواعيد الملغية', Appointment::where('status', AppointmentStatus::CANCELED->value)->count()),
            Stat::make('المواعيد المكتملة', Appointment::where('status', AppointmentStatus::COMPLETED->value)->count()),
            
                
        ];
    }
}
