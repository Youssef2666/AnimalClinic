<?php

namespace App\Filament\Resources;

use App\Enums\AppointmentStatus;
use App\Filament\Resources\AppointmentResource\Pages;
use App\Models\Appointment;
use App\Notifications\AppointmentStatusNotification;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;
    protected static ?string $modelLabel = 'موعد';
    protected static ?string $pluralModelLabel = 'المواعيد';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('animal_id')
                    ->relationship('animal', 'name')
                    ->label('اسم الحيوان')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->label('الحالة')
                    ->options(array_column(AppointmentStatus::cases(), 'name', 'value')),
                TextInput::make('interview')
                    ->label('نوع المقابلة')
                    ->required(),
                TextInput::make('date')
                    ->label('تاريخ المقابلة')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable()->searchable()->label('رقم الموعد'),
                TextColumn::make('status')->label('الحالة')->badge()->color(function ($state) {
                    return match ($state) {
                        AppointmentStatus::CONFIRMED->value => 'success',
                        AppointmentStatus::CANCELED->value => 'danger',
                        default => 'secondary',
                    };
                }),
                TextColumn::make('interview')->label('نوع المقابلة'),
                TextColumn::make('date')->label('تاريخ المقابلة'),
                TextColumn::make('time')->label('وقت المقابلة'),
                TextColumn::make('animal.name')->label('اسم الحيوان'),
                TextColumn::make('zoomAppointment.meeting_id')->label('رقم الجلسة'),
            ])
            ->filters([
                Tables\Filters\Filter::make('User Appointments'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('changeStatus')
                    ->label('تغيير الحالة')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->options(collect(AppointmentStatus::cases())->mapWithKeys(fn($status) => [$status->value => $status->label()])->toArray())
                            ->label('الحالة الجديدة')
                            ->required(),
                    ])
                    ->action(function (Model $record, array $data) {
                        $record->status = $data['status'];
                        $record->save();

                        $title = "حالة موعدك تم تغييرها";
                        if($data['status'] == AppointmentStatus::CONFIRMED->value){
                            $body = "لقد تم تأكيد موعدك بنجاح.";
                        } else if($data['status'] == AppointmentStatus::CANCELED->value){
                            $body = "لقد تم إلغاء موعدك.";
                        }else if ($data['status'] == AppointmentStatus::COMPLETED->value){
                            $body = "لقد تم إكمال موعدك بنجاح.";
                        }
                        $notificationData = [
                            'appointment_id' => $record->id,
                            'status' => $data['status'],
                        ];

                        $fcmToken = Auth::user()->fcm_token ?? null;
                        $access_token = Auth::user()->access_token ?? null;
                        $data['animal_name'] = $record->animal->name;
                        $record->animal->user->notify(new AppointmentStatusNotification($title, $body, $notificationData, $fcmToken, $access_token, animal_name: $record->animal->name, status: $data['status'], doctor_name: Auth::user()->name));
                        if ($record->animal->user) {
                        } else {
                            Log::error('User not found for animal ID: ' . $record->animal->id);
                        }
                    }),

                // ->visible(fn(Model $record) => $record->status !== AppointmentStatus::CONFIRMED->value),

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
            'index' => Pages\ListAppointments::route('/'),
            'create' => Pages\CreateAppointment::route('/create'),
            'edit' => Pages\EditAppointment::route('/{record}/edit'),
        ];
    }
}
