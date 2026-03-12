<?php

namespace App\Services;

/**
 * Laravelのメール送信で必要となる設定項目をすべて保持します。
 */
class MailConfigEx
{
    public string $host;       // SMTPサーバー (例: smtp.mailtrap.io)
    public int $port;          // ポート番号 (例: 587, 465)
    public string $username;   // ユーザー名
    public string $password;   // パスワード
    public string $encryption; // 暗号化方式 (例: tls, ssl)
    public string $fromAddress; // 送信元アドレス
    public string $fromName;    // 送信元名

    /**
     * コンストラクタで全ての設定値をセットします。
     */
    public function __construct(
        string $host,
        int $port,
        string $username,
        string $password,
        string $encryption,
        string $fromAddress,
        string $fromName
    ) {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->encryption = $encryption;
        $this->fromAddress = $fromAddress;
        $this->fromName = $fromName;
    }
}
