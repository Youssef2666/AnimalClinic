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
                'name' => 'كلب',
                'description' => 'whoff.',
            ],
            [
                'name' => 'قط',
                'description' => 'meow.',
            ],
            [
                'name' => 'طائر',
                'description' => 'tweet.',
            ]
        ];
    }
}
