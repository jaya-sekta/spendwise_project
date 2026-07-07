<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reward;

class RewardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Reward::insert([
            [
                'reward_name' => 'Voucher Gopay Rp20.000',
                'required_points' => 100,
                'stock' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reward_name' => 'Voucher Shopee Rp50.000',
                'required_points' => 250,
                'stock' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reward_name' => 'Voucher Steam Rp100.000',
                'required_points' => 500,
                'stock' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reward_name' => 'Mouse Logitech',
                'required_points' => 750,
                'stock' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'reward_name' => 'Mechanical Keyboard',
                'required_points' => 1500,
                'stock' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}