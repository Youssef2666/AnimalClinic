<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Medicine;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\MedicineResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\MedicineResource\RelationManagers;

class MedicineResource extends Resource
{
    protected static ?string $model = Medicine::class;
    protected static ?string $modelLabel =  'دواء';
    protected static ?string $pluralModelLabel = 'أدوية';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('category_id')  
                ->relationship('category', 'name')
                ->required()
                ->label('اسم الدواء'),

                Select::make('medical_record_id')  
                ->relationship('medicalRecord', 'notes')  
                ->required()
                ->label('رقم السجل الصحي'),

                TextInput::make('description')
                ->label('وصف'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')
                ->label('اسم الدواء')
                ->searchable(),

                TextColumn::make('medicalRecord.id')
                ->label('رقم السجل الصحي')
                ->searchable(),
                TextColumn::make('medicalRecord.notes')
                ->label('ملاحظات')
                ->searchable()
                ->toggleable(),

                TextColumn::make('description')
                ->label('وصف')
                ->searchable(),

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
            'index' => Pages\ListMedicines::route('/'),
            'create' => Pages\CreateMedicine::route('/create'),
            'edit' => Pages\EditMedicine::route('/{record}/edit'),
        ];
    }
}
