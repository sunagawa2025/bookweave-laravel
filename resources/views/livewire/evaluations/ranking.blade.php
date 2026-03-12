
<div class="p-evaluations-ranking">
    {{--画像配置用プレースホルダー --}}
    <div class="p-image-area"></div>
  
    <div class="evaluation-wrapper">
        <h2 class="page-title">図書ランキング（平均評価）</h2>

        <div class="content-box">
            <div class="content-body">
                {{-- 検索バー --}}
                <div class="search-bar">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search" 
                        placeholder="書籍名で検索..." 
                        class="search-input" style="width: 320px !important;"
                    >
                    <select wire:model.live="selectedCategory" class="search-select">
                        <option value="">すべてのカテゴリ</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <table class="evaluation-table">
                    <thead>
                        <tr>
                            <th>順位</th>
                            <th class="searchable-th">書籍名</th>
                            <th>カテゴリ</th>
                            <th>平均評価</th>
                            <th>レビュー件数</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rankings as $ranking)
                            <tr wire:key="ranking-{{ $ranking->book_id }}">
                                {{--ページネーション対応の順位計算--}}
                                <td>{{ ($rankings->currentPage() - 1) * $rankings->perPage() + $loop->iteration }}</td>
                               
                                <td class="col-title">
                                    {{ $ranking->book->title ?? '削除された書籍' }}
                                </td>
                                <td class="col-category">
                                    {{ $ranking->book->category->category_name ?? '-' }}
                                </td>
                                <td class="col-rating">
                                    {{ number_format($ranking->avg_rating, 1) }}
                                    <span>
                                        {{ str_repeat('★', floor($ranking->avg_rating)) }}{{ str_repeat('☆', 5 - floor($ranking->avg_rating)) }}
                                    </span>
                                </td>
                                <td>
                                    {{ $ranking->count }} 件
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="empty-message">まだ評価データがありません。</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{--ページネーションリンク--}}
                <div class="pagination-wrapper mt-4">
                    @if(is_object($rankings) && method_exists($rankings, 'links'))
                        {{ $rankings->links() }}
                    @endif
                </div>
                
            </div>
        </div>
    </div>
</div>
