<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\SurgeryCategory;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SurgeryCategoryResource\Pages;
use App\Filament\Resources\SurgeryCategoryResource\RelationManagers;

class SurgeryCategoryResource extends Resource
{
    protected static ?string $model = SurgeryCategory::class;
    protected static ?string $modelLabel =  'عملية';
    protected static ?string $pluralModelLabel = 'العمليات';

    protected static ?string $navigationGroup = 'الأصناف';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canAccess(): bool
    {
        return Auth::user()->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                ->required()
                ->unique(SurgeryCategory::class, 'name', ignoreRecord: true)
                ->label('اسم العملية'),

                TextInput::make('description')
                ->label('وصف'),

                TextInput::make('cost')
                ->required()
                ->numeric()
                ->label('سعر العملية'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                ->label('رقم العملية')
                ->searchable()
                ->sortable(),
                TextColumn::make('name')
                ->label('اسم العملية')
                ->searchable()
                ->sortable(),

                TextColumn::make('description')
                ->label('وصف')
                ->searchable()
                ->sortable(),

                TextColumn::make('cost')
                ->label('سعر العملية')
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListSurgeryCategories::route('/'),
            'create' => Pages\CreateSurgeryCategory::route('/create'),
            'edit' => Pages\EditSurgeryCategory::route('/{record}/edit'),
        ];
    }
}
