<?php

namespace App\Livewire\Evaluations;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Evaluation;
use App\Models\Category;
use App\Models\Config;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedRating = '';
    public $selectedCategory = '';
    public $perPage = 'default';


     public function mount()
    {
        // 初期値は 'default' のまま
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedRating()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Evaluation::with('book', 'user')->orderBy('created_at', 'desc');


        //キーワード検索
        if (!empty($this->search)) {
            // 全角スペースを半角に変換し、空白文字で分割
            // 正規表現意味: \s(空白文字) +(1回以上の繰り返し) u(UTF-8モード)
            $keywords = preg_split('/\s+/u', mb_convert_kana($this->search, 's'));

            foreach ($keywords as $keyword) {
                if (empty($keyword)) continue;

                $query->where(function($q) use ($keyword) {
                    $q->whereHas('book', function($book_q) use ($keyword) {
                        $book_q->where('title', 'like', '%' . $keyword . '%');
                    })
                    ->orWhereHas('user', function($user_q) use ($keyword) {
                        $user_q->where('name', 'like', '%' . $keyword . '%');
                    })
                    ->orWhere('comment', 'like', '%' . $keyword . '%');
                });
            }
        }

        //カテゴリー検索
         if(!empty($this->selectedCategory))
            {
                $query->whereHas('book',function($q){
                    $q->where('category_id',$this->selectedCategory);
                });
            }


        //評価検索
        if(!empty($this->selectedRating))
            {
                 $query -> where('rating',$this->selectedRating);
            };
            
            // DBからシステム設定を取得
            $dbConfig = Config::first();
            
            // 'default' が選ばれていればConfigの件数を、それ以外なら選択された数字を使用
            $limit = $this->perPage === 'default' ? ($dbConfig->pagination_count ?? 10) : (int) $this->perPage;
            $evaluations = $query->paginate($limit);
            
            
    $categories = Category::all();
    //returnで渡してるのでないとエラーになるので書いておく。

        return view('livewire.evaluations.index', [
            'evaluations' => $evaluations,
            'categories' => $categories,
            'defaultPaginationCount' => $dbConfig->pagination_count ?? 10,
        ]);
    }
}
