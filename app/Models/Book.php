<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /** @use HasFactory<\Database\Factories\BookFactory> */
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'author',
        'category_id',
        'publisher',
        'stock_count',
        'image_path', 
    ];


    // public function getImagePathAttribute()
    // {
    //     // 1. DBの値を取得（なければデフォルト規約）
    //     $rawPath = $this->attributes['image_path'] ?? "images/books/bid_{$this->id}.jpg";
    // 
    //     // 2. 「storage/」と「先頭のスラッシュ」を一旦すべて綺麗に取り除く
    //     $cleanPath = ltrim(str_replace('storage/', '', $rawPath), '/');
    // 
    //     // 3. 常に「storage/」を頭に一つだけ付けて返す
    //     // これにより「storage/images/books/...」という形が保証される
    //     return "storage/" . $cleanPath;
    // }


    // ▼修正後 チーム開発優先のため storage/ を通さないパスを返す
    public function getImagePathAttribute()
    {
        // 1. DBの値を取得（なければデフォルト規約）
        $rawPath = $this->attributes['image_path'] ?? "images/books/bid_{$this->id}.jpg";

        // 2. 「storage/」および「先頭のスラッシュ」を絶対パスにならないように取り除く
        return ltrim(str_replace('storage/', '', $rawPath), '/');
    }

    //評価とのリレーション
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
    public function getAvgRatingAttribute()
    {
        return number_format($this->evaluations_avg_rating, 1);
    }
    //カテゴリとのリレーション
    function category()
    {
        return $this->belongsTo(Category::class);
    }
    // 在庫とのリレーション
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
}
