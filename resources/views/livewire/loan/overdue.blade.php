<div class="p-loan-overdue">
    @if (session('message'))
        <div class="alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="page-container bg-page">
        <h2 class="page-title">
            督促管理
        </h2>
        
        <div class="content-area">
            {{-- フィルタエリア --}}
            <div class="filter-area">
                <div class="filter-group flex flex-row items-center gap-2">
                    <label class="filter-label !mb-0">表示件数</label>
                    {{-- ※ クラス（Overdue.php）の render 内、return view() の引数で明示的に渡されたシステム設定値($dbConfig)を表示 --}}
                    <select wire:model.live="perPage" class="filter-input !p-1">
                        <option value="default">デフォルト（システム設定：{{ $dbConfig->pagination_count ?? 10 }}件）</option>
                        <option value="10">10件</option>
                        <option value="20">20件</option>
                        <option value="50">50件</option>
                    </select>
                    
                </div>
                {{--管理ID検索（ラベル削除、リアルタイム検索） --}}
                <div class="filter-group flex flex-row items-center gap-2">
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="searchManagementId" 
                        class="filter-input !p-1" 
                        placeholder="管理IDを入力..."
                    >
                </div>
                
                {{-- アクションエリア --}}
                <div class="flex items-end">
                    <button wire:click="sendReminderMail" class="btn-action">
                        督促メール一括送信
                    </button>
                </div>
            </div>

            

            <div class="table-wrapper">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>氏名</th>
                            
                            <th class="searchable-th">管理ID</th>
                            
                            <th>貸出図書</th>
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
                            <th>督促メール</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($overdueLoans as $loan)
                            <tr>
                                <td>{{ $loan->user_id }}</td>
                                <td class="col-name">{{ $loan->user->name }}</td>
                               
                                <td>{{ $loan->stock->management_id }}</td>
                                
                                <td class="col-book">{{ $loan->stock->book->title }}</td>
                                <td>{{ $loan->borrowed_at->format('Y/m/d') }}</td>
                                <td>{{ $loan->borrowed_at->addDays(14)->format('Y/m/d') }}</td>
                                <td>{{ $loan->returned_at ? $loan->returned_at->format('Y/m/d') : '-' }}</td>
                                <td>{{ $loan->send_mail_check_label}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


