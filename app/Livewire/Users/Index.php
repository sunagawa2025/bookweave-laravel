<?php
//php artisan make:livewire Users.Index で作成(livewireコンポーネントのクラスファイルとビューファイルが作成される)
namespace App\Livewire\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;//追加
use App\Models\Config;

class Index extends Component
{
    use WithPagination;
    //詳細画面への移動は<a href="...">で実装するためここには不要。(移動の際、特別な処理をしないため)

    // ▼修正前 260214
    // public $users; // これを宣言してviewの第二引数を省略するのは分かりにくいため禁止（コメントアウト）
    // ▲修正前 260214

    public function render()
    {
        \Log::info('Livewire Index render method called');
        // ▼修正前 260221
        // $users = User::all();
        // ▲修正前 260221
        // ▼修正後 260221
        $dbConfig = Config::first();
        $limit = $dbConfig->pagination_count ?? 10;
        $users = User::paginate($limit);
        // ▲修正後 260221

        // ▼修正前 260214
        // $this->users = $users; 
        // return view('livewire.users.index'); // これを宣言してviewの第二引数を省略するのは分かりにくいため禁止（コメントアウト）
        // ▲修正前 260214

        // ▼修正後(明示的) 260214 
        // 自動受け渡しに頼らず、引数で明示的にデータを渡す
        return view('livewire.users.index', compact('users'));
        // ▲修正後 260214
    }
}