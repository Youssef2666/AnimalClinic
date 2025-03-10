<?php
namespace App\Filament\Resources\OrderResource\Widgets;

use App\Enums\OrderStatus;
use App\Models\Order;
use Carbon\Carbon;
use Filament\Support\Colors\Color;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderOverview extends BaseWidget
{
    protected static bool $isLazy = true;

    protected function getStats(): array
    {
        return [
            Stat::make("عدد الطلبات", Order::count())
                ->description("العدد الكلي للطلبات")
                ->chart($this->getOrdersCountForLast7Days())
                ->chartColor('primary'),

            Stat::make("عدد الطلبات المؤكدة", Order::where('status', OrderStatus::CONFIRMED->value)->count())
                ->description("طلبات مؤكدة خلال الأسبوع")
                ->chart($this->getConfirmedOrdersCountForLast7Days())
                ->chartColor(Color::Green),

            Stat::make("عدد الطلبات المستلمة", Order::where('status', OrderStatus::DELIVERED->value)->count())
                ->description("طلبات مستلمة خلال الأسبوع")
                ->chart($this->getDeliveredOrdersCountForLast7Days())
                ->chartColor(Color::Emerald),

            Stat::make("عدد الطلبات الملغية", Order::where('status', OrderStatus::CANCELED->value)->count())
                ->description("طلبات ملغية خلال الأسبوع")
                ->chart($this->getCanceledOrdersCountForLast7Days())
                ->chartColor(Color::Red),
        ];
    }

    private function getOrdersCountForLast7Days(): array
    {
        return $this->getOrderCountsByStatus();
    }

    private function getConfirmedOrdersCountForLast7Days(): array
    {
        return $this->getOrderCountsByStatus(OrderStatus::CONFIRMED->value);
    }

    private function getDeliveredOrdersCountForLast7Days(): array
    {
        return $this->getOrderCountsByStatus(OrderStatus::DELIVERED->value);
    }

    private function getCanceledOrdersCountForLast7Days(): array
    {
        return $this->getOrderCountsByStatus(OrderStatus::CANCELED->value);
    }

    private function getOrderCountsByStatus($status = null): array
    {
        $orderCounts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $query = Order::whereDate('created_at', $date);
            if ($status) {
                $query->where('status', $status);
            }
            $orderCounts[] = $query->count();
        }

        return $orderCounts;
    }
}
