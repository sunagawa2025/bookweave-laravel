<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // 開発用：管理者ユーザー
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => '管理者',
                'password' => Hash::make('password0716'),
                'role' => 'admin',
                'address' => '福岡県北九州市',
                'phone_number' => '090-0000-0000',
            ]
        );

        // 開発用：一般ユーザー
        User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => '一般ユーザー',
                'password' => Hash::make('password0716'),
                'role' => 'customer',
                'address' => '福岡県北九州市',
                'phone_number' => '080-0000-0000',
            ]
        );
        
    }
}
