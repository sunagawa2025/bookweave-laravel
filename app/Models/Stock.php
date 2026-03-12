<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    /** @use HasFactory<\Database\Factories\StockFactory> */
    use HasFactory;

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    protected $fillable = [
        'management_id',
        'book_id',
        'status',
    ];
 
 function book(){//子テーブル
        return $this->belongsTo(Book::class);//親テーブル
    }

   
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'borrowed' => '未返却（貸出中）',
            'available' => '返却済み(貸出可)',
            'disposed'  => '廃棄済み',
            default => '不明なステータス', // defaultも設定しておくと安全
        };
    }


}
