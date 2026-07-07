<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Challenge;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Menjalankan seeder.
     */
    public function run(): void
    {
        $profiles = [
            [
                'user' => [
                    'name'     => 'Budi Santoso',
                    'email'    => 'budi@example.com',
                    'password' => 'password',
                    'points'   => 150,
                ],
                'category' => [
                    'category_name' => 'Makan & Minum',
                    'category_type' => 'primary',
                    'monthly_limit' => 1000000,
                    'is_default'    => false,
                ],
                'expenses' => [
                    [
                        'expense_name'  => 'Makan Siang Nasi Padang',
                        'amount'        => 35000,
                        'expense_date'  => Carbon::now()->subDays(3),
                        'is_over_limit' => false,
                    ],
                    [
                        'expense_name'  => 'Es Teh Manis',
                        'amount'        => 8000,
                        'expense_date'  => Carbon::now()->subDay(),
                        'is_over_limit' => false,
                    ],
                ],
                'challenge' => [
                    'start_date'      => Carbon::now()->subDays(5),
                    'end_date'        => Carbon::now()->addDays(25),
                    'remaining_lives' => 3,
                    'status'          => 'active',
                ],
            ],
            [
                'user' => [
                    'name'     => 'Siti Aminah',
                    'email'    => 'siti@example.com',
                    'password' => 'password',
                    'points'   => 420,
                ],
                'category' => [
                    'category_name' => 'Hiburan & Game',
                    'category_type' => 'consumptive',
                    'monthly_limit' => 500000,
                    'is_default'    => false,
                ],
                'expenses' => [
                    [
                        'expense_name'  => 'Top Up Mobile Legend',
                        'amount'        => 150000,
                        'expense_date'  => Carbon::now()->subDays(2),
                        'is_over_limit' => true,
                    ],
                ],
                'challenge' => [
                    'start_date'      => Carbon::now()->subDays(10),
                    'end_date'        => Carbon::now()->addDays(20),
                    'remaining_lives' => 1,
                    'status'          => 'active',
                ],
            ],
            [
                'user' => [
                    'name'     => 'Andi Wijaya',
                    'email'    => 'andi@example.com',
                    'password' => 'password',
                    'points'   => 780,
                ],
                'category' => [
                    'category_name' => 'Transportasi',
                    'category_type' => 'primary',
                    'monthly_limit' => 300000,
                    'is_default'    => false,
                ],
                'expenses' => [
                    [
                        'expense_name'  => 'Bensin Motor',
                        'amount'        => 50000,
                        'expense_date'  => Carbon::now()->subDays(15),
                        'is_over_limit' => false,
                    ],
                    [
                        'expense_name'  => 'Ojek Online',
                        'amount'        => 25000,
                        'expense_date'  => Carbon::now()->subDays(8),
                        'is_over_limit' => false,
                    ],
                ],
                'challenge' => [
                    'start_date'      => Carbon::now()->subDays(30),
                    'end_date'        => Carbon::now()->subDay(),
                    'remaining_lives' => 0,
                    'status'          => 'successful',
                ],
            ],
        ];

        foreach ($profiles as $profile) {
            // 1. Buat atau ambil user berdasarkan email (supaya seeder aman dijalankan ulang)
            $user = User::updateOrCreate(
                ['email' => $profile['user']['email']],
                [
                    'name'     => $profile['user']['name'],
                    'password' => Hash::make($profile['user']['password']),
                    'points'   => $profile['user']['points'],
                ]
            );

            // Bersihkan data lama milik user ini supaya tidak menumpuk saat di-seed ulang
            Challenge::where('user_id', $user->id)->delete();
            Expense::where('user_id', $user->id)->delete();
            Category::where('user_id', $user->id)->delete();

            // 2. Buat kategori milik user tersebut
            $category = Category::create([
                'user_id'       => $user->id,
                'category_name' => $profile['category']['category_name'],
                'monthly_limit' => $profile['category']['monthly_limit'],
                'category_type' => $profile['category']['category_type'],
                'is_default'    => $profile['category']['is_default'],
            ]);

            // 3. Buat pengeluaran yang terhubung ke kategori & user tersebut
            foreach ($profile['expenses'] as $expense) {
                Expense::create([
                    'user_id'       => $user->id,
                    'category_id'   => $category->id,
                    'expense_name'  => $expense['expense_name'],
                    'amount'        => $expense['amount'],
                    'expense_date'  => $expense['expense_date'],
                    'is_over_limit' => $expense['is_over_limit'],
                ]);
            }

            // 4. Buat challenge yang menargetkan kategori tersebut
            Challenge::create([
                'user_id'         => $user->id,
                'category_id'     => $category->id,
                'start_date'      => $profile['challenge']['start_date'],
                'end_date'        => $profile['challenge']['end_date'],
                'remaining_lives' => $profile['challenge']['remaining_lives'],
                'status'          => $profile['challenge']['status'],
            ]);
        }
    }
}