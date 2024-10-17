<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Facades\Filament;
use Filament\Resources\Resource;
use Filament\Actions\DeleteAction;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UserResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UserResource\RelationManagers;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $modelLabel =  'مستخدم';
    protected static ?string $pluralModelLabel = 'المستخدمين';

    protected static ?string $navigationIcon = 'heroicon-o-user';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required()->sortable()->label('اسم المستخدم'),
                TextInput::make('email')->email()->required()->unique()->label('البريد الالكتروني'),
                TextInput::make('password')->password()->visibleOn('create')->label('كلمة المرور'),
                //the key will be saved in db and value will be shown in the select
                Select::make('role')->options([
                    'doctor' => 'Doctor',
                    'employee' => 'Employee',
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label('اسم المستخدم')
                ->searchable()
                ->sortable(),
                TextColumn::make('email')
                ->label('البريد الالكتروني')
                ->searchable(),
                TextColumn::make('role')->label('الدور')->searchable()->sortable(),
                TextColumn::make('status')->label('الحالة')->searchable()->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')->options([
                    'admin' => 'مدير',
                    'doctor' => 'طبيب',
                    'employee' => 'موظف',
                ])
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}