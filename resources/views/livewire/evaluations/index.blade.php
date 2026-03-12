
<div class="p-evaluations-index">
    
   <div class="evaluation-wrapper">
        <h2 class="page-title">
            みんなのレビュー
      
            （評価一覧）
        </h2>

         {{-- フィルタエリア --}}
         <div class="filter-area">
             <div class="filter-group">
                 <select wire:model.live="perPage" class="filter-input">
                     {{-- ※ クラス（Index.php）の render 内、return view() の引数で明示的に渡されたシステム設定値($defaultPaginationCount)を表示 --}}
                     <option value="default">デフォルト（システム設定：{{ $defaultPaginationCount }}件）</option>
                     <option value="10">10件</option>
                     <option value="20">20件</option>
                     <option value="50">50件</option>
                 </select>
             </div>
         </div>

        <div class="content-box">
            <div class="content-body">
                {{-- 検索バー --}}
                <div class="search-bar">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="書籍名、ユーザー名、コメント (半角スペースでAND検索)..." 
                        class="search-input" style="width: 400px !important;"
                    >
                    <select wire:model.live="selectedCategory" class="search-select">
                        <option value="">すべてのカテゴリ</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    <select wire:model.live="selectedRating" class="search-select rating-select">
                        <option value="">すべての評価</option>
                        <option value="5">★5のみ</option>
                        <option value="4">★4以上</option>
                        <option value="3">★3以上</option>
                        <option value="2">★2以上</option>
                    </select>
                </div>

                <table class="evaluation-table">
                    <thead>
                        <tr>
                            <th class="searchable-th">書籍名</th>
                            <th class="searchable-th">ユーザー</th>
                            <th>評価</th>
                            <th class="searchable-th">コメント</th>
                            <th>日時</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evaluations as $evaluation)
                            <tr wire:key="evaluation-{{ $evaluation->id }}">
                                <td class="col-title">
                                    {{ $evaluation->book->title ?? '削除された書籍' }}
                                </td>
                                <td class="col-user">
                                    {{ $evaluation->user->name ?? '退会済みユーザー' }}
                                </td>
                                <td class="col-rating">
                                    {{ str_repeat('★', $evaluation->rating) }}{{ str_repeat('☆', 5 - $evaluation->rating) }}
                                </td>
                                <td class="col-comment">
                                    {{ $evaluation->comment }}
                                </td>
                                <td class="col-date">
                                    {{ $evaluation->created_at->format('Y/m/d H:i') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-message">まだ評価はありません。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- ページネーション --}}
                <div class="pagination-wrapper">
                    @if(is_object($evaluations) && method_exists($evaluations, 'links'))
                        {{ $evaluations->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>