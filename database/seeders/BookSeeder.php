<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Book;
use App\Models\Stock;
use App\Models\Category;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ▼修正後 260212
        // コンピュータ・ITカテゴリを取得
        $category = Category::where('category_name', 'コンピュータ・IT')->first();
        $categoryId = $category ? $category->id : 1;

        // 1. 本の登録（1件） - 既にISBNがあれば何もしない
        $book = Book::firstOrCreate(
            ['isbn' => '9784001000011'], // 検索条件（ハイフンなし13文字）
            [
                'title' => '魁!!男塾',
                'author' => '宮下あきら',
                'publisher' => '集英社',
                'category_id' => $categoryId,
            ]
        );

        // 2. 在庫の登録（3件） - UUID形式の固定IDを使用。既にあれば何もしない
        $stockData = [
            '550e8400-e29b-41d4-a716-446655440001',
            '550e8400-e29b-41d4-a716-446655440002',
            '550e8400-e29b-41d4-a716-446655440003',
        ];

        foreach ($stockData as $uuid) {
            Stock::firstOrCreate(
                ['management_id' => $uuid], // 検索条件
                [
                    'book_id' => $book->id,
                    'status' => 'available',
                ]
            );
        }
        // ▲修正後 260212
    }
}
