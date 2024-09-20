<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\VaccinationCategory;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VaccinationCategoryResource\Pages;
use App\Filament\Resources\VaccinationCategoryResource\RelationManagers;

class VaccinationCategoryResource extends Resource
{
    protected static ?string $model = VaccinationCategory::class;

    protected static ?string $navigationGroup = 'Categories';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required()
                ->label('Vaccination Category Name'),

                TextInput::make('description')
                ->label('Vaccination Category Name'),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->searchable()
                ->sortable(),

                TextColumn::make('description')
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVaccinationCategories::route('/'),
            'create' => Pages\CreateVaccinationCategory::route('/create'),
            'edit' => Pages\EditVaccinationCategory::route('/{record}/edit'),
        ];
    }
}
