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
    protected static ?string $modelLabel =  'دواء';
    protected static ?string $title = 'الأدوية';
    protected static ?string $pluralModelLabel = 'أدوية';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('medicine_category_id')  
                ->relationship('category', 'name') 
                ->required()
                ->label('اسم الدواء'),

                Hidden::make('user_id')
                ->default(Auth::id())
                ->required(),

                // Select::make('medical_record_id')  
                // ->relationship('medicalRecord', 'notes')  
                // ->required()
                // ->label('Medical Record'),

                TextInput::make('description')
                ->label('وصف'),
            ]);
    }
    public function created($record)
    {
        $medicalRecord = $record->medicalRecord;

        $user = $medicalRecord->animal->user;
        if ($user) {
            $user->notify(new MedicalRecordUpdatedNotification($medicalRecord, doctor_name: Auth::user()->name));
        }
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('description')
            ->columns([
                TextColumn::make('id')
                ->label('رقم الدواء')
                ->searchable(),
                TextColumn::make('category.name')
                ->label('اسم الدواء')
                ->searchable(),

                TextColumn::make('medicalRecord.id')
                ->label('رقم السجل الصحي')
                ->searchable(),
                TextColumn::make('created_at')
                ->label('تاريخ الانشاء')
                ->dateTime('H:i d-m-Y'),
                
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
            ->headerActions([
                Tables\Actions\CreateAction::make()
                ->after(function ($record) {
                    $medicalRecord = $record->medicalRecord;
                    $user = $medicalRecord->animal->user;
                    $doctor_name = Auth::user()->name;

                    if ($user) {
                        $user->notify(new MedicalRecordUpdatedNotification($medicalRecord, $doctor_name));
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
