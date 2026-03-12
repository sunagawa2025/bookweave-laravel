<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class LoanReminderMailableEx extends Mailable
{
    use Queueable, SerializesModels;

    public string $viewPath;
    public array $mailData;

    //コンストラクタ
    public function __construct(string $subject, string $viewPath, array $mailData)
    {
        $this->subject = $subject;
        $this->viewPath = $viewPath;
        $this->mailData = $mailData;
    }

    // メールの「封筒」設定
    public function envelope(): Envelope
    {
        // 渡された件名（$this->subject）をそのまま使います
        return new Envelope(
            subject: $this->subject,
        );
    }

    //メールの「本文」設定
    public function content(): Content
    {
        // 渡されたビューのパス（$this->viewPath）をそのまま使います
        return new Content(
            view: $this->viewPath,
        );
    }

    //添付ファイルなどの設定（今回は使いません）
    public function attachments(): array
    {
        return [];
    }
}
