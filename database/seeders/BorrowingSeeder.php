<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Borrowing;
use App\Models\Stock;
use App\Models\User;
use Carbon\Carbon;

class BorrowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ▼追加 260212
        // 一般ユーザーを取得
        $user = User::where('email', 'user@gmail.com')->first();
        if (!$user) return;

        // 在庫を取得（BookSeederで作成したUUIDのものを想定）
        $stocks = Stock::all();
        if ($stocks->count() < 3) return;

        // 貸出データ案（3件）
        $data = [
            [
                'stock_id' => $stocks[0]->id,
                'user_id' => $user->id,
                'borrowed_at' => Carbon::now()->subDays(7)->toDateString(),
                'returned_at' => Carbon::now()->subDays(3)->toDateString(),
            ],
            [
                'stock_id' => $stocks[1]->id,
                'user_id' => $user->id,
                'borrowed_at' => Carbon::now()->subDays(5)->toDateString(),
                'returned_at' => Carbon::now()->subDay()->toDateString(),
            ],
            [
                'stock_id' => $stocks[2]->id,
                'user_id' => $user->id,
                'borrowed_at' => Carbon::now()->toDateString(),
                'returned_at' => null, // 貸出中
            ],
        ];

        foreach ($data as $item) {
            Borrowing::firstOrCreate(
                [
                    'stock_id' => $item['stock_id'],
                    'borrowed_at' => $item['borrowed_at'],
                ],
                $item
            );
        }
        // ▲追加 260212
    }
}
