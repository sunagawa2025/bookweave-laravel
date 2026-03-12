<div class="p-configs-edit">

    <div class="page-container">
        <div class="page-header">
            <h2 class="page-title">システム設定編集</h2>
            <a href="{{ route('configs.index') }}" class="link-back" wire:navigate>&lt; 戻る</a>
        </div>

        <form wire:submit.prevent="update">
            {{-- メール設定 --}}
            <fieldset class="section-frame">
                <legend class="section-title">メール送信設定</legend>
                
                <div class="form-group-container">
                    <div class="form-group">
                        <label for="mail_host" class="form-label">SMTPサーバー</label>
                        <input type="text" id="mail_host" wire:model="mail_host" class="input-field">
                        @error('mail_host') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="mail_port" class="form-label">ポート番号</label>
                        <input type="number" id="mail_port" wire:model="mail_port" class="input-field">
                        @error('mail_port') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="mail_username" class="form-label">メールユーザー名</label>
                        <input type="text" id="mail_username" wire:model="mail_username" class="input-field">
                        @error('mail_username') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="mail_password" class="form-label">メールパスワード</label>
                        <input type="text" id="mail_password" wire:model="mail_password" class="input-field">
                        @error('mail_password') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="mail_encryption" class="form-label">暗号化方式</label>
                        <select id="mail_encryption" wire:model="mail_encryption" class="input-field">
                            <option value="">指定なし</option>
                            <option value="tls">TLS</option>
                            <option value="ssl">SSL</option>
                        </select>
                        @error('mail_encryption') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="mail_from_address" class="form-label">送信元アドレス</label>
                        <input type="text" id="mail_from_address" wire:model="mail_from_address" class="input-field">
                        @error('mail_from_address') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="mail_from_name" class="form-label">送信者名</label>
                        <input type="text" id="mail_from_name" wire:model="mail_from_name" class="input-field">
                        @error('mail_from_name') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>
            </fieldset>

            {{-- 組織・会社情報 --}}
            <fieldset class="section-frame">
                <legend class="section-title">組織・会社情報</legend>
                
                <div class="form-group-container">
                    <div class="form-group">
                        <label for="company_name" class="form-label">組織・会社名</label>
                        <input type="text" id="company_name" wire:model="company_name" class="input-field">
                        @error('company_name') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">住所</label>
                        <input type="text" id="address" wire:model="address" class="input-field">
                        @error('address') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone_number" class="form-label">電話番号</label>
                        <input type="text" id="phone_number" wire:model="phone_number" class="input-field">
                        @error('phone_number') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>
            </fieldset>
            

            {{-- 運用・表示設定 --}}
            <fieldset class="section-frame">
                <legend class="section-title">運用・表示設定</legend>
                
                <div class="form-group-container">
                    <div class="form-group">
                        <label for="loan_period_days" class="form-label">標準貸出期間(日)</label>
                        <input type="number" id="loan_period_days" wire:model="loan_period_days" class="input-field">
                        @error('loan_period_days') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="max_loan_count" class="form-label">最大貸出冊数</label>
                        <input type="number" id="max_loan_count" wire:model="max_loan_count" class="input-field">
                        @error('max_loan_count') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="pagination_count" class="form-label">1ページ表示件数</label>
                        <input type="number" id="pagination_count" wire:model="pagination_count" class="input-field">
                        @error('pagination_count') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="app_theme" class="form-label">システムテーマ</label>
                        <select id="app_theme" wire:model="app_theme" class="input-field">
                            <option value="light">Light (標準)</option>
                            <option value="dark">Dark</option>
                            <option value="blue">Blue</option>
                            <option value="green">Green</option>
                            <option value="orange">Orange</option>
                            <option value="pink">Pink</option>
                        </select>
                        @error('app_theme') <span class="error-msg">{{ $message }}</span> @enderror
                    </div>
                </div>
            </fieldset>

            {{--固定フッターによる被り防止のため下部余白を追加：元ソース --}}
            
            <div class="mt-8 mb-40">
                <button type="submit" class="btn-submit">
                    設定を更新する
                </button>
            </div>
            
        </form>
    </div>
    
</div>
