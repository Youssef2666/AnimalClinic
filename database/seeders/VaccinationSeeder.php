<?php

namespace Database\Seeders;

use App\Models\Vaccination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VaccinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vaccinations = [
            [
                'name' => 'BCG',
                'vaccination_category_id' => 1,
                'user_id' => 1,
                'medical_record_id' => 2,
                'vaccination_date' => '2024-01-01',
                'notes' => 'Vaccines for Covid-19.',
            ],
            [
                'name' => 'Hepatitis B',
                'vaccination_category_id' => 2,
                'user_id' => 2,
                'medical_record_id' => 1,
                'vaccination_date' => '2024-01-01',
                'notes' => 'Vaccines for Covid-19.',
            ]
        ];
    }
}
