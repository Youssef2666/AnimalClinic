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

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
                TextColumn::make('id'),
                TextColumn::make('user.name'),
                TextColumn::make('order_date')->sortable(),
                TextColumn::make('status')
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
    ->label('Total Price')
    ->getStateUsing(fn(Order $record) => $record->total_price) // Accessing the attribute from the model
    ->sortable(),
            ])
            ->filters([
                // Add filters here
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('changeStatus')
    ->label('Change Status')
    ->icon('heroicon-s-pencil')
    ->form([
        Forms\Components\Select::make('status')
            ->label('Order Status')
            ->options(
                collect(OrderStatus::cases())->mapWithKeys(fn(OrderStatus $status) => [
                    $status->value => $status->label()
                ])->toArray()
            )
            ->required(),
                ])
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
}
