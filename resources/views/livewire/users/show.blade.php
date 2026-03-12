<div class="p-users-show">
    {{-- ▼追加 260221 画像配置用プレースホルダー（コピーして使う） --}}
    {{-- <div class="p-image-area"></div> --}}
    {{-- ▲追加 260221 --}}    {{-- ▼修正後 260216 --}}
    <div class="page-container">
        <div class="page-header">
            <h2>ユーザー詳細</h2>
        </div>

        {{-- ▼追加 260225 削除不可などのエラーメッセージ表示 --}}
        @if (session()->has('error'))
            <div class="alert alert-danger" style="color: #e3342f; background-color: #fcebea; border: 1px solid #efb2ab; padding: 10px; border-radius: 5px; margin-bottom: 20px; font-weight: bold;">
                {{ session('error') }}
            </div>
        @endif
        {{-- ▲追加 260225 --}}

        <div class="detail-container">
            <div class="detail-row">
                <span class="detail-label">ID</span>
                <span class="detail-value">{{ $user->id }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">氏名</span>
                <span class="detail-value">{{ $user->name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">メールアドレス</span>
                <span class="detail-value">{{ $user->email }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">権限</span>
                <span class="detail-value">
                    @if($user->role === 'admin')
                        管理者 (Admin)
                    @else
                        利用者 (Customer)
                    @endif
                </span>
            </div>
            <div class="detail-row">
                <span class="detail-label">住所</span>
                <span class="detail-value">{{ $user->address }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">電話番号</span>
                <span class="detail-value">{{ $user->phone_number }}</span>
            </div>
        </div>

        <div class="action-bar flex justify-between items-center mt-4 max-w-lg w-full">
            <div class="flex gap-2">
                <a href="{{ route('users.index') }}" class="btn-simple back-link" wire:navigate>一覧に戻る</a>
                <a href="{{ route('users.edit', $user->id) }}" class="btn-simple admin-link">編集画面へ</a>
            </div>

            <div class="btn-flexright">
                 <button wire:click="destroy" wire:confirm="削除してもよろしいですか？" class="btn-delete">削除</button>
            </div>
        </div>
    </div>
</div>
