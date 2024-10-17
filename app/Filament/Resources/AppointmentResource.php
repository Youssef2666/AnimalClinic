<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\Appointment;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Filament\Resources\AppointmentResource\RelationManagers;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    protected static ?string $modelLabel =  'موعد';
    protected static ?string $pluralModelLabel = 'المواعيد';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        //     ->query(function (Builder $query) {
        //     return $query->where('user_id', fn () => Auth::id());
        // })
            ->columns([
                TextColumn::make('id')->sortable()->searchable()->label('رقم الموعد'),
                TextColumn::make('status')->label('الحالة'),
                TextColumn::make('interview')->label('نوع المقابلة'),
                TextColumn::make('date')->label('تاريخ المقابلة'),
                TextColumn::make('animal.name')->label('اسم الحيوان'),
            ])
            ->filters([
                Tables\Filters\Filter::make('User Appointments')  // Define a custom filter
                    // ->query(function (Builder $query) {
                    //     // Automatically filter based on the authenticated user
                    //     return $query->where('user_id', Auth::id());
                    // })
                    // ->default(true)
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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
