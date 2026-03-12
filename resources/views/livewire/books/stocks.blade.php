<div class="p-books-stocks">
    <div class="page-container bg-page">
        <div class="page-header">
            <h2 class="page-title">在庫一覧: {{ $book->title }}</h2>
        </div>

        
        {{-- 本の基本情報 --}}
        <div class="book-info-header">
            <div class="book-info-grid">
                <p class="book-info-item"><span class="label-text">ISBN:</span> <span class="value-text">{{ $book->isbn }}</span></p>
                <p class="book-info-item"><span class="label-text">著者:</span> <span class="value-text">{{ $book->author }}</span></p>
                <p class="book-info-item"><span class="label-text">出版社:</span> <span class="value-text">{{ $book->publisher }}</span></p>
                {{--貸出可能冊数の表示 --}}
                <p class="book-info-item available-count-item"><span class="label-text">貸出可能冊数:</span> <span class="value-text">{{ $availableCount }} 冊</span></p>
                
            </div>
        </div>
        {{--検索エリア (図書一覧と同一構造) --}}
        <div class="search-area bg-page">
            <div class="search-container flex justify-between items-center gap-4">
                <form wire:submit.prevent="$refresh" class="search-form flex-1">
                    <input 
                        wire:model.live.debounce.300ms="search"
                        type="search" 
                        class="input-field search-input"
                        placeholder="管理IDで検索..."
                        style="width: 100%;"
                    >
                </form>
            </div>
        </div>
        

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="col-mgmt-id searchable-th">管理ID</th>
                        <th class="col-status">状態</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stocks as $stock)
                        <tr wire:key="stock-{{ $stock->id }}" class="stock-row">
                            <td class="col-mgmt-id">{{ $stock->management_id }}</td>
                            <td class="col-status">{{ $stock->status_label }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="empty-message">在庫がありません（またはすべて廃棄済みです）。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ページネーションリンク (図書一覧と同一構造) --}}
        <div class="pagination-area mt-4">
            @if(is_object($stocks) && method_exists($stocks, 'links'))
                {{ $stocks->links() }}
            @endif
        </div>
        

        <div class="footer-action">
            <a href="{{ route('books.index') }}" class="btn-simple back-link" wire:navigate>一覧に戻る</a>
        </div>
    </div>
</div>
