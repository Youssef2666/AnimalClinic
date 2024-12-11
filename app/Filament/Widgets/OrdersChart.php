<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Enums\AppointmentStatus;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrdersChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    public static ?int $sort = 3;

    protected function getData(): array
    {
        $data = Order::select('status', DB::raw('count(*) as total'))
        ->groupBy('status')
        ->pluck('total', 'status')
        ->toArray();
        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => array_values($data),
                ]
            ],
            'labels' => AppointmentStatus::cases(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public static function canView(): bool
    {
        return Auth::user()->isAdmin();
    }
}
