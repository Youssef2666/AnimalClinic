<?php

namespace App\Filament\Resources;

use App\Enums\DoctorSpecializationStatus;
use App\Filament\Resources\DoctorResource\Pages;
use App\Models\Doctor;
use App\Models\User;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

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
                            ->unique(table: User::class, column: 'name')
                            ->columnSpan(2),

                        TextInput::make('user.email')
                            ->label('Doctor Email')
                            ->email()
                            ->unique(table: User::class, column: 'email')
                            ->required()
                            ->columnSpan(2),

                        TextInput::make('user.password')
                            ->label('Password')
                            ->password()
                            ->required()
                            ->confirmed()
                            ->columnSpan(2),

                        TextInput::make('user.password_confirmation')
                            ->label('Confirm Password')
                            ->password()
                            ->required()
                            ->columnSpan(2),

                        // Other user-related fields...
                    ])
                    ->columns(2),
                Section::make('Doctor Extra Information')
                    ->schema([
                        Select::make('specialization')
                            ->label('Specialization')
                            ->options(array_column(DoctorSpecializationStatus::cases(), 'name', 'value'))
                            ->enum(DoctorSpecializationStatus::class)
                            ->required(),

                        TextInput::make('cost')
                            ->label('Hour Cost')
                            ->numeric()
                            ->required(),

                        TimePicker::make('work_start_time')
                            ->label('Work Start Time')
                            ->seconds(false)
                            ->required(),

                        TimePicker::make('work_end_time')
                            ->label('Work End Time')
                            ->seconds(false)
                            ->required()
                            ->after('work_start_time'),

                        FileUpload::make('image')
                        ->label('Doctor Image')
                        ->image(),

                        // Select::make('gender')
                        //     ->label('Gender')
                        //     ->options(array_column(GenderStatus::cases(), 'name', 'value'))
                        //     ->required(),
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
                ImageColumn::make('image'),
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
