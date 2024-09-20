<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurgeryCategoryResource\Pages;
use App\Filament\Resources\SurgeryCategoryResource\RelationManagers;
use App\Models\SurgeryCategory;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurgeryCategoryResource extends Resource
{
    protected static ?string $model = SurgeryCategory::class;

    protected static ?string $navigationGroup = 'Categories';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required()
                ->label('Surgery Category Name'),

                TextInput::make('description')
                ->label('Description'),

                TextInput::make('cost')
                ->label('Cost'),
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
                TextColumn::make('cost')
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                
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
            'index' => Pages\ListSurgeryCategories::route('/'),
            'create' => Pages\CreateSurgeryCategory::route('/create'),
            'edit' => Pages\EditSurgeryCategory::route('/{record}/edit'),
        ];
    }
}
