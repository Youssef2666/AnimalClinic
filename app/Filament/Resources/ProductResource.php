<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Faker\Provider\ar_EG\Text;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\OrderResource\Widgets\OrderOverview;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $modelLabel =  'منتج';
    protected static ?string $pluralModelLabel = 'منتجات';

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
                ->label('اسم المنتج')
                ->required(),
                
                TextInput::make('price')
                ->label('سعر المنتج')
                ->required(),
                Select::make('product_category_id')
                ->relationship('category', 'name')
                ->required()
                ->label('فئة المنتج'),
                TextInput::make('description')
                ->label('وصف'),
                TextInput::make('stock')
                ->label('الكمية'),
                FileUpload::make('image')
                ->label('صورة المنتج')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label('اسم المنتج')
                ->searchable(),
                TextColumn::make('price')
                ->label('سعر المنتج')
                ->searchable(),
                TextColumn::make('category.name')
                ->label('فئة المنتج')
                ->searchable(),
                TextColumn::make('stock')
                ->label('الكمية'),
                ImageColumn::make('image')
                ->label('صورة المنتج'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
