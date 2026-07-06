<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Primer (kebutuhan pokok)
            ['category_name' => 'Makan & Minum',      'monthly_limit' => 800000, 'category_type' => 'primary'],
            ['category_name' => 'Transportasi',       'monthly_limit' => 400000, 'category_type' => 'primary'],
            ['category_name' => 'Kos / Sewa',         'monthly_limit' => 1000000, 'category_type' => 'primary'],
            ['category_name' => 'Tagihan Listrik',    'monthly_limit' => 200000, 'category_type' => 'primary'],
            ['category_name' => 'Kesehatan',          'monthly_limit' => 150000, 'category_type' => 'primary'],
            ['category_name' => 'Pendidikan',         'monthly_limit' => 300000, 'category_type' => 'primary'],

            // Konsumtif (gaya hidup)
            ['category_name' => 'Belanja',            'monthly_limit' => 300000, 'category_type' => 'consumptive'],
            ['category_name' => 'Hiburan & Game',     'monthly_limit' => 200000, 'category_type' => 'consumptive'],
            ['category_name' => 'Kopi & Jajan',       'monthly_limit' => 150000, 'category_type' => 'consumptive'],
            ['category_name' => 'Pakaian',            'monthly_limit' => 250000, 'category_type' => 'consumptive'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                [
                    'category_name' => $category['category_name'],
                    'is_default'    => true,
                ],
                [
                    'user_id'       => null,
                    'monthly_limit' => $category['monthly_limit'],
                    'category_type' => $category['category_type'],
                ]
            );
        }
    }
}