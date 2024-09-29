<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product_category = [
            [
                'name' => 'Dogs Food',
                'description' => 'Food for your dogs.',
            ],
            [
                'name' => 'Cats Food',
                'description' => 'Medicines for your cats.',
            ],
            [
                'name' => 'Birds Food',
                'description' => 'Vaccines for your birds.',
            ],
            [
                'name' => 'Fish Food',
                'description' => 'Food for your fish.',
            ],
            [
                'name' => 'Medical Supplies',
                'description' => 'Medicines for your pets.',
            ]
        ];
        foreach ($product_category as $category) {
            ProductCategory::create($category);
        }
    }
}
