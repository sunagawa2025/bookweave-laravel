<div class="p-loan-history-index">
    


    <div class="page-container">
        <div class="page-header">
            <h2 class="page-title">貸出履歴一覧</h2>
        </div>

        {{-- 検索フィルタ --}}
        <div class="filter-area">
            <div class="filter-group">
                <span class="filter-label">開始:</span>
                <input type="date" wire:model.live="borrowedAtFrom" class="filter-input">
            </div>
            <div class="filter-group">
                <span class="filter-label">終了:</span>
                <input type="date" wire:model.live="borrowedAtTo" class="filter-input">
            </div>
            <div class="filter-group">
                <span class="filter-label">ステータス:</span>
                <select wire:model.live="status" class="filter-input">
                    <option value="">全て</option>
                    <option value="borrowed">未返却</option>
                    <option value="available">返却済み</option>
                </select>
            </div>
            <div class="filter-group">
                <span class="filter-label">検索:</span>
                <input type="text" wire:model.live.debounce.300ms="searchKeyword"
                    placeholder="ISBN、タイトル、著者名、分類、出版社、管理ID (半角スペースでAND検索)..." class="filter-input"
                    style="width: 520px;">
            </div>
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="searchable-th">ISBN</th>
                        <th class="searchable-th">タイトル</th>
                        <th class="searchable-th">著者名</th>
                        <th class="searchable-th">分類</th>
                        <th class="searchable-th">出版社</th>
                        <th class="searchable-th">管理ID</th>
                        <th wire:click="toggleBorrowedDateSort" class="sortable">
                            貸出日 {{ $sortTypeBorrowdDate === 'desc' ? '▼' : '▲' }}
                        </th>
                        <th>返却日</th>
                        <th>ステータス</th>
                        <th>詳細</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($borrowings as $borrowing)
                        <tr wire:key="history-{{ $borrowing->id }}">
                            <td>{{ $borrowing->stock->book->isbn }}</td>
                            <td class="col-title">{{ $borrowing->stock->book->title }}</td>
                            <td class="col-author">{{ $borrowing->stock->book->author }}</td>
                            
                            <td class="col-category">
                                {{ $borrowing->stock->book->category->category_name === null ? '' : $borrowing->stock->book->category->category_name }}
                            </td>
                            <td class="col-publisher">{{ $borrowing->stock->book->publisher }}</td>
                            <td>{{ $borrowing->stock->management_id }}</td>
                            <td>{{ $borrowing->borrowed_at->format('Y/m/d') }}</td>
                            <td>{{ $borrowing->returned_at ? $borrowing->returned_at->format('Y/m/d') : '-' }}</td>
                            
                            <td>{{ $borrowing->stock->status_label }}</td>
                            
                            <td>
                                <a class="pagelink" href="{{ route('books.show', $borrowing->stock->book->id) }}"
                                    class="link-simple" wire:navigate>詳細</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 30px;">貸出履歴はありません。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{--ページネーション追加 --}}
        <div class="pagination-wrapper mt-4">
            @if (is_object($borrowings) && method_exists($borrowings, 'links'))
                {{ $borrowings->links() }}
            @endif
        </div>
        
    </div>
    
</div>
