<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Vaccination;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\VaccinationResource\Pages;
use App\Filament\Resources\VaccinationResource\RelationManagers;

class VaccinationResource extends Resource
{
    protected static ?string $model = Vaccination::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('vaccination_category_id')
                ->relationship('vaccinationCategory', 'name')
                ->required(),

                Hidden::make('user_id')
                ->default(Auth::id()),
                
                Select::make('medical_record_id')
                ->relationship('medicalRecord', 'notes')
                ->required(),
                
                DateTimePicker::make('vaccination_date')
                ->label('Vaccination Date')
                ->required(),

                TextInput::make('notes')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('vaccinationCategory.name')
                ->label('Vaccination Name')
                ->searchable(),

                TextColumn::make('vaccinationCategory.cost')
                ->label('Vaccination Cost')
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
            'index' => Pages\ListVaccinations::route('/'),
            'create' => Pages\CreateVaccination::route('/create'),
            'edit' => Pages\EditVaccination::route('/{record}/edit'),
        ];
    }
}
