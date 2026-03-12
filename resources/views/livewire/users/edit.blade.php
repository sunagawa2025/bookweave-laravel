<div class="p-users-edit">
    {{-- ▼追加 260221 画像配置用プレースホルダー（コピーして使う） --}}
    {{-- <div class="p-image-area"></div> --}}
    {{-- ▲追加 260221 --}}    {{-- ▼修正前 260216
    <div>
        <h1>ユーザー編集</h1>
        <form wire:submit="update">
            <div>
                <label>氏名</label>
                <input type="text" wire:model="name">
            </div>
            <div>
                <label>メールアドレス</label>
                <input type="email" wire:model="email">
            </div>
            <div>
                <label>パスワード</label>
                <input type="password" wire:model="password">
            </div>
            <div>
                <label>権限</label>
                <input type="text" wire:model="role">
            </div>
            <div>
                <label>住所</label>
                <input type="text" wire:model="address">
            </div>
            <div>
                <label>電話番号</label>
                <input type="text" wire:model="phone_number">
            </div>
            <button type="submit">更新</button>
        </form>
        <a href="{{route('users.index')}}">一覧に戻る</a>
    </div>
    ▲修正前 260216 --}}

    {{-- ▼修正後 260216 --}}
    <div class="page-container">
        <div class="page-header">
            <h2>ユーザー編集</h2>
        </div>

        <form wire:submit="update" class="form-container">
            <div class="form-group">
                <label class="form-label">氏名</label>
                <input type="text" wire:model="name" class="input-field" required>
                @error('name') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            
            <div class="form-group">
                <label class="form-label">メールアドレス</label>
                <input type="email" wire:model="email" class="input-field" required>
                @error('email') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">パスワード（変更する場合のみ入力）</label>
                <input type="password" wire:model="password" class="input-field">
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">権限</label>
                <select wire:model="role" class="input-field">
                    <option value="customer">Customer (利用者)</option>
                    <option value="admin">Admin (管理者)</option>
                </select>
                @error('role') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">住所</label>
                <input type="text" wire:model="address" class="input-field">
                @error('address') <span class="error-msg">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label class="form-label">電話番号</label>
                <input type="text" wire:model="phone_number" class="input-field">
                @error('phone_number') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            
            <div class="btn-container">
                <button type="submit" class="btn-submit">更新を実行</button>
            </div>
        </form>

        <div class="back-link-container">
            <a href="{{ route('users.index') }}" class="btn-simple back-link" wire:navigate>一覧に戻る</a>
        </div>
    </div>
    {{-- ▲修正後 260216 --}}
</div>