<div class="p-loan-status">
    
    @if (session('message'))
        <div class="alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="page-container bg-page">
        <h2 class="page-title">
            貸出状況
        </h2>

        <div class="content-area">
          
            {{-- フィルタエリア --}}
            <div class="filter-area">
                <div class="filter-group">
                    <label class="filter-label">表示件数</label>
                    
                    <select wire:model.live="perPage" class="filter-input">
                        <option value="default">デフォルト（システム設定：{{ $dbConfig->pagination_count ?? 10 }}件）</option>
                        <option value="10">10件</option>
                        <option value="20">20件</option>
                        <option value="50">50件</option>
                    </select>
                    
                </div>
                <div class="filter-group">
                    <label class="filter-label">開始日付</label>
                    <input type="date" wire:model.lazy="borrowedAtFrom" class="filter-input">
                </div>
                <div class="filter-group">
                    <label class="filter-label">終了日付</label>
                    <input type="date" wire:model.lazy="borrowedAtTo" class="filter-input">
                </div>
                <div class="filter-group">
                    <label class="filter-label">ステータス</label>
                    <select wire:model.lazy="status" class="filter-input">
                        <option value="">全て</option>
                        <option value="borrowed">未返却</option>
                        <option value="available">返却済み</option>
                    </select>
                </div>
              
                <div class="filter-group">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="searchManagementId" 
                        class="filter-input" 
                        placeholder="管理IDを入力..."
                    >
                </div>
                
            </div>

            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ユーザーID</th>
                            <th>氏名</th>
                            <th class="searchable-th">管理ID</th>
                            <th wire:click="sortBy('borrowed_at')" style="cursor: pointer;">
                                貸出日
                                @if ($sortField === 'borrowed_at')
                                    {{ $sortDirection === 'asc' ? '▲' : '▼' }}
                                @else
                                    ▼▲
                                @endif
                            </th>
                            <th>返却予定日</th>
                            <th>返却日</th>
                            <th>ステータス</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($borrowings as $borrowing)
                            <tr>
                                <td>{{ $borrowing->user_id }}</td>
                                <td>{{ $borrowing->user->name }}</td>
                               
                                <td>{{ $borrowing->stock->management_id }}</td>
                               
                                <td>{{ $borrowing->borrowed_at->format('Y/m/d') }}</td>
                                <td>{{ $borrowing->borrowed_at->addDays($dbConfig->loan_period_days)->format('Y/m/d') }}</td>
                                <td>{{ $borrowing->returned_at ? $borrowing->returned_at->format('Y/m/d') : '-' }}</td>
                                <td>{{ $borrowing->stock->status_label }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

