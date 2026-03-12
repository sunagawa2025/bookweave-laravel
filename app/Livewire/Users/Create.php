<?php
//php artisan make:livewire Users.Create で作成(livewireコンポーネントのクラスファイルとビューファイルが作成される)
namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User; //モデルを追加
use Illuminate\Support\Facades\Hash; //ハッシュを使う為

class Create extends Component
{
    //画面とやり取りしたいデータはpublicで定義する(変数名はカラム名と合わせておく方が分かりやすい)
    public $name;
    public $email;
    public $password;
    public $role;
    public $address;
    public $phone_number;


    //ユーザー登録画面の登録ボタンクリック時に呼ばれる。（[画面遷移図]参照)
    //コントローラではstoreが主流だがlivewireではsaveがよく使われる。
    //別に名前なのでbladeの<form wire:submit="～">と合わせておけば、どっちでも動く。
    //create.blade.phpの登録ボタンクリック時に入力フォームに設定された値がプロパティに入った状態でこのメソッドの処理に来る。
    public function save(){
        //このvalidateメソッドはComponentクラスから継承したメソッドなので、$this->validateで呼び出す。
        $validated = $this->validate([
            'name' => 'required|string|max:255',//※バリデーションはスペースを入れないで書く。
            'email'=> 'required|email|unique:users,email',//unique:テーブル名,カラム名で～テーブルの～列がユニークという意味。
            'password'=> 'required|min:8',
            'role'=> 'required',
            'address'=>'required',
            'phone_number'=>'required',
        ]);
        $validated['password']=Hash::make($validated['password']);//Hash::make()の代わりに、bcrypt()でも動く。
        User::create($validated);
        return redirect()->route('users.index');//一覧画面にもどる。これはRouteの->name('')でつけた名前。
    }
    //毎回呼ばれる
    //ここで最新のプロパティを使ってBladeテンプレートを再描画する
    public function render()
    {
        return view('livewire.users.create');
    }
}
