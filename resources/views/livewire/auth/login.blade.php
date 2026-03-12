<x-layouts::auth>
    <div class="p-auth-login auth-card">
        <div class="auth-header-container">
            <span class="logo-icon-wrapper">
                <x-app-logo-icon class="logo-icon" />
            </span>
            
            <x-auth-header title="図書管理システム - ログイン" description="メールアドレスとパスワードを入力してください" />
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="status-message" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="login-form">
            @csrf

            <!-- Email Address -->
            
            <flux:input
                name="email"
                label="メールアドレス"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />
           
            <div class="password-wrapper">
                
                <flux:input
                    name="password"
                    label="パスワード"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="パスワードを入力"
                    viewable
                />
            

                @if (Route::has('password.request'))
                   
                    <flux:link class="forgot-password-link" :href="route('password.request')" wire:navigate>
                        パスワードをお忘れですか？
                    </flux:link>
                   
                @endif
            </div>

            
            <flux:checkbox name="remember" label="ログイン状態を保持する" :checked="old('remember')" />
           

            <div class="action-footer">
                
                <flux:button variant="primary" type="submit" class="btn-login" data-test="login-button">
                    ログイン
                </flux:button>
                
            </div>
        </form>

    </div>
</x-layouts::auth>
