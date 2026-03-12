<?php

namespace App\Livewire\Books;

use Livewire\Component;
use App\Models\Book;
use App\Models\Category;
use Livewire\WithFileUploads; // ▼追加 260222 ファイルアップロード用

class Edit extends Component
{
    use WithFileUploads; // ▼追加 260222
    //編集対象の図書データ
    public Book $book;

    //フォーム用変数
    public $title;
    public $author;
    public $isbn;
    public $category_id;
    public $publisher;
    public $image;      //画像本体が入る箱
    public $image_path; //登録ファイル名（※画面のエディットボックスに表示される名前）

    /**
     * 初期化処理
     */
    public function mount(Book $book)
    {
        $this->book = $book;
        $this->title = $book->title;
        $this->author = $book->author;
        $this->isbn = $book->isbn;
        $this->category_id = $book->category_id;
        $this->publisher = $book->publisher;
        // ファイル名のみを抽出して表示・編集用にする
        $rawPath = $book->getRawOriginal('image_path');
        $this->image_path = $rawPath ? basename($rawPath) : ""; 
    }

    /**
     * 画像が選択された時の処理（即時にエディットボックスへ反映）
     */
    public function updatedImage()
    {
        $this->validate(['image' => 'nullable|image|max:1024']);
        if ($this->image) {
            // エディットボックス（image_path）にファイル名を反映させる
            $this->image_path = $this->image->getClientOriginalName();
        }
    }

    /**
     * 更新処理（最後にまとめて確定）
     */
    public function update()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'publisher' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:1024', 
        ]);

        // 保存直前にフォルダパスを結合する
        $dbPath = $this->image_path ? "images/books/" . ltrim($this->image_path, '/') : null;

        // もし新しい画像本体があれば保存
        if ($this->image) {
            // ▼修正前 260222
            // $this->image->storeAs('images/books', $this->image_path, 'public');
            // ▲修正前 260222

            // ▼修正後 260225 チーム開発(Git共有)優先のためpublic直下に直接保存する
            $this->image->move(public_path('images/books'), $this->image_path);
            // ▲修正後 260225
        }

        $this->book->update([
            'title' => $this->title,
            'author' => $this->author,
            'category_id' => $this->category_id,
            'publisher' => $this->publisher,
            'image_path' => $dbPath,
        ]);

        session()->flash('message', '図書情報を更新しました。');
        return $this->redirectRoute('books.index', navigate: true);
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.books.edit', compact('categories'));
    }
}
