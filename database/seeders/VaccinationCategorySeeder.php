<?php

namespace Database\Seeders;

use App\Models\Vaccination;
use App\Models\VaccinationCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VaccinationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vaccinations = [
            [
                'name' => 'Pfizer-BioNTech',
                'description' => 'Vaccines for Covid-19.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Moderna',
                'description' => 'Vaccines for Covid-19.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'AstraZeneca',
                'description' => 'Vaccines for Covid-19.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sinovac',
                'description' => 'Vaccines for Covid-19.',
                'created_at' => now(),
                'updated_at' => now(),
        ]
            ];
        foreach ($vaccinations as $vaccination) {
            VaccinationCategory::create($vaccination);
        }
    }
}
