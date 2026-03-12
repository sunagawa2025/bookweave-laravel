<div class="p-books-index">

    <div class="p-image-area"></div>


    {{-- 一覧表示エリア --}}


    <div class="page-container bg-page">
        <div class="page-header">
            <h2 class="page-title text-center w-full">図書検索・一覧</h2>
        </div>

        <div class="search-area bg-page">
            <div class="flex justify-between items-center gap-4">
                <form wire:submit.prevent="$refresh" class="search-form flex-1">
                    <input wire:model.live.debounce.300ms="search" type="search" class="input-field"
                        placeholder="ISBN、図書名、出版社、カテゴリー、著者 (半角スペースでAND検索)..." style="width: 100%;">
                </form>
                @can('admin')
                    <a href="{{ route('books.create') }}" class="btn-simple whitespace-nowrap" wire:navigate>新規登録</a>
                @endcan
            </div>
        </div>

        <div class="table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        
                        <th class="searchable-th">ISBN</th>
                        <th class="searchable-th">図書名</th>
                        <th class="searchable-th">出版社</th>
                        <th class="searchable-th">カテゴリー</th>
                        <th class="searchable-th">著者</th>
                        <th>平均評価</th>
                        <th class="center">操作</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr wire:key="book-{{ $book->id }}">
                            
                            <td>{{ $book->isbn }}</td>
                            <td class="col-title">{{ $book->title }}</td>
                            <td class="col-publisher">{{ $book->publisher }}</td>
                            <td>{{ $book->category->category_name ?? '未設定' }}</td>
                            <td class="col-author">{{ $book->author }}</td>
                            <td class="col-rating">
                                {{ str_repeat('★', floor($book->avg_rating)) }}{{ str_repeat('☆', 5 - floor($book->avg_rating)) }}
                            </td>
                            <td class="center">
                                <div class="action-btns">
                                    
                                    <a href="{{ route('books.show', $book) }}" class="btn-simple btn-small"
                                        wire:navigate>詳細</a>
                                    <a href="{{ route('books.stocks', $book) }}" class="btn-simple btn-small"
                                        wire:navigate>在庫</a>
                                    
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            
                            <td colspan="6" class="center">一致する文書が見つかりません。</td>
                            
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-area mt-4">
            @if (is_object($books) && method_exists($books, 'links'))
                {{ $books->links() }}
            @endif
        </div>

        {{-- 隠し機能: 男塾検定 --}}
        <div class="mt-8 text-left opacity-30 hover:opacity-100 transition-opacity">
            <button onclick="window.open('{{ route('games.quiz') }}', '_blank', 'width=600,height=750')"
                class="text-4xl cursor-pointer" title="???">
                💪
            </button>
        </div>
    </div>
    
</div>
