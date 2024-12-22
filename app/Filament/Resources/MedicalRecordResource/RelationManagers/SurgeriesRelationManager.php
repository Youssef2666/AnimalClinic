<?php

namespace App\Filament\Resources\MedicalRecordResource\RelationManagers;

use App\Notifications\MedicalRecordUpdatedNotification;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class SurgeriesRelationManager extends RelationManager
{
    protected static string $relationship = 'surgeries';
    protected static ?string $modelLabel = 'عملية';
    protected static ?string $title = 'العمليات';
    protected static ?string $pluralModelLabel = 'العمليات';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('surgery_category_id')
                    ->relationship('surgeryCategory', 'name')
                    ->label('اسم العملية')
                    ->required(),

                Hidden::make('user_id')
                    ->default(Auth::id()),

                DateTimePicker::make('surgery_date')
                    ->label('تاريخ العملية')
                    ->afterOrEqual(now())
                    ->default(now())
                    ->required(),

                TextInput::make('notes')
                    ->label('ملاحظات'),
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
                TextColumn::make('id')
                    ->label('رقم العملية'),
                TextColumn::make('surgeryCategory.name')
                    ->label('اسم العملية')
                    ->searchable(),
                TextColumn::make('medicalRecord.id')
                    ->label('رقم السجل الصحي')
                    ->searchable(),

                TextColumn::make('surgeryCategory.cost')
                    ->label('سعر العملية')
                    ->searchable(),

                TextColumn::make('surgery_date')
                    ->label('تاريخ العملية')
                    ->searchable(),

                TextColumn::make('surgery_date')
                    ->label('تاريخ العملية')
                    ->searchable(),

                Tables\Columns\TextColumn::make('notes')
                    ->label('ملاحظات'),
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
