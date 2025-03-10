<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SurgeryCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('surgery_categories')->insert([
            [
                'name' => 'Cardiac Surgery',
                'description' => 'Surgery related to heart conditions.',
                'cost' => 300.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Orthopedic Surgery',
                'description' => 'Surgery related to bones and joints.',
                'cost' => 350.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Neurosurgery',
                'description' => 'Surgery related to the nervous system.',
                'cost' => 400.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Plastic Surgery',
                'description' => 'Surgery related to reconstructive or cosmetic work.',
                'cost' => 500.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'General Surgery',
                'description' => 'Surgery that covers a wide range of conditions.',
                'cost' => 600.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
