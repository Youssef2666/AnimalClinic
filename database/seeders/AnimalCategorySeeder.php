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
                'name' => 'Dog',
                'description' => 'whoff.',
            ],
            [
                'name' => 'Cat',
                'description' => 'meow.',
            ],
            [
                'name' => 'Bird',
                'description' => 'tweet.',
            ]
        ];
    }
}
