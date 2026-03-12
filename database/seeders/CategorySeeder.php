<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ▼修正後 260212
        $category_names = [
            '文学・小説',
            'コンピュータ・IT',
            'ビジネス・経済',
            '自己啓発',
            '趣味・実用',
        ];

        foreach ($category_names as $name) {
            \App\Models\Category::firstOrCreate(
                ['category_name' => $name] // この名前のデータを探す
            );
        }
        // ▲修正後 260212
    }
}
