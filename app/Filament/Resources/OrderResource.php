<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Order;
use Filament\Forms\Form;
use App\Enums\OrderStatus;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Colors\Color;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\ProductsRelationManager;
use App\Filament\Resources\OrderResource\Widgets\OrderOverview;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?string $modelLabel =  'طلب';
    protected static ?string $pluralModelLabel = 'طلبات';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected function getHeaderWidgets(): array
    {
        return [
            OrderOverview::class
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Form schema definition here
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->sortable()->label('رقم الطلب'),
                TextColumn::make('user.name')->searchable()->sortable()->label('اسم المستخدم'),
                TextColumn::make('order_date')->sortable()->label('تاريخ الطلب'),
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
    TextColumn::make('total_price') // Adding the total price column
    ->label('السعر الكلي')
    ->getStateUsing(fn(Order $record) => $record->total_price) // Accessing the attribute from the model
    ->sortable(),
            ])
            ->filters([
                // Add filters here
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('changeStatus')
    ->label('تغيير الحالة')
    ->icon('heroicon-s-pencil')
    ->form([
        Forms\Components\Select::make('status')
            ->label('الحالة')
            ->options(
                collect(OrderStatus::cases())->mapWithKeys(fn(OrderStatus $status) => [
                    $status->value => $status->label()
                ])->toArray()
            )
            ->required(),
                ])
                ->icon('heroicon-s-check-badge')
                ->action(function (Order $record, array $data) {
                    $record->update(['status' => $data['status']]);
                })
                ->visible(fn (Order $record) => $record->status !== OrderStatus::DELIVERED->value)           
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProductsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
{
    return [
       OrderOverview::class,
    ];
}
}
