<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Product;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class ProductsChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    public static ?int $sort = 3;


    protected function getData(): array
    {
        $data = $this->getProductsPerMonth();
        return [
            'datasets' => [
                [
                    'label' => 'Products',
                    'data' => $data['productsPerMonth'],
                ],
            ],
            'labels' => $data['months'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getProductsPerMonth(): array
    {
        $now = Carbon::now();
        $productsPerMonth = []; // Declare array outside the map function

        $months = collect(range(1, 12))->map(function ($month) use ($now, &$productsPerMonth) { // Pass $productsPerMonth by reference
            $count = Product::whereYear('created_at', $now->year) // Ensure year is also considered
                ->whereMonth('created_at', $month)
                ->count();
            $productsPerMonth[] = $count; // Add the count to $productsPerMonth array
            return Carbon::createFromDate($now->year, $month, 1)->format('M'); // Format each month as 'Jan', 'Feb', etc.
        })->toArray();

        return [
            'productsPerMonth' => $productsPerMonth,
            'months' => $months,
        ];
    }

    public static function canView(): bool
    {
        return Auth::user()->isAdmin();
    }

}
