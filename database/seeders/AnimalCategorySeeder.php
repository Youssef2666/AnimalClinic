<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnimalCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $animals_category = [
            [
                'name' => 'القطط',
                'description' => 'whoff.',
            ],
            [
                'name' => 'الكلاب',
                'description' => 'meow.',
            ],
            [
                'name' => 'الطيور',
                'description' => 'tweet.',
            ],
            [
                'name' => 'الأسماك',
                'description' => 'bark.',
            ],
            [
                'name' => 'غير ذلك',
                'description' => '',
            ]
        ];

        foreach ($animals_category as $animal_category) {
            \App\Models\AnimalCategory::create($animal_category);
        }
    }
}
