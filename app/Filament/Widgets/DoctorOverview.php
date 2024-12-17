<?php

namespace App\Filament\Widgets;

use App\Models\Doctor;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DoctorOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return true;
    }
    protected function getStats(): array
    {
        return [
            Stat::make('الأطباء', Doctor::count())
                ->description('العدد الكلي للأطباء'),
            // Stat::make('الأطباء المتاحين', Doctor::where('status', 1)->count()),
        ];
    }

}
