<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Lenny',
            'last_name' => 'rocky',
            'email' => 'lenny.rocky@mail.com',
            'password' => bcrypt('password12')
        ]);
    }
}
