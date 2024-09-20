<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Surgery;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use App\Filament\Resources\SurgeryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SurgeryResource\RelationManagers;

class SurgeryResource extends Resource
{
    protected static ?string $model = Surgery::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('surgery_category_id')
                ->relationship('surgeryCategory', 'name')
                ->required(),
                
                Hidden::make('user_id')
                ->default(Auth::id()),
                
                Select::make('medical_record_id')
                ->relationship('medicalRecord', 'notes')
                ->required(),

                DateTimePicker::make('surgery_date')
                ->required(),

                TextInput::make('notes')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('surgeryCategory.name')
                ->label('Surgery Name')
                ->searchable(),

                TextColumn::make('surgeryCategory.cost')
                ->label('Surgery Cost')
                ->searchable(),

                TextColumn::make('surgery_date')
                ->label('Surgery Date')
                ->searchable(),

                TextColumn::make('medicalRecord.id')
                ->label('Medical Record ID')
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
            'index' => Pages\ListSurgeries::route('/'),
            'create' => Pages\CreateSurgery::route('/create'),
            'edit' => Pages\EditSurgery::route('/{record}/edit'),
        ];
    }
}
