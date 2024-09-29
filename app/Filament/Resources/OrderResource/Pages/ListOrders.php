<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use App\Enums\OrderStatus;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
{
    return [
        'All' => Tab::make(),

        'Delivered' => Tab::make()
            ->label('Delivered')
            ->query(fn (Builder $query) => $query->where('status', OrderStatus::DELIVERED->value)),

        'Confirmed' => Tab::make()
            ->label('Confirmed')
            ->query(fn (Builder $query) => $query->where('status', OrderStatus::CONFIRMED->value)),

        'Canceled' => Tab::make()
            ->label('Canceled')
            ->query(fn (Builder $query) => $query->where('status', OrderStatus::CANCELED->value)),
    ];
}

}
