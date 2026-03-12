<?php

namespace App\Livewire\Evaluations;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Evaluation;
use App\Models\Category;
use App\Models\Config;
use Illuminate\Support\Facades\DB;

class Ranking extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategory = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::all();//全カテゴリ追加
        $query = Evaluation::query()
        //book_id(ISBNと紐づく)ごとの平均評価点とレビュー件数を取得
        ->select('book_id', DB::raw('AVG(rating) as avg_rating'), DB::raw('COUNT(*) as count'))
        ->with('book.category')//Eager Loading
        ->groupBy('book_id')
        ->orderBy('avg_rating', 'desc');//あとで切り替えボタン付けるか検討中(低評価から見ても意味ないから不要かも)
        //検索・カテゴリの絞り込みとページネーション(10件)を適用
        if ($this->search) {
            // 全角スペースを半角に変換し、空白文字で分割
            // 正規表現意味: \s(空白文字) +(1回以上の繰り返し) u(UTF-8モード)
            $keywords = preg_split('/\s+/u', mb_convert_kana($this->search, 's'));
            foreach ($keywords as $keyword) {
                if (empty($keyword)) continue;
                $query->whereHas('book', function($q) use ($keyword) {
                    $q->where('title', 'like', '%' . $keyword . '%');
                });
            }
        }

        if ($this->selectedCategory){
            $query->whereHas('book', function($q){
                $q->where('category_id', $this->selectedCategory);
            });
        }

        $dbConfig = Config::first();
        $limit = $dbConfig->pagination_count ?? 10;
        $rankings = $query->paginate($limit);

        return view('livewire.evaluations.ranking', [
            'rankings' => $rankings,
            'categories' => $categories,
        ]);
    }
}
