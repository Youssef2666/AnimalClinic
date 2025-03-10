<?php

namespace Database\Seeders;

use App\Models\Surgery;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SurgerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $surgeries = [
            [
                'surgery_category_id' => 1,
                'user_id' => 1,
                'medical_record_id' => 2,
                'surgery_date' => '2024-01-01',
                'notes' => 'Surgery related to heart conditions.',
            ],
            [
                'surgery_category_id' => 2,
                'user_id' => 1,
                'medical_record_id' => 3,
                'surgery_date' => '2024-02-01',
                'notes' => 'Surgery related to bone fracture.',
            ],
            [
                'surgery_category_id' => 3,
                'user_id' => 1,
                'medical_record_id' => 4,
                'surgery_date' => '2024-03-01',
                'notes' => 'Surgery related to brain damage.',
            ]
        ];

        foreach ($surgeries as $surgery) {
            Surgery::create($surgery);
        }
    }
}
