<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        User::factory()->create([
            'name' => 'يوسف',
            'email' => 'youssefalmerash76@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'admin'
        ]);
        $this->call([
            AnimalCategorySeeder::class,
            SurgeryCategorySeeder::class,
            MedicineCategorySeeder::class,
            VaccinationCategorySeeder::class,
            // MedicineSeeder::class,
            // SurgerySeeder::class,
            // VaccinationSeeder::class,
            ProductCategorySeeder::class,
            PaymentMethodSeeder::class
        ]);
    }
}