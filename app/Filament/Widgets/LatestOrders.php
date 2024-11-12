<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Enums\OrderStatus;
use Filament\Tables\Table;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\OrderResource;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 'full';

    protected function getTableHeading(): string
    {
        return 'اخر الطلبات';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('id')->searchable()->sortable()->label('رقم الطلب'),
                TextColumn::make('user.name')->searchable()->sortable()->label('اسم المستخدم'),
                TextColumn::make('order_date')->sortable()->label('تاريخ الطلب'),
                TextColumn::make('paymentMethod.name')->sortable()->label('طريقة الدفع'),
                TextColumn::make('status')->label('الحالة')
                    ->badge()
                    ->color(function ($state) {
                        return match ($state) {
                            OrderStatus::DELIVERED->value => 'primary',
                            OrderStatus::CONFIRMED->value => Color::Emerald,
                            OrderStatus::CANCELED->value => 'danger',
                            default => 'secondary',
                        };
                    }),
                TextColumn::make('total_price')
                    ->label('السعر الكلي')
                    ->getStateUsing(fn(Order $record) => $record->total_price)
                    ->sortable(),
            ]);
    }
}
