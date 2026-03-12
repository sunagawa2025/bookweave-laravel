<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    /**
     * 一括代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        // メール設定
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from_address',
        'mail_from_name',
        // 運用設定
        'loan_period_days',
        'max_loan_count',
        'pagination_count',
        'app_theme',
        /* 組織・会社情報 */
        'company_name',
        'address',
        'phone_number',
        
    ];
}
