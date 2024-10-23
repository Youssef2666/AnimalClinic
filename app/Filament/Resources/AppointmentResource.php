<?php

namespace App\Filament\Resources;

use App\Enums\AppointmentStatus;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

// use Filament\Forms\Components\TextInput;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    protected static ?string $modelLabel = 'موعد';
    protected static ?string $pluralModelLabel = 'المواعيد';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('animal_id') // Use 'animal_id' to reference the animal
                    ->relationship('animal', 'name') // Load 'name' from the Animal model
                    ->label('اسم الحيوان')
                    ->required(),

                Forms\Components\Select::make('status')
                    ->label('الحالة')
                    ->options(array_column(AppointmentStatus::cases(), 'name', 'value')),

                TextInput::make('interview')
                    ->label('نوع المقابلة')
                    ->required(),

                TextInput::make('date')
                    ->label('تاريخ المقابلة')
                    ->required(),

                // Forms\Components\Select::make('zoomAppointment.meeting_id')
                //     ->relationship('zoomAppointment', 'meeting_id')
                //     ->label('رقم الجلسة')
                //     ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        //     ->query(function (Builder $query) {
        //     return $query->where('user_id', fn () => Auth::id());
        // })
            ->columns([
                TextColumn::make('id')->sortable()->searchable()->label('رقم الموعد'),
                TextColumn::make('status')->label('الحالة')->badge()->color(function ($state) {
                    return match ($state) {
                        AppointmentStatus::CONFIRMED->value => 'success',
                        AppointmentStatus::CANCELED->value => 'danger',
                        default => 'secondary',
                    };
                }),
                TextColumn::make('interview')->label('نوع المقابلة'),
                TextColumn::make('date')->label('تاريخ المقابلة'),
                TextColumn::make('animal.name')->label('اسم الحيوان'),
                TextColumn::make('zoomAppointment.meeting_id')->label('رقم الجلسة'),
            ])
            ->filters([
                Tables\Filters\Filter::make('User Appointments'), // Define a custom filter
                // ->query(function (Builder $query) {
                //     // Automatically filter based on the authenticated user
                //     return $query->where('user_id', Auth::id());
                // })
                // ->default(true)
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
