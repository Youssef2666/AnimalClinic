<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\AnimalCategory;
use Faker\Provider\ar_EG\Text;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\AnimalCategoryResource\Pages;
use App\Filament\Resources\AnimalCategoryResource\RelationManagers;

class AnimalCategoryResource extends Resource
{
    protected static ?string $model = AnimalCategory::class;
    protected static ?string $modelLabel =  'صنف حيوان';
    protected static ?string $pluralModelLabel = 'أصناف الحيوانات';
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
                ->unique(AnimalCategory::class, 'name', ignoreRecord: true)
                ->label('اسم الصنف')
                ->required(),

                Textarea::make('description')    
                ->label('وصف'),            
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('description'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListAnimalCategories::route('/'),
            'create' => Pages\CreateAnimalCategory::route('/create'),
            'edit' => Pages\EditAnimalCategory::route('/{record}/edit'),
        ];
    }
}
