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
                'name' => 'اكل كلاب',
                'description' => 'الغذاء لكلابك.',
            ],
            [
                'name' => 'اكل قطط',
                'description' => 'أكل لقططك',
            ],
            [
                'name' => 'اكل طيور',
                'description' => 'اكل طيور.',
            ],
            [
                'name' => 'اكل سمك',
                'description' => 'اكل سمك.',
            ],
            [
                'name' => 'مستلزمات الطبية',
                'description' => 'أدوية لحيواناتك الأليفة.',
            ]
        ];
        foreach ($product_category as $category) {
            ProductCategory::create($category);
        }
    }
}
