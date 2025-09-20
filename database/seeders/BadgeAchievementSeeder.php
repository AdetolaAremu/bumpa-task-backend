<?php

namespace Database\Seeders;

use App\Models\Achievement;
use App\Models\Badge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BadgeAchievementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Achievement::insert([
            [
                'id' => 1,
                'name' => 'First Purchase',
                'condition_type' => 'purchases_count',
                'condition_value' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => '5 Purchases',
                'condition_type' => 'purchases_count',
                'condition_value' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Spent 10k Total',
                'condition_type' => 'total_spent',
                'condition_value' => 10000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        Badge::insert([
            [
                'id' => 1,
                'name' => 'Bronze',
                'required_achievements' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Silver',
                'required_achievements' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'Gold',
                'required_achievements' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
