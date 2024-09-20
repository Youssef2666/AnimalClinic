<?php

namespace App\Filament\Resources\MedicalRecordResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class VaccinationsRelationManager extends RelationManager
{
    protected static string $relationship = 'vaccinations';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('vaccination_category_id')
                ->relationship('vaccinationCategory', 'name')
                ->required(),

                Hidden::make('user_id')
                ->default(Auth::id()),
                
                DateTimePicker::make('vaccination_date')
                ->required(),

                TextInput::make('notes')
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('notes')
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

                TextColumn::make('vaccination_date')
                ->label('Vaccination Date')
                ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
