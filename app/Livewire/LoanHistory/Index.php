<?php

namespace App\Livewire\LoanHistory;

use Livewire\Component;
use App\Models\Borrowing;
use App\Models\Stock;
USE App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use App\Models\Config;

class Index extends Component
{
    use WithPagination;

    public $borrowedAtFrom;
    public $borrowedAtTo;
    public $status;
    public $sortTypeBorrowdDate = 'desc';
    public $searchKeyword = '';
    public function mount(){

        $this->borrowedAtFrom = now()->subMonth()->format('Y-m-d');//1ヶ月前(subMonthで引数を省略すると1を指定したことになる)。"yyyy-mm-dd"の形式にする。now()はカーボンのインスタンスを返す。
        $this->borrowedAtTo = now()->format('Y-m-d');//今日。"yyyy-mm-dd"の形式にする。
        $this->status = '';
    }

    public function toggleBorrowedDateSort(){
        $this->sortTypeBorrowdDate = $this->sortTypeBorrowdDate === 'desc' ? 'asc' : 'desc';  //昇順・降順を反転
    }
    public function filterByKeyword($query){
        if($this->searchKeyword){
            // 全角スペースを半角に変換し、空白文字で分割
            // 正規表現意味: \s(空白文字) +(1回以上の繰り返し) u(UTF-8モード)
            $keywords = preg_split('/\s+/u', mb_convert_kana($this->searchKeyword, 's'));

            foreach ($keywords as $keyword) {
                if (empty($keyword)) continue;

                // 各キーワードに対して、いずれかのカラムにヒットするかを確認(OR)
                // それをループで重ねることで全体としてAND検索になる。
                $query->where(function($q) use ($keyword) {
                    // 本の情報で検索
                    $q->whereHas('stock.book', function($book_q) use ($keyword) {
                        $book_q->where('title', 'like', '%' . $keyword . '%')
                        ->orWhere('author', 'like' , '%' . $keyword . '%')
                        ->orWhere('isbn', 'like', '%' . $keyword . '%')
                        ->orWhere('publisher', 'like', '%' . $keyword . '%');
                    })
                    // 在庫（管理ID）で検索
                    ->orWhereHas('stock', function($stock_q) use ($keyword) {
                        $stock_q->where('management_id', 'like', '%' . $keyword . '%');
                    })
                    // カテゴリ名で検索
                    ->orWhereHas('stock.book.category', function($cat_q) use ($keyword) {
                        $cat_q->where('category_name', 'like', '%' . $keyword . '%');
                    });
                });
            }
            
        }
        return $query;
    }
    
    public function render()
    {
        
        $query = Auth::user()->borrowings()->with(['stock.book.evaluations']);
        if($this->borrowedAtFrom){
            $query->where('borrowed_at', '>=', $this->borrowedAtFrom);//条件A
        }
        if($this->borrowedAtTo){
            $query->where('borrowed_at', '<=', $this->borrowedAtTo);//条件B
        }
        if($this->status){
            if ($this->status !== ''){
                $query->whereHas('stock', function($q){//borrowingsのリレーションstock()を使う。
                    $q->where('status',$this->status);//条件C
                });
            }
        }
        $query = $this->filterByKeyword($query);//条件A　AND　条件B　AND 条件C　AND 条件D（＝X OR Y OR Z）になる。
        $query->orderBy('borrowed_at',$this->sortTypeBorrowdDate);
        
        $dbConfig = Config::first();
        $limit = $dbConfig->pagination_count ?? 10;
        $borrowings = $query->paginate($limit);
        
        return view('livewire.loan-history.index', compact('borrowings'));
        
    }
}
/* 【備忘録：Eloquentでのグループ化（カッコ）の作り方】
* 
* 1. 実現したいSQL（論理構造）
*    WHERE borrowed_at >= '2026-01-15' -- 条件A
*      AND borrowed_at <= '2026-02-15' -- 条件B
*      AND status = 'borrowed'         -- 条件C
*      AND (                           -- 条件D（グループ化）
*          title LIKE '%キーワード%'     -- 条件X
*          OR author LIKE '%キーワード%' -- 条件Y
*          OR management_id LIKE ...    -- 条件Z
*      )
* 
* 2. Eloquent での表現
*    - 日付などの「かつ（AND）」で繋ぐ条件は、通常の where() を並べる。
*    - キーワード検索の「または（OR）」の塊は、where(function($q){ ... }) で包む。
*    - この function 始まりが SQLの「 ( 」、終わりが「 ) 」に相当する。
* 
* 3. リレーション先の検索
*    - 別のテーブル（booksやcategories）のカラムを探す場合は whereHas() を使用する。
*/
