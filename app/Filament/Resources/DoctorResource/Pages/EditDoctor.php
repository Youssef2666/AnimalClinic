<?php

namespace App\Filament\Resources\DoctorResource\Pages;

use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\DoctorResource;

class EditDoctor extends EditRecord
{
    protected static string $resource = DoctorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Get the related user data
        $user = User::find($this->record->user_id);

        // Populate the user fields in the form
        $data['user'] = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => '', // Leave password empty to avoid pre-filling it
        ];

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Update user-related data
        $user = User::find($this->record->user_id);
        $user->update([
            'name' => $data['user']['name'],
            'email' => $data['user']['email'],
            // Check if password needs to be updated
            'password' => !empty($data['user']['password']) ? bcrypt($data['user']['password']) : $user->password,
        ]);

        // We remove the user part of the data so it won't be saved as part of the DoctorExtraInfo
        unset($data['user']);

        return $data;
    }
}