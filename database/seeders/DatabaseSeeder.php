<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ▼修正後 260212
        // 全てのサンプルデータを各シッダーから呼び出し
        $this->call([
            UserSeeder::class,      // ユーザー（管理者・一般）
            CategorySeeder::class,  // カテゴリー
            BookSeeder::class,      // 本・在庫
            BorrowingSeeder::class,   // 貸出履歴
            EvaluationSeeder::class,  // 評価
        ]);
        // ▲修正後 260212
    }
}
