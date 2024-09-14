<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Doctor;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Enums\GenderStatus;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\DoctorResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DoctorResource\RelationManagers;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Doctor Information')
                ->schema([
                    TextInput::make('user.name')
                        ->label('Doctor Name')
                        ->required()
                        ->columnSpan(2),

                    TextInput::make('user.email')
                        ->label('Doctor Email')
                        ->email()
                        ->required()
                        ->columnSpan(2),

                    TextInput::make('user.password')
                        ->label('Password')
                        ->password()
                        ->required()
                        ->columnSpan(2),

                    // Other user-related fields...
                ])
                ->columns(2),
                Section::make('Doctor Extra Information')
                ->schema([
                    TextInput::make('specialization')
                        ->label('Specialization')
                        ->required(),

                    TimePicker::make('work_start_time')
                        ->label('Work Start Time')
                        ->seconds(false)
                        ->required(),

                    TimePicker::make('work_end_time')
                        ->label('Work End Time')
                        ->seconds(false)
                        ->required(),

                    Select::make('gender')
                        ->label('Gender')
                        ->options(array_column(GenderStatus::cases(), 'name', 'value'))
                        ->required(),
                ])
                ->columns(2),
                // Select::make('user_id')
                // ->label('Doctor')
                // ->options(function () {
                //     return User::doctor()->pluck('name', 'id')->toArray();
                // })
                // ->required()
                // ->searchable(),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                ->label('Doctor Name'),
                TextColumn::make('specialization'),
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
            'index' => Pages\ListDoctors::route('/'),
            'create' => Pages\CreateDoctor::route('/create'),
            'edit' => Pages\EditDoctor::route('/{record}/edit'),
        ];
    }


}