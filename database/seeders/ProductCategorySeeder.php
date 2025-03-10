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
                'name' => 'منتجات الكلاب',
                'description' => 'الغذاء لكلابك.',
            ],
            [
                'name' => 'منتجات القطط',
                'description' => 'أكل لقططك',
            ],
            [
                'name' => 'منتجات الطيور',
                'description' => 'اكل طيور.',
            ],
            [
                'name' => 'منتجات الأسماك',
                'description' => 'اكل سمك.',
            ],
            [
                'name' => 'غير ذلك',
                'description' => '',
            ]
        ];
        foreach ($product_category as $category) {
            ProductCategory::create($category);
        }
    }
}
