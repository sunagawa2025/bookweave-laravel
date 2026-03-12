<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
// use Laravel\Fortify\TwoFactorAuthenticatable; // 卒業制作プロジェクトでは二要素認証（2FA）は不要なためコメントアウト

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable/*, TwoFactorAuthenticatable*/; // 卒業制作プロジェクトでは二要素認証（2FA）は不要なためコメントアウト

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'address',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        // 'two_factor_secret', // 卒業制作プロジェクトでは二要素認証（2FA）は不要なためコメントアウト
        // 'two_factor_recovery_codes', // 卒業制作プロジェクトでは二要素認証（2FA）は不要なためコメントアウト
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    //貸出履歴とのリレーション
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }
    //評価とのリレーション
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
   
}
