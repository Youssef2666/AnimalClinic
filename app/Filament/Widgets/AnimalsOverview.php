<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Animal;
use App\Models\AnimalCategory;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class AnimalsOverview extends BaseWidget
{
    public static ?int $sort = 2;

    protected function getStats(): array
    {
        return [
            Stat::make('الحيوانات', Animal::count())
                ->description('العدد الكلي للحيوانات')
                ->chart($this->getMonthlyCounts(Animal::class))
                ->chartColor('primary'),


            Stat::make('عدد التصنيفات', AnimalCategory::count())
                ->description('العدد الكلي لتصنيفات الحيوانات')
                ->chart($this->getMonthlyCounts(AnimalCategory::class))
                ->chartColor('secondary'),
        ];
    }

    protected function getColumns(): int
    {
        return 2;
    }

    private function getMonthlyCounts(string $model): array
    {
        $data = [];
        $year = Carbon::now()->year;

        for ($month = 1; $month <= 12; $month++) {
            $data[] = $model::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();
        }

        return $data;
    }

    public static function canView(): bool
    {
        return Auth::user()->isAdmin();
    }
}
