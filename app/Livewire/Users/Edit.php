<?php
//php artisan make:livewire Users.Edit で作成(livewireコンポーネントのクラスファイルとビューファイルが作成される)   
namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;//Userモデルを使用するため
use Illuminate\Support\Facades\Hash;//パスワードをハッシュ化するために必要

class Edit extends Component
{
    public User $user;//ユーザー情報を受け取るためのプロパティ

    //フォーム用プロパティ(画面遷移図の入力を参考に)
    //更新ボタン押下時にフォーム入力の値がこの変数に反映される。
    public $name;
    public $email;
    public $password;
    public $role;
    public $address;
    public $phone_number;

    public function mount(User $user){//Bladeから渡ってきたユーザ情報(1件)を取得
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
        $this->address = $user->address;
        $this->phone_number = $user->phone_number;
        //パスワードは空のままにしておく(セキュリティのため)
        //ここにpaswordの反映処理をかかなければ画面には反映されない。つまり
        //渡ってきたデータをプロパティ(wireで連結しているので=画面)に反映しないが、フォーム入力はプロパティに反映させる。
       
    }

    public function update(){
        //dd("ID: {$this->user->id})を更新します");
        $validated = $this->validate([
            'name' => 'required|string|max:255',//※バリデーションはスペースを入れないで書く。
            //unique:テーブル名,カラム名で～テーブルの～列がユニークという意味。
            //第三引数で更新対象のレコードをユニークの条件から除外する。
            //(第三引数なのでemailの後に,が必要。指定するのは、その項目のデータではなく主キーのデータ)
            'email'=> 'required|email|unique:users,email,' . $this->user->id,
            'password' =>'nullable|min:8',//null可能だが、nullでないときは8文字以上という意味。
            'role'=> 'required',
            'address'=>'required',
            'phone_number'=>'required',
            
        ]);
        if ($this->password){//入力フォーム（画面）に新しいパスワードが打ち込まれていれば、入力されたパスワードをセットする。
            $validated['password']=Hash::make($validated['password']);//Hash::make()の代わりに、bcrypt()でも動く。
        }
        else{
            unset($validated['password']);//パスワードが空の場合は、更新対象から除外する。(でないと、現在のパスワードが空になってしまう)
        }
        //特定の誰かのデータを更新する場合は、インスタントメソッドを呼ぶ。(User::update()ではない）
        $this->user->update($validated);
        return redirect()->route('users.index');//更新後、一覧画面に遷移する。
    }
    public function render()
    {
        return view('livewire.users.edit');
    }
}
