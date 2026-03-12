<?php

namespace App\Livewire\Books;

use Livewire\Component;
use Livewire\WithPagination;

use App\Models\Book;
use App\Models\Stock;

use App\Models\Evaluation;

use Livewire\Attributes\Locked;

class Show extends Component
{

    use WithPagination;


    //表示する図書のデータ
    #[Locked]
    public Book $book;
    public $evaluation = 5; //初期値5
    public $comment;
    public $perPage = 'default';
    public string $search = '';
    public string $selectedRating = '';
    //▼ URLから渡された図書のIDを受け取って、自動でデータベースからデータを探してくる処理
    //パラメータ: $book : 検索された図書データがここに入る
    public function mount(Book $book)
    {
        $this->book = $book;
    }


    //図書の評価を登録する処理
    public function evaluate()
    {
        //入力チェック（評価点は1~5、コメントは任意）
        $this->validate([
            'evaluation' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        //データベースに保存（既存があれば更新、なければ新規作成）
        Evaluation::updateOrCreate(
            [
                'book_id' => $this->book->id,
                'user_id' => auth()->id(),
            ],
            [
                'rating' => $this->evaluation,
                'comment' => $this->comment,
            ]
        );

        //フォームを空にする
        $this->reset(['evaluation', 'comment']);

        //完了メッセージ
        session()->flash('status', '評価を保存しました。');
    }
    

    /**
     * ビューのレンダリング
     */
    public function render()
    {
        //DbConfigの設定
        $dbConfig = \App\Models\Config::first();
        $limit = $this->perPage === 'default' ? ($dbConfig->pagination_count ?? 10) : (int) $this->perPage;
       //この本のレビューのみ取得
        $query = Evaluation::with(['book', 'user'])
            ->where('book_id', $this->book->id);

        if (!empty($this->search)) {
            // 全角スペースを半角に変換し、空白文字で分割
            // 正規表現意味: \s(空白文字) +(1回以上の繰り返し) u(UTF-8モード)
            $keywords = preg_split('/\s+/u', mb_convert_kana($this->search, 's'));
            foreach ($keywords as $keyword) {
                if (empty($keyword)) continue;
                $query->where(function ($q) use ($keyword) {
                    $q->whereHas('user', fn($user_q) => $user_q->where('name', 'like', "%{$keyword}%"))
                      ->orWhere('comment', 'like', "%{$keyword}%");
                });
            }
            
        }

        $evaluations = $query
            ->when($this->selectedRating, fn($q) => $q->where('rating', '>=', $this->selectedRating))
            ->orderBy('created_at', 'desc')
            ->paginate($limit);

        return view('livewire.books.show', [
            'evaluations' => $evaluations,
            'defaultPaginationCount' => $dbConfig->pagination_count ?? 10,
        ]);
    }
}
