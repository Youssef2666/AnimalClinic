<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\MedicalRecord;
use Filament\Resources\Resource;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Auth;
use App\Filament\Resources\MedicalRecordResource\Pages;
use App\Filament\Resources\MedicalRecordResource\RelationManagers\MedicinesRelationManager;
use App\Filament\Resources\MedicalRecordResource\RelationManagers\SurgeriesRelationManager;
use App\Filament\Resources\MedicalRecordResource\RelationManagers\VaccinationsRelationManager;

class MedicalRecordResource extends Resource
{
    protected static ?string $model = MedicalRecord::class;
    protected static ?string $modelLabel =  'سجل صحي';
    protected static ?string $pluralModelLabel = 'سجلات صحية';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * Disable or enable the create action based on user role.
     */
    public static function canCreate(): bool
    {
        // Allow creation only for admin users
        return Auth::user()->isAdmin();  // Ensure 'role' field is present in the User model
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('notes')->label('ملاحظات'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->searchable()->sortable()->label('رقم السجل'),
                TextColumn::make('animal.name')->label('اسم الحيوان'),
                TextColumn::make('notes')->label('ملاحظات'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            MedicinesRelationManager::class,
            SurgeriesRelationManager::class,
            VaccinationsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMedicalRecords::route('/'),
            // 'create' => Pages\CreateMedicalRecord::route('/create'),
            'edit' => Pages\EditMedicalRecord::route('/{record}/edit'),
        ];
    }
}
