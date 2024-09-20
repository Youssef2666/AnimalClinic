<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = [
            [
                'user_id' => 1,
                'medical_record_id' => 1,
                'medicine_category_id' => 1,
                'description' => 'Aspirin',
            ],
            [
                'user_id' => 1,
                'medical_record_id' => 1,
                'medicine_category_id' => 2,
                'description' => 'Vitamins',
            ]
        ];
    }
}
