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
                'cost' => 100.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Moderna',
                'description' => 'Vaccines for Covid-19 Ultra.',
                'cost' => 200.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'AstraZeneca',
                'description' => 'Vaccines for Covid-19 Plus.',
                'cost' => 130.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sinovac',
                'description' => 'Vaccines for Covid-20.',
                'cost' => 150.00,
                'created_at' => now(),
                'updated_at' => now(),
        ]
            ];
        foreach ($vaccinations as $vaccination) {
            VaccinationCategory::create($vaccination);
        }
    }
}
