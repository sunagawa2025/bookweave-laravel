
<h1>図書返却のお知らせ</h1>
<p>{{ $mailData['user_name'] }} 様</p>

<p>いつもご利用ありがとうございます。</p>
<p>お借りいただいている以下の本の返却期限が過ぎております。</p>

<div style="background: #f4f4f4; padding: 15px; border-radius: 5px;">
    <p><strong>図書名：</strong> {{ $mailData['book_title'] }}</p>
    <p><strong>返却期限：</strong> {{ $mailData['due_date'] }}</p>
</div>

<p>お早めに図書館までお越しください。</p>
<hr>
<p>※このメールは BookWeave システムからの自動送信です。</p>
