<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ProductStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('عدد المنتجات', Product::count()),
        ];
    }

    protected function getColumns(): int
    {
        return 1;
    }
}
