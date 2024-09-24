<?php

namespace App\Filament\Resources\DoctorResource\Pages;

use Exception;
use App\Models\User;
use Filament\Actions;
use App\Models\Doctor;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;
use App\Filament\Resources\DoctorResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDoctor extends CreateRecord
{
    protected static string $resource = DoctorResource::class;

protected function handleRecordCreation(array $data): Doctor
{
    try {
        // Save user-related data
        $user = User::create([
            'name' => $data['user']['name'],
            'email' => $data['user']['email'],
            'password' => bcrypt($data['user']['password']),
            'role' => 'doctor',
        ]);

        // Save doctor extra info data
        return Doctor::create([
            'user_id' => $user->id,
            'specialization' => $data['specialization'],
            'work_start_time' => $data['work_start_time'],
            'work_end_time' => $data['work_end_time'],
            'cost' => $data['cost'],
        ]);
    } catch (Exception $e) {
        // Log the error
        Log::error('Doctor creation failed: ' . $e->getMessage());

        // Display an error notification in Filament
        Notification::make()
            ->title('Doctor creation failed')
            ->body('Something went wrong while creating the doctor. Please try again.')
            ->danger()
            ->send();

        // Rethrow the exception to maintain the method return type
        throw new \Exception('Failed to create doctor');
    }
}

}