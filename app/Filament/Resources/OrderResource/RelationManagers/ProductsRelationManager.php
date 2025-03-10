<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable(),
                Tables\Columns\TextColumn::make('category.name')->searchable(),
                Tables\Columns\TextColumn::make('quantity')->searchable(),
                Tables\Columns\TextColumn::make('price_at_purchase')->searchable(),
                Tables\Columns\TextColumn::make('total_price')
                ->badge(function ($state) {
                    return 'primary';
                })
                    ->label('Total Price')
                    ->getStateUsing(function ($record) {
                        // Access the pivot table values
                        $quantity = $record->pivot->quantity ?? 0;
                        $priceAtPurchase = $record->pivot->price_at_purchase ?? 0;

                        // Calculate the total price
                        return $quantity * $priceAtPurchase;
                    })->money('LYD'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
            ])
            ->actions([
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                ]),
            ]);
    }
}
