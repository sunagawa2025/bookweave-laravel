<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Evaluation;
use App\Models\Book;
use App\Models\User;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // 管理者ユーザーを取得
        $admin = User::where('email', 'admin@gmail.com')->first();
        if (!$admin) return;

        // 本を取得（魁!!男塾）
        $book = Book::where('isbn', '9784001000011')->first();
        if (!$book) return;

        // 評価を登録（1件） - 既にあれば何もしない
        Evaluation::firstOrCreate(
            [
                'book_id' => $book->id,
                'user_id' => $admin->id,
            ],
            [
                'rating' => 5,
                'comment' => '日本男児必読の書！民明書房の解説も素晴らしい。',
            ]
        );
        
    }
}
