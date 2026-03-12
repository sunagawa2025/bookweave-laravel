<div class="p-users-create">
    {{-- ▼追加 260221 画像配置用プレースホルダー（コピーして使う） --}}
    {{-- <div class="p-image-area"></div> --}}
    {{-- ▲追加 260221 --}}    {{-- ▼修正前 260216
    <div style="padding: 20px;">
        <h2 style="margin-bottom: 20px;">ユーザー登録</h2>
        <form wire:submit="save" style="display: flex; flex-direction: column; gap: 15px; max-width: 500px; margin-bottom: 20px;">
            ...
        </form>
    </div>
    ▲修正前 260216 --}}

    {{-- ▼修正後 260216 --}}
    <div class="page-container">
        <div class="page-header">
            <h2>ユーザー登録</h2>
        </div>

        <form wire:submit="save" class="form-container">
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
                <label class="form-label">パスワード</label>
                <input type="password" wire:model="password" class="input-field" required>
                @error('password') <span class="error-msg">{{ $message }}</span> @enderror
            </div>
            <div class="form-group">
                <label class="form-label">権限</label>
                <select wire:model="role" class="input-field">
                    <option value="">選択してください</option>
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
            
            <div style="margin-top: 10px;" class="btn-container">
                <button type="submit" class="btn-submit">登録</button>
            </div>
        </form>

        <a href="{{route('users.index')}}" class="btn-simple back-link" wire:navigate>一覧に戻る</a>
    </div>
    {{-- ▲修正後 260216 --}}
</div>
