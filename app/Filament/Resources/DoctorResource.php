<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Tables;
use App\Models\Doctor;
use Filament\Forms\Form;
use App\Enums\DaysStatus;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use App\Enums\DoctorSpecializationStatus;
use App\Filament\Widgets\AnimalsOverview;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\CheckboxList;
use App\Filament\Resources\DoctorResource\Pages;

class DoctorResource extends Resource
{
    protected static ?string $model = Doctor::class;
    protected static ?string $modelLabel = 'طبيب';
    protected static ?string $pluralModelLabel = 'الأطباء';

    protected function getHeaderWidgets(): array
    {
        return [
            AnimalsOverview::class
        ];
    }

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
                            // ->visible(fn($livewire) => $livewire instanceof \App\Filament\Resources\DoctorResource\Pages\CreateDoctor)
                            ->columnSpan(2),

                        TextInput::make('user.email')
                            ->label('البريد الالكتروني')
                            ->required()
                            ->email()
                            ->columnSpan(2)
                            ->unique(
                                table: User::class,
                                column: 'email',
                            ),
                            // ->visible(fn($livewire) => $livewire instanceof \App\Filament\Resources\DoctorResource\Pages\CreateDoctor), // Apply unique only when creating

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
                            ->image()
                            ->imageEditor(),
                            CheckboxList::make('work_days')
                            ->label('Work Days')
                            ->options(array_column(DaysStatus::cases(), 'name', 'value'))
                            ->afterStateHydrated(function (CheckboxList $component, $state, $record) {
                                if ($record && $record->workDays) {
                                    $component->state(
                                        $record->workDays->pluck('day')->toArray()
                                    );
                                }
                            })
                            ->dehydrateStateUsing(fn ($state) => collect($state)->filter()->values()->all())
                            ->saveRelationshipsUsing(function ($state, $record) {
                                $record->workDays()->delete();
                                foreach ($state as $day) {
                                    $record->workDays()->create([
                                        'doctor_id' => $record->id,
                                        'day' => $day,               
                                    ]);
                                }
                            }),                        
                    ])
                    ->columns(2),
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
    public function edit($record): void
    {
        $record->load('user');

        parent::edit($record);
    }

}
