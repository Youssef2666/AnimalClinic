<?php

namespace App\Filament\Resources\AdminPanelResource\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Users', User::count())
            ->description('Total number of users')
            ->chart([
                1, 3, 2, 5, 3, 8,
            ])
            ->chartColor('primary'),
        ];
    }
}
