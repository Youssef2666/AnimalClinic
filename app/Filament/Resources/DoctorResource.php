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
    protected static ?string $modelLabel =  'طبيب';
    protected static ?string $pluralModelLabel = 'الأطباء';

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Doctor Information')
                    ->schema([
                        TextInput::make('user.name')
                            ->label('اسم الطبيب')
                            ->required()
                            ->unique(table: User::class, column: 'name')
                            ->columnSpan(2),

                        TextInput::make('user.email')
                            ->label('البريد الالكتروني')
                            ->email()
                            ->unique(table: User::class, column: 'email', ignoreRecord: true)
                            ->required()
                            ->columnSpan(2),

                        TextInput::make('user.password')
                            ->label('كلمة المرور')
                            ->password()
                            ->required()
                            ->confirmed()
                            ->columnSpan(2),

                        TextInput::make('user.password_confirmation')
                            ->label('تأكيد كلمة المرور')
                            ->password()
                            ->required()
                            ->columnSpan(2),

                        // Other user-related fields...
                    ])
                    ->columns(2),
                Section::make('Doctor Extra Information')
                    ->schema([
                        Select::make('specialization')
                            ->label('التخصص')
                            ->options(array_column(DoctorSpecializationStatus::cases(), 'name', 'value'))
                            ->enum(DoctorSpecializationStatus::class)
                            ->required(),

                        TextInput::make('cost')
                            ->label('سعر الساعة')
                            ->numeric()
                            ->required(),

                        TimePicker::make('work_start_time')
                            ->label('تاريخ بدء العمل')
                            ->seconds(false)
                            ->required(),

                        TimePicker::make('work_end_time')
                            ->label('تاريخ نهاية العمل')
                            ->seconds(false)
                            ->required()
                            ->after('work_start_time'),

                        FileUpload::make('image')
                        ->label('صورة الطبيب')
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
                    ->label('اسم الطبيب'),
                TextColumn::make('specialization')->label('التخصص'),
                ImageColumn::make('image')->label('صورة الطبيب'),
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
