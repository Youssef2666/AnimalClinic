<?php

namespace App\Filament\Resources\DoctorResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Filament\Resources\DoctorResource;
use App\Models\Doctor;
use Filament\Resources\Pages\CreateRecord;

class CreateDoctor extends CreateRecord
{
    protected static string $resource = DoctorResource::class;

    protected function handleRecordCreation(array $data): Doctor
    {
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
            'gender' => $data['gender'],
        ]);
    }
}