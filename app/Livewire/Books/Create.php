<?php
//php artisan make:livewire Books.Create で作成(livewireコンポーネントのクラスファイルとビューファイルが作成される)
namespace App\Livewire\Books;

use Livewire\Component;
use Illuminate\Support\Facades\DB;//トランザクションを使うために追加
use Illuminate\Support\Str;
use App\models\Book;
use App\models\Stock;
use App\Models\Category;
use Livewire\WithFileUploads; //ファイルアップロード用

class Create extends Component
{
    use WithFileUploads;

    //入力フォームの値を格納する変数
    public $isbn;       //ISBN (13桁)
    public $title;      //タイトル
    public $author;     //著者
    public $category_id; //分類（任意）
    public $publisher;  //出版社（任意）
    public $image;      //画像本体が入る箱 
    public $image_path; //保存先のパス（ファイル名）
    public $stock_count;  //（冊数）在庫数
    
    //▼ 登録ボタンが押されたときの処理
    public function save()
    {
        //1. 入力内容が正しいかチェック
        $validated = $this->validate([
            'isbn' => 'required|digits:13',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'publisher'=> 'nullable|string|max:255',
            'stock_count'=> 'required|integer|min:0',
        ]);

        //データベース操作を一括で行う
        DB::transaction(function () use ($validated) {
            
            //2. 図書マスター (books) を登録または更新する
            // 既存のISBNがあれば情報を最新に更新（画像追加など）、なければ新規作成する。
            // ※在庫0冊での先行登録や、後からの情報補完を可能にするため updateOrCreate を使用。
            $book = Book::updateOrCreate(['isbn' =>$validated['isbn']], [
                        'title' => $this->title, 
                        'author'=> $this->author,
                        'category_id'=>$this->category_id,
                        'publisher' => $this->publisher,
                        'image_path' => $this->image_path // uploadImageでセットされたパスを使う
                    ]);

            //3. 在庫 (stocks) データを追加
            for ($i = 0; $i < $validated['stock_count']; $i++){
                Stock::create([
                    'management_id' => $this->generateManagementId(),
                    'book_id' => $book->id,
                    'status' => 'available',
                ]);
            }
        });
        
        session()->flash('message', '図書を登録・更新しました。');
        return redirect()->route('books.index');
    }

    /**
     * 【即時アップロード】画像が選択された瞬間に実保存とDB準備を行う
     */
    public function updatedImage()
    {
        $this->validate([
            'image' => 'nullable|image|max:1024',
        ]);

        if ($this->image) {
            // ▼チーム開発(Git共有)優先のためpublic直下に直接保存する
            $this->image->move(public_path('images/books'), $filename);
            
            // DB保存用のパスをセット
            $this->image_path = "images/books/" . $filename;

            session()->flash('message', '画像をアップロード・保存しました。');
        }
    }

    public function render()
    {
        $categories = Category::all();
        return view('livewire.books.create', compact('categories'));
    }

    /***新しい管理IDを発行する*/
    private function generateManagementId(): string
    {
        $latestId = Stock::where('management_id', 'like', 'M-%')->max('management_id');
        if ($latestId) {
            $number = (int) substr($latestId, 2);
            $nextNumber = $number + 1;
        } else {
            $nextNumber = 1;
        }
        return 'M-' . str_pad((string)$nextNumber, 7, '0', STR_PAD_LEFT);
    }
}
