<?php

namespace App\Livewire\Loan;

use App\Models\Borrowing;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Config;
use Illuminate\Support\Facades\Log;
use App\Mail\LoanReminderMailableEx;
use App\Services\MailConfigEx;
use App\Services\MailNotificationEx;


class Overdue extends Component
{
    use WithPagination;

    public $perPage = 'default';

    //管理ID検索用
    public $searchManagementId = '';

    //貸出日ソート用
    public $sortField = 'borrowed_at';
    public $sortDirection = 'asc';

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

    // データベースから共通設定情報を取得
    public function mount()
    {
        $this->dbConfig = Config::first();
    }

    // updatedPerPageはライフサイクルフック（プロパティが変わった直後に呼ばれる）
    // 表示件数を変えたら、ページ番号を1に戻す
    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    //管理ID検索（入力時にページリセット）
    public function updatedSearchManagementId()
    {
        $this->resetPage();
    }

    public function render()
    {
      
        $limit = $this->perPage === 'default' ? ($this->dbConfig->pagination_count ?? 10) : (int) $this->perPage;
        //貸出日の古い順（昇順）に並べ替え
        $query = Borrowing::whereNull('returned_at')
            ->whereHas('stock', function ($q) 
            { $q->where('status', 'borrowed');})
            ->where('borrowed_at', '<', now()->subDays($this->dbConfig->loan_period_days));

        //管理ID検索
        if (! empty($this->searchManagementId)) {
            $query->whereHas('stock', function ($q) {
                $q->where('management_id', 'like', '%' . $this->searchManagementId . '%');
            });
        }
        
        $overdueLoans = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($limit);
        
        return view('livewire.loan.overdue', [
    'overdueLoans' => $overdueLoans,
    'dbConfig' => $this->dbConfig,
]);
    }

    public function sendReminderMail()
    {
        
        $this->executeSendMail();
        
        session()->flash('message', 'メール送信処理を実行しました');
                             
    }

    
    private function executeSendMail()
    {
        if (!$this->dbConfig) {
            \Log::error("メール設定が見つかりません。configsテーブルを確認してください。");
            return;
        }

        $mailConfigObj = new MailConfigEx(//メール共通設定データ保持クラス
            $this->dbConfig->mail_host ?? '',       // host
            $this->dbConfig->mail_port ?? 587,      // port
            $this->dbConfig->mail_username ?? '',   // username
            $this->dbConfig->mail_password ?? '',   // password
            $this->dbConfig->mail_encryption ?? 'tls', // encryption
            $this->dbConfig->mail_from_address ?? '',  // from address
            $this->dbConfig->mail_from_name ?? ''      // from name
        );
        

        $mailNotificationObj = new MailNotificationEx($mailConfigObj);//共通設定データ保持クラスを渡して、メール送信クラスを作成。

        // 2. 未返却（延滞など）のデータを取得する
        $overdueLoans = Borrowing::with(['user', 'stock.book'])
            ->whereNull('returned_at')
            ->whereHas('stock', function ($q) { $q->where('status', 'borrowed');})
            ->where('borrowed_at', '<', now()->subDays($this->dbConfig->loan_period_days))
            ->where('send_mail_check', 0)
            ->get();
        

        // 3. ループで一人ずつ順番にメールを送る！
        // 件名とテンプレートは全員共通
        $subject  = "図書返却のお願い";
        $viewPath = 'emails.mail_template';
        
        //ユーザーごとにグループ化して1通にまとめて送信
        $groupedLoans = $overdueLoans->groupBy('user_id');

        foreach ($groupedLoans as $userId => $userLoans) {
            $firstLoan = $userLoans->first();
            $user_name = $firstLoan->user->name;
            $toAddress = $firstLoan->user->email;

            // そのユーザーの全延滞本リストを作成
            $loansData = $userLoans->map(function ($loan) {
                return [
                    'book_title' => $loan->stock->book->title,
                    'due_date'   => $loan->borrowed_at->addDays($this->dbConfig->loan_period_days)->format('Y/m/d'),
                ];
            })->toArray();

            $mailData = [
                'user_name' => $user_name,
                'loans'     => $loansData,
            ];

            // Mailableクラスの作成
            $mailable = new LoanReminderMailableEx(
                $subject,   // 件名 (共通)
                $viewPath,  // テンプレート (共通)
                $mailData   // データ (今回からリスト形式)
            );

            // 送信実行
            $success = $mailNotificationObj->send($toAddress, $mailable);

            if ($success) {
                Log::info("督促メールを送信しました。宛先: {$user_name} (対象: " . count($loansData) . "冊)");

                // 送信に成功したユーザーが持つ、今回の全延滞レコードのフラグを一括更新
                Borrowing::whereIn('id', $userLoans->pluck('id'))
                    ->update(['send_mail_check' => 1]);
            }
        }
    }
}
