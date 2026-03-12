<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Mail\Mailable;

class MailNotificationEx
{
    /**
     * @var MailConfigEx 送信設定（ここから送信元アドレス等を取得します）
     */
    private MailConfigEx $config;

    /**
     * コンストラクタ
     * 
     * クラスを呼び出すときに、あらかじめ設定オブジェクト（MailConfigEx）を
     * 渡してもらう仕組み。
     * 
     * @param MailConfigEx $config
     */
    public function __construct(MailConfigEx $config)
    {
        $this->config = $config;
    }

    /**
     * メール送信を実行するメソッド
     * 
     * メール送信実行
     *
     * @param string $toAddress 送信先メールアドレス
     * @param \Illuminate\Mail\Mailable $mailable 送信するMailableオブジェクト
     * @return bool 送信成功:true / 失敗:false
     */
    public function send(string $toAddress, \Illuminate\Mail\Mailable $mailable): bool
    {
        try {
            // 受け取った設定をLaravelの設定に動的に反映させます
            config([
                'mail.default'                 => 'smtp', // 追加　一時的にSMTP送信機にスイッチを切り替える(.envではlog?になっている。)
                'mail.mailers.smtp.host'       => $this->config->host,
                'mail.mailers.smtp.port'       => $this->config->port,
                'mail.mailers.smtp.username'   => $this->config->username,
                'mail.mailers.smtp.password'   => $this->config->password,
                'mail.mailers.smtp.encryption' => $this->config->encryption,
                'mail.from.address'            => $this->config->fromAddress,
                'mail.from.name'               => $this->config->fromName,
            ]);

            // 送信実行
            // 受け取ったMailableオブジェクトをそのまま送信します
            Mail::to($toAddress)->send($mailable);

            // 成功ログ
            \Log::info("【メール送信成功】宛先: {$toAddress} (Mailableクラス: " . get_class($mailable) . ")");

            return true;

        } catch (\Exception $e) {
            // エラー時はログに残し、falseを返す
            \Log::error("【メール送信失敗】" . $e->getMessage());
            return false;
        }
    }
}
