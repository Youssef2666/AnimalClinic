<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MedicineCategory;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MedicineCategoryResource\Pages;
use App\Filament\Resources\MedicineCategoryResource\RelationManagers;

class MedicineCategoryResource extends Resource
{
    protected static ?string $model = MedicineCategory::class;
    protected static ?string $modelLabel =  'دواء';
    protected static ?string $pluralModelLabel = 'أدوية';

    protected static ?string $navigationGroup = 'الأصناف';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required()
                ->label('اسم الدواء'),

                TextInput::make('description')
                ->label('وصف'),

                TextInput::make('cost')
                ->label('سعر الدواء'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label('اسم الدواء')
                ->searchable()
                ->sortable(),

                TextColumn::make('description')
                ->label('وصف')
                ->searchable()
                ->sortable(),
                
                TextColumn::make('cost')
                ->label('سعر الدواء')
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
            'index' => Pages\ListMedicineCategories::route('/'),
            'create' => Pages\CreateMedicineCategory::route('/create'),
            'edit' => Pages\EditMedicineCategory::route('/{record}/edit'),
        ];
    }
}
