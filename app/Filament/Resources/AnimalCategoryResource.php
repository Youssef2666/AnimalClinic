<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnimalCategoryResource\Pages;
use App\Filament\Resources\AnimalCategoryResource\RelationManagers;
use App\Models\AnimalCategory;
use Faker\Provider\ar_EG\Text;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnimalCategoryResource extends Resource
{
    protected static ?string $model = AnimalCategory::class;
    protected static ?string $modelLabel =  'صنف حيوان';
    protected static ?string $pluralModelLabel = 'أصناف الحيوانات';
    protected static ?string $navigationGroup = 'الأصناف';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            'index' => Pages\ListAnimalCategories::route('/'),
            'create' => Pages\CreateAnimalCategory::route('/create'),
            'edit' => Pages\EditAnimalCategory::route('/{record}/edit'),
        ];
    }
}
