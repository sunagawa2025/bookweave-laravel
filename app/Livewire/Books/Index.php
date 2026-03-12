<?php

namespace App\Livewire\Books;

use Livewire\Component;
use App\Models\Book; 

use Livewire\WithPagination; // ページネーション
use App\Models\Config;

class Index extends Component
{
    use WithPagination;

    //検索ワードを格納する変数 (Bladeの入力欄とつながる)
    public $search = '';

    //検索ワードが更新されたらページを1に戻す
    public function updatedSearch()
    {
        $this->resetPage();
    }

    
    public function delete($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        
        session()->flash('message', '図書を削除しました。');
    }




    public function render()
    {
        // 検索クエリの作成
        $query = Book::query();

        $query = Book::with('category')
            ->withAvg('evaluations', 'rating');

        // 検索ワードがあれば絞り込み（タイトルで検索する例）
        if (!empty($this->search)) {
            // ▼複数キーワードでのAND検索に対応
            // 全角スペースを半角に変換し、空白文字で分割
            // 正規表現意味: \s(空白文字) +(1回以上の繰り返し) u(UTF-8モード)
            $keywords = preg_split('/\s+/u', mb_convert_kana($this->search, 's'));

            foreach ($keywords as $keyword) {
                if (empty($keyword)) continue;

                $query->where(function($q) use ($keyword) {
                    $q->where('title', 'like', '%' . $keyword . '%')
                      ->orWhere('isbn', 'like', '%' . $keyword . '%')
                      ->orWhere('publisher', 'like', '%' . $keyword . '%')
                      ->orWhereHas('category', function($q_cat) use ($keyword) {
                          $q_cat->where('category_name', 'like', '%' . $keyword . '%');
                      })
                      ->orWhere('author', 'like', '%' . $keyword . '%');
                });
            }
            
        }

        $dbConfig = Config::first();
        $limit = $dbConfig->pagination_count ?? 10;
        $books = $query->latest()->paginate($limit);
   
        return view('livewire.books.index', [
            'books' => $books
        ]);
    }
}
