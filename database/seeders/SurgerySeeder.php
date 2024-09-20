<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'cost' => 100.0,
            ],
            [
                'surgery_category_id' => 2,
                'user_id' => 1,
                'medical_record_id' => 3,
                'surgery_date' => '2024-02-01',
                'notes' => 'Surgery related to bone fracture.',
                'cost' => 200.0,
            ],
            [
                'surgery_category_id' => 3,
                'user_id' => 1,
                'medical_record_id' => 4,
                'surgery_date' => '2024-03-01',
                'notes' => 'Surgery related to brain damage.',
                'cost' => 300.0,
            ]
        ];
    }
}
