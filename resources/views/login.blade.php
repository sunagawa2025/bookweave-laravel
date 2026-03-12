<x-layouts::auth>
    <div class="p-login">
            <div class="page-container">
            
            <div class="page-header-container">
                <span class="logo-icon-wrapper">
                    <img src="{{ asset('images/logo.png') }}"
                 alt="ロゴ" class="size-8" />
                </span>
                <h1 class="page-title">図書管理システム</h1>
            </div>
            
            
            @if (Route::has('login'))
                <div class="action-container">
                    @auth
                        {{-- ログイン済みの場合 --}}
                        <a href="{{ route('top') }}">トップ画面へ</a>
                    @else
                        {{-- 未ログインの場合：ログインボタンのみ表示 --}}
                        <a href="{{ route('login') }}" class="btn-login-entry">
                            ログインする
                        </a>
                    @endauth
                </div>
            @endif
        </div>
    </div>
</x-layouts::auth>