<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Actions\Action;
use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('activate')
                    ->label('Activate')
                    ->icon('heroicon-s-check-circle')
                    ->action(function (User $record) {
                        $record->update(['status' => User::STATUS['Active']]);
                    })
                    ->visible(fn (User $record) => $record->status === User::STATUS['InActive']),
                
                    Action::make('deactivate')
                    ->label('Deactivate')
                    ->icon('heroicon-s-x-circle')
                    ->action(function (User $record) {
                        $status =  User::STATUS['InActive'];
                        $record->update(['status' => $status]);
                    })
                    ->visible(fn (User $record) => $record->status === User::STATUS['Active'])
                    ->sendSuccessNotification(),
        ];
    }
}