<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    /** @use HasFactory<\Database\Factories\BorrowingFactory> */
    use HasFactory;

    protected $fillable =[
        'stock_id',
        'user_id',
        'borrowed_at',
        'returned_at',
        'send_mail_check'
    ];

    protected $casts = [
        'borrowed_at'=> 'date',
        'returned_at'=> 'date'
    ];

    public function stock()
    {
        return $this->belongsTo(Stock::class);
    }

    public function user()
{
	return $this->belongsTo(User::class);
}

 public function getSendMailCheckLabelAttribute(): string
    {
        return match ($this->send_mail_check) {
            1 => '送信済み',
            0 => '未送信',
            default => '未送信',
        };
    }


}
