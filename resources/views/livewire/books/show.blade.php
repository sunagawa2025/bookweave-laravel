<div class="p-books-show">
        <div class="page-container">
        {{-- [title] --}}
        <div class="page-header">
            <h2>図書詳細: {{ $book->title }}</h2>
            <p class="page-sub">登録ID: {{ $book->id }}</p>
        </div>

        {{-- [detail] 書籍詳細 --}}
        <div class="detail-container">
            <h3 class="section-title">書籍情報</h3>
            <div class="detail-row">
                <span class="detail-label">ISBN</span>
                <span class="detail-value">{{ $book->isbn ?? '-' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">タイトル</span>
                <span class="detail-value">{{ $book->title }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">著者</span>
                <span class="detail-value">{{ $book->author ?? '未登録' }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">出版社</span>
                <span class="detail-value">{{ $book->publisher ?? '-' }}</span>
            </div>
        </div>

        {{-- [image] --}}
        <div class="image-area">
            <img src="{{ asset($book->image_path) }}" class="w-full h-full object-contain">
        </div>

        <div class="bottom-row">
            {{-- 左のカラムを作成し、フォームとナビボタンをセットにしてGridの影響を抑える --}}
            <div class="bottom-left-column" style="display: flex; flex-direction: column; gap: 15px;">
                {{-- [form] 評価投稿フォーム --}}
                <div class="form-area" style="width: 100%;">
                    <h3 class="section-title">評価・コメントを投稿</h3>
                    @if (session('status'))
                        <div class="status-message">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="detail-label">評価</label>
                        <select wire:model="evaluation" class="input-field input-small">
                            <option value="5">★★★★★</option>
                            <option value="4">★★★★</option>
                            <option value="3">★★★</option>
                            <option value="2">★★</option>
                            <option value="1">★</option>
                        </select>
                        @error('evaluation')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="detail-label">感想・コメント</label>
                        <textarea wire:model="comment" rows="3" class="input-field" placeholder="コメントを書いてね"></textarea>
                        @error('comment')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="btn-container">
                        <button wire:click="evaluate" class="btn-check">
                            登録
                        </button>
                    </div>
                </div> {{-- form-areaの終了 --}}

                {{-- ナビボタン類：枠の左下に配置 --}}
                <div class="action-bar" style="display: flex; gap: 10px; justify-content: flex-start; align-items: center;">
                    <a href="{{ route('books.index') }}" class="btn-simple back-link" wire:navigate>一覧に戻る</a>
                    @can('admin')
                        <a href="{{ route('books.edit', $book->id) }}" class="btn-simple admin-link" wire:navigate>編集画面へ</a>
                    @endcan
                </div>
            </div> {{-- bottom-left-columnの終了 --}}

        {{-- [list] レビュー一覧 --}}
        <div class="review-list">
            <div class="evaluation-wrapper">
                <h2 class="page-title">みんなのレビュー<br>（{{ $book->title }}）</h2>

                {{-- フィルタエリア --}}
                <div class="filter-area">
                    <div class="filter-group">
                        <label class="filter-label">表示件数</label>
                        <select wire:model="perPage" class="filter-input">
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
                            <input type="text" wire:model.live="search" placeholder="ユーザー、コメントで検索..."
                                class="search-input">
                            <select wire:model.live="selectedRating" class="search-select">
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
                                    <th class="searchable-th">ユーザー</th>
                                    <th>評価</th>
                                    <th>日時</th>
                                </tr>
                                <tr>
                                    <th colspan="3" class="searchable-th">コメント</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($evaluations as $evaluation)
                                <tr wire:key="evaluation-{{ $evaluation->id }}">
                                   
                                        <td class="col-user">
                                            {{ $evaluation->user->name ?? '退会済みユーザー' }}
                                        </td>
                                        <td class="col-rating">
                                            <span class="star-rating">{{ str_repeat('★', $evaluation->rating) }}</span>
                                        </td>
                                        <td class="col-user">
                                            {{ $evaluation->created_at->format('Y/m/d') }}
                                        </td>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                            {{ $evaluation->comment }}
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="empty-message">まだ評価はありません。</td>
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
        </div> {{-- review-listの終了 --}}
    </div> {{-- bottom-rowの終了 --}}


</div> {{-- page-containerの終了 --}}
</div> {{-- p-books-showの終了 --}}
