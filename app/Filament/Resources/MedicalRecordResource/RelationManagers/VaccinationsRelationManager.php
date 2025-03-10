<?php

namespace App\Filament\Resources\MedicalRecordResource\RelationManagers;

use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use App\Notifications\MedicalRecordUpdatedNotification;
use Filament\Resources\RelationManagers\RelationManager;

class VaccinationsRelationManager extends RelationManager
{
    protected static string $relationship = 'vaccinations';
    protected static ?string $modelLabel = 'تطعيم';
    protected static ?string $title = 'التطعيمات';
    protected static ?string $pluralModelLabel = 'التطعيمات';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('vaccination_category_id')
                    ->relationship('vaccinationCategory', 'name')
                    ->label('اسم التطعيم')
                    ->required(),

                Hidden::make('user_id')
                    ->default(Auth::id()),

                DateTimePicker::make('vaccination_date')
                ->label('تاريخ التطعيم')
                ->afterOrEqual(now())
                ->default(now())
                    ->required(),

                TextInput::make('notes')
                    ->label('ملاحظات'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('notes')
            ->columns([
                TextColumn::make('vaccinationCategory.name')
                    ->label('اسم التطعيم')
                    ->searchable(),

                TextColumn::make('vaccinationCategory.cost')
                    ->label('التكلفة')
                    ->searchable(),

                TextColumn::make('medicalRecord.id')
                    ->label('رقم السجل الصحي')
                    ->searchable(),

                TextColumn::make('vaccination_date')
                    ->label('تاريخ التطعيم')
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
