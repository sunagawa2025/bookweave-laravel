<?php

namespace App\Livewire\Configs;

use Livewire\Component;
use App\Models\Config;

class Index extends Component
{
    /**
     * システム共通設定一覧画面
     * 1レコードのみのConfigデータを表示する。
     * データが存在しない場合は、未設定を示す初期値で自動生成する。
     */
    public function render()
    {
        // 最初のデータ取得
        $config = Config::first();

        // データがなければ初期作成
        if (!$config) {
            $config = Config::create([
                'mail_host' => 'NOT_SET',
                'mail_port' => 0, // 数値型のため0などを設定
                'mail_username' => 'NOT_SET',
                'mail_password' => 'NOT_SET',
                'mail_encryption' => 'NOT_SET',
                'mail_from_address' => 'not_set@example.com',
                'mail_from_name' => 'NOT_SET',
                // 以下の運用設定はDBデフォルト値(7, 5, 10, light)が適用される
            ]);
            // DB側のデフォルト値をインスタンスに反映させるために再取得
            $config->refresh();
        }

        return view('livewire.configs.index', [
            'config' => $config
        ])->layout('layouts.app');
    }
}
