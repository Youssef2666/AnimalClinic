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
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Notifications\MedicalRecordUpdatedNotification;
use Filament\Resources\RelationManagers\RelationManager;

class MedicinesRelationManager extends RelationManager
{
    protected static string $relationship = 'medicines';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('medicine_category_id')  
                ->relationship('category', 'name') 
                ->required()
                ->label('Medicine Category'),

                Hidden::make('user_id')
                ->default(Auth::id())
                ->required(),

                // Select::make('medical_record_id')  
                // ->relationship('medicalRecord', 'notes')  
                // ->required()
                // ->label('Medical Record'),

                TextInput::make('description')
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
            ->recordTitleAttribute('description')
            ->columns([
                TextColumn::make('category.name')
                ->label('Medicine Name')
                ->searchable(),

                TextColumn::make('medicalRecord.id')
                ->label('Medical Record ID')
                ->searchable(),
                TextColumn::make('medicalRecord.notes')
                ->label('Medical Record Notes')
                ->searchable()
                ->toggleable(),

                TextColumn::make('description')
                ->searchable(),
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
