<?php

namespace App\Services;

use App\Models\Config;
use App\Mail\LoanReminderMailableEx;//Mailableクラスを継承したクラス
use App\Services\MailConfigEx;//メール共通設定データ保持クラス
use App\Services\MailNotificationEx;//メール送信クラス
use App\Models\Borrowing;
use Illuminate\Support\Facades\Log;

class UseMailNotificationSample
{
    public function sendNotificationMail(): void
    {
        // データベースから設定情報を取得します（設定は1件のみ）
        $dbConfig = Config::first();

        // 設定データが存在しない場合は処理を中断またはエラーにする(設定画面を表示した時点で設定データが作られる仕様にしてるのでここでは作らない。)
        if (!$dbConfig) {
            \Log::error("メール設定が見つかりません。configsテーブルを確認してください。");
            return;
        }
        //▼共通設定なので1回だけ設定。

        $mailConfigObj = new MailConfigEx(//メール共通設定データ保持クラス作成(あとでMailNotificationのコンストラクタに渡す。)
            $dbConfig->mail_host ?? '',       // host
            $dbConfig->mail_port ?? 587,      // port
            $dbConfig->mail_username ?? '',   // username
            $dbConfig->mail_password ?? '',   // password
            $dbConfig->mail_encryption ?? 'tls', // encryption
            $dbConfig->mail_from_address ?? '',  // from address
            $dbConfig->mail_from_name ?? ''      // from name
        );
        $mailNotificationObj = new MailNotificationEx($mailConfigObj);//共通設定データ保持クラスを渡して、メール送信クラスを作成。

        // 2. 未返却（延滞など）のデータを取得するイメージ
        $overdueLoans = []; 
        $overdueLoans = Borrowing::whereNull('returned_at')
    ->where('borrowed_at', '<', now()->subDays($dbConfig->loan_period_days))
    ->where('send_mail_check', 0)
    ->get();

        // 3. ループで一人ずつ順番にメールを送る！
        // 件名とテンプレートは全員共通
        $subject  = "図書返却のお願い";
        $viewPath = 'emails.mail_template';
        foreach ($overdueLoans as $loan) {
            $user_name  = $loan->user->name;
            $book_title = $loan->stock->book->title;
            
            // 返却期限の計算
            $due_date   = $loan->borrowed_at->addDays($dbConfig->loan_period_days); 

            // 本文の中で使いたいデータを配列にまとめます
            $mailData = [
                'user_name'  => $user_name,
                'book_title' => $book_title,
                'due_date'   => $due_date,
            ];

            // ---------------------------------------------------------
            // ★Mailableクラスの作成()
            // ---------------------------------------------------------
            $mailable = new LoanReminderMailableEx(
                $subject,   // 件名 (共通)
                $viewPath,  // テンプレート (共通)
                $mailData   // データ (個別)
            );
           
            $toAddress =$loan->user->email;

            
            // Mailableオブジェクトをそのまま渡して送信依頼します
            $success = $mailNotificationObj->send(
                $toAddress,         // 宛先
                $mailable           // Mailableオブジェクト
            );

            if ($success) {
                // 送信後のログ記録などの処理
                Log::info('督促メールを送信しました。');
            }
        }
    }
}
