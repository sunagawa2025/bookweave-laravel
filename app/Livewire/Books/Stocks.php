<?php

namespace App\Livewire\Books;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Config;
use App\Models\Book;

class Stocks extends Component
{
    use WithPagination;
    public Book $book;
    public $search = '';

    public function mount(Book $book)
    {
        $this->book = $book;
    }

    public function render()
    {
        //在庫情報の取得と貸出可能数の計算
        // システム設定から表示件数を取得
        $dbConfig = Config::first();
        $perPage = $dbConfig->pagination_count ?? 10;

        // 貸出可能冊数を取得 (status: available)
        $availableCount = $this->book->stocks()
            ->where('status', 'available')
            ->count();

        // その本の在庫リストを取得 (廃棄済み以外)
        $stocks = $this->book->stocks()
            ->where('status', '!=', 'dispose')
            ->when($this->search, function($query) {
                $query->where('management_id', 'like', '%' . $this->search . '%');
            })
            ->orderBy('management_id', 'asc')
            ->paginate($perPage);
        

        return view('livewire.books.stocks', compact('stocks', 'availableCount'));
    }
}
