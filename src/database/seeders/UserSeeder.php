<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'              => 'テストユーザー1',
            'email'             => 'test1@example.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
            'postal_code'       => '123-4567',
            'address'           => '東京都渋谷区渋谷1-1-1',
            'building'          => 'テストビル101',
        ]);

        User::create([
            'name'              => 'テストユーザー2',
            'email'             => 'test2@example.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
            'postal_code'       => '234-5678',
            'address'           => '大阪府大阪市北区梅田2-2-2',
            'building'          => '',
        ]);
    }
}
