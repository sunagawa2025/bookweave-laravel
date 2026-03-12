<div class="p-top">
    @can('admin')
        
        <div class="top-container">
            <div class="p-image-area"></div>
            <h2 class="top-title">管理者メニュー</h2>
            
            <div style="width: 100%; text-align: center;">
                <h3 class="top-title" style="font-size: 1.1rem; margin-top: 0px; margin-bottom: 5px; border-bottom: none; border-bottom: 2px solid var(--lib-accent);">カウンター業務</h3>
            </div>
            <div class="user-menu-grid admin-menu-grid" style="margin-bottom: 10px;">
                <a href="{{route('loan.checkout')}}" class="user-menu-link admin-menu-link">
                    <span class="user-menu-text admin-menu-text">[貸出受付]</span>
                </a>
                <a href="{{route('loan.checkin')}}" class="user-menu-link admin-menu-link">
                    <span class="user-menu-text admin-menu-text">[返却受付]</span>
                </a>
                <a href="{{route('loan.status')}}" class="user-menu-link admin-menu-link">
                    <span class="user-menu-text admin-menu-text">[貸出状況]</span>
                </a>
                <a href="{{route('loan.overdue')}}" class="user-menu-link admin-menu-link">
                    <span class="user-menu-text admin-menu-text">[督促管理]</span>
                </a>
            </div>

            <div style="width: 100%; text-align: center;">
                <h3 class="top-title" style="font-size: 1.1rem; margin-bottom: 5px; border-bottom: none; border-bottom: 2px solid var(--lib-accent);">顧客・図書管理</h3>
            </div>
            <div class="user-menu-grid admin-menu-grid" style="margin-bottom: 10px;">
                <a href="{{route('users.index')}}" class="user-menu-link admin-menu-link">
                    <span class="user-menu-text admin-menu-text">[ユーザー管理]</span>
                </a>
                <a href="{{route('books.index')}}" class="user-menu-link admin-menu-link">
                    <span class="user-menu-text admin-menu-text">[図書管理]</span>
                </a>
                <a href="{{route('categories.index')}}" class="user-menu-link admin-menu-link" wire:navigate>
                    <span class="user-menu-text admin-menu-text">[カテゴリー管理]</span>
                </a>
            </div>

            <div style="width: 100%; text-align: center;">
                <h3 class="top-title" style="font-size: 1.1rem; margin-bottom: 5px; border-bottom: none; border-bottom: 2px solid var(--lib-accent);">設定</h3>
            </div>
            <div class="user-menu-grid admin-menu-grid">
                <a href="{{route('configs.index')}}" class="user-menu-link admin-menu-link" wire:navigate>
                    <span class="user-menu-text admin-menu-text">[システム共通設定]</span>
                </a>
            </div>
        </div>
       
    @else
        
        <div class="top-container">
            <div class="p-image-area"></div>
            <h2 class="top-title">利用者メニュー</h2>
            <div class="user-menu-grid" style="margin-top: 30px;">
                <a href="{{ route('books.index') }}" class="user-menu-link">
                    <span class="user-menu-text">[本を探す（検索）]</span>
                </a>
                <a href="{{ route('loan-history.index') }}" class="user-menu-link">
                    <span class="user-menu-text">[自分の貸出状況・履歴]</span>
                </a>
               
                <a href="{{ route('evaluations.index') }}" class="user-menu-link">
                    <span class="user-menu-text">[みんなのレビュー（評価一覧）]</span>
                </a>
                <a href="{{ route('evaluations.ranking') }}" class="user-menu-link">
                    <span class="user-menu-text">[図書ランキング（評価集計）]</span>
                </a>
                
            </div>
        </div>
        
    @endcan  
</div>
