<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    /** @use HasFactory<\Database\Factories\EvaluationFactory> */
    use HasFactory;

    //MassAssignment許可
    protected $fillable = [
        'book_id',
        'user_id',
        'rating',
        'comment',
    ];
    //本とのリレーション
    
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    //利用者とのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
