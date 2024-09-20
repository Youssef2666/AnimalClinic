<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Youssef',
            'email' => 'youssef@gmail.com',
            'password' => '12345678',
        ]);
        $this->call([
            SurgeryCategorySeeder::class,
            MedicineCategorySeeder::class,
            VaccinationCategorySeeder::class,
            MedicineSeeder::class,
            SurgerySeeder::class,
            VaccinationSeeder::class
        ]);
    }
}