<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MedicineCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MedicineCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = [
            [
                'name' => 'Antibiotics',
                'description' => 'Medicines that fight infections.',
                'cost' => 100.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Antihistamine',
                'description' => 'Medicines that fight allergic reactions.',
                'cost' => 200.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Analgesics',
                'description' => 'Medicines that fight pain.',
                'cost' => 300.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        foreach ($medicines as $medicine) {
            MedicineCategory::create($medicine);
        }
    }
}
