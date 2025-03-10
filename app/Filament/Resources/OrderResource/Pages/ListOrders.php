<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use App\Enums\OrderStatus;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\OrderResource\Widgets\OrderOverview;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            OrderOverview::class
        ];
    }

    public function getTabs(): array
{
    return [
        'All' => Tab::make()->label( 'الكل'),

        'Delivered' => Tab::make()
            ->label('تم التوصيل')
            ->query(fn (Builder $query) => $query->where('status', OrderStatus::DELIVERED->value)),

        'Confirmed' => Tab::make()
            ->label( 'تم التأكيد')
            ->query(fn (Builder $query) => $query->where('status', OrderStatus::CONFIRMED->value)),

        'Canceled' => Tab::make()
            ->label('تم الالغاء')
            ->query(fn (Builder $query) => $query->where('status', OrderStatus::CANCELED->value)),
    ];
}

}
