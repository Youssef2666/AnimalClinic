<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payment_methods = [
            [
                'name' => 'الدفع عند الاستلام',
                'description' => 'الدفع عند الاستلام',
            ],
            [
                'name' => 'ادفع لي',
                'description' => 'من مصرف التجارة والتنمية',
            ],
            [
                'name' => 'سداد',
                'description' => 'من المدار الجديد',
            ],
            [
                'name' => 'البطاقة المصرفية المحلية',
                'description' => 'البطاقة المصرفية المحلية',
            ],
        ];

        foreach ($payment_methods as $payment_method) {
            \App\Models\PaymentMethod::create($payment_method);
        }
    }
}
