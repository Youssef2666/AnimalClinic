<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ZoomMeetingResource\Pages;
use App\Models\ZoomMeeting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ZoomMeetingResource extends Resource
{
    protected static ?string $model = ZoomMeeting::class;
    protected static ?string $modelLabel =  'جلسة زوم';
    protected static ?string $pluralModelLabel = 'جلسات زوم';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('appointment_id')
                    ->label('الموعد')
                    ->relationship('appointment', 'id')
                    ->required(),
                Forms\Components\TextInput::make('meeting_id')
                    ->label('رقم الجلسة')
                    ->required()
                    ->unique(ZoomMeeting::class, 'meeting_id', ignoreRecord: true),
                Forms\Components\TextInput::make('topic')
                    ->label('عنوان الجلسة')
                    ->required(),
                Forms\Components\TextInput::make('start_url')
                    ->label('رابط الجلسة')
                    ->required(),
                Forms\Components\TextInput::make('join_url')
                    ->label('رابط الانضمام')
                    ->required(),
                Forms\Components\DateTimePicker::make('start_time')
                    ->label('وقت البدء')
                    ->required(),
                Forms\Components\TextInput::make('duration')
                    ->label('مدة الجلسة (بالدقائق)')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('timezone')
                    ->label('المنطقة الزمنية')
                    ->nullable(),
                Forms\Components\TextInput::make('password')
                    ->label('كلمة المرور')
                    ->nullable(),
                Forms\Components\Textarea::make('agenda')
                    ->label('جدول الأعمال')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('meeting_id')->label('رقم الجلسة')->sortable()->searchable(),
                TextColumn::make('animal.name')->label('اسم الحيوان') ->sortable() ->searchable(), 
                TextColumn::make('topic')->label('عنوان الجلسة')->sortable()->searchable(),
                TextColumn::make('password')->label('كلمة المرور')->sortable()->searchable(),
                TextColumn::make('start_time')->label('وقت البدء')->sortable()->dateTime('H:i d-m-Y'),
                TextColumn::make('duration')->label('مدة الجلسة')->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('startMeeting')
                    ->label('بدء الجلسة')
                    ->icon('heroicon-o-play')
                    ->url(fn($record) => $record->start_url)
                    ->openUrlInNewTab()
                    ->color('success'),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ])->defaultSort('start_time', 'asc');
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
            'index' => Pages\ListZoomMeetings::route('/'),
            'create' => Pages\CreateZoomMeeting::route('/create'),
            'edit' => Pages\EditZoomMeeting::route('/{record}/edit'),
        ];
    }
}
