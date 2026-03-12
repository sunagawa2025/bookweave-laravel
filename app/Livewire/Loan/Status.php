<?php
//貸出一覧・検索//
namespace App\Livewire\Loan;

use App\Models\Borrowing;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Config;

class Status extends Component
{
    use WithPagination;

    public $perPage = 'default';

    public $borrowedAtFrom;
    public $borrowedAtTo;
    public $status = '';

    //管理ID検索用
    public $searchManagementId = '';
    //貸出日ソート用
    public $sortField = 'borrowed_at';
    public $sortDirection = 'desc';

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }
    
    public $dbConfig;

    public function mount()
    {
        $this->borrowedAtFrom = now()->subMonthsNoOverflow(1)->format('Y-m-d'); // デフォルトを本日から1か月前にする。
        $this->borrowedAtTo = now()->format('Y-m-d');
        // デフォルトを本日にする。

        $this->dbConfig = Config::first();
    }

    // updatedPerPageはライフサイクルフック（プロパティが変わった直後に呼ばれる）
    // 表示件数を変えたら、ページ番号を1に戻す
    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    // 絞込条件を変えたら、ページ番号を1に戻す
    public function updatedBorrowedAtFrom()
    {
        $this->resetPage();
    }

    public function updatedBorrowedAtTo()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedSearchManagementId()
    {
        $this->resetPage();
    }


    public function render()
    {
        // 全件表示
        $query = Borrowing::with('user', 'stock')->orderBy($this->sortField, $this->sortDirection);
        
        //管理ID検索
        if (! empty($this->searchManagementId)) {
            $query->whereHas('stock', function ($q) {
                $q->where('management_id', 'like', '%' . $this->searchManagementId . '%');
            });
        }


         // stockテーブルのstatusのdisposed を除外（available, borrowed だけ表示）
        $query->whereHas('stock', function ($q) {
            $q->whereIn('status', ['available', 'borrowed']);
        });
        
        // 期間指定表示：貸出開始日指定のみ
        if (! empty($this->borrowedAtFrom)) {
            $from = $this->borrowedAtFrom.' 00:00:00';
            $query->where('borrowed_at', '>=', $from);
        }

        // 期間指定表示：貸出終了日指定のみ
        if (! empty($this->borrowedAtTo)) {
            $to = $this->borrowedAtTo.' 23:59:59';
            $query->where('borrowed_at', '<=', $to);
        }

        // ステータス指定表示 borrowingのデータに紐づいたstockテーブルのstatusで抽出。
        if ($this->status !== '') {
            $query->whereHas('stock', function ($q) {
                $q->where('status', $this->status);
            });
        }

        $limit = $this->perPage === 'default' ? ($this->dbConfig->pagination_count ?? 10) : (int) $this->perPage;
        $borrowings = $query->paginate($limit);

        return view('livewire.loan.status',
            [
                'borrowings' => $borrowings,
                'dbConfig' => $this->dbConfig,
            ]);
    }
}
