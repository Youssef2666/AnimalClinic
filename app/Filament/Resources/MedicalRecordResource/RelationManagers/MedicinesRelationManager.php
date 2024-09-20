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
use Filament\Resources\RelationManagers\RelationManager;

class MedicinesRelationManager extends RelationManager
{
    protected static string $relationship = 'medicines';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('medicine_category_id')  
                ->relationship('category', 'name')  // Specify the relationship and display the 'name' field
                ->required()
                ->label('Medicine Category'),

                Hidden::make('user_id')
                ->default(Auth::id()) // Automatically set the value to the authenticated user
                ->required(),

                // Select::make('medical_record_id')  
                // ->relationship('medicalRecord', 'notes')  
                // ->required()
                // ->label('Medical Record'),

                TextInput::make('description')
            ]);
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
