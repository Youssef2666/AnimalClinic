<?php

namespace App\Filament\Resources\MedicalRecordResource\RelationManagers;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use App\Notifications\MedicalRecordUpdatedNotification;
use Filament\Resources\RelationManagers\RelationManager;

class SurgeriesRelationManager extends RelationManager
{
    protected static string $relationship = 'surgeries';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('surgery_category_id')
                    ->relationship('surgeryCategory', 'name')
                    ->required(),

                Hidden::make('user_id')
                    ->default(Auth::id()),

                DateTimePicker::make('surgery_date')
                    ->required(),

                TextInput::make('notes'),
            ]);
    }
    public function created($record)
    {
        $medicalRecord = $record->medicalRecord;

        $user = $medicalRecord->animal->user;
        if ($user) {
            $user->notify(new MedicalRecordUpdatedNotification($medicalRecord));
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('notes')
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

                TextColumn::make('surgery_date')
                    ->label('Surgery Date')
                    ->searchable(),

                Tables\Columns\TextColumn::make('notes'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->after(function ($record) {
                    $medicalRecord = $record->medicalRecord;
                    $user = $medicalRecord->animal->user;
                    if ($user) {
                        $user->notify(new MedicalRecordUpdatedNotification($medicalRecord));
                    }
                    return;
                }),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
