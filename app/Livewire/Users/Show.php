<?php
//php artisan make:livewire Users.Show で作成(livewireコンポーネントのクラスファイルとビューファイルが作成される)
namespace App\Livewire\Users;

use Livewire\Component;
use App\Models\User;//ユーザモデルを使用するために追加
class Show extends Component
{
    public User $user;//入力欄はないが、ユーザー情報を表示するために必要

    public function mount(User $user) {//一覧画面のBladeより1件のユーザー情報が渡される。
        $this->user = $user;//プロパティを通じて、詳細画面のBladeに渡す。
    }

    public function destroy(){
        // ▼修正前 260225 
        // //削除する前に、貸出履歴が残っているか確認する。
        // $this->user->delete();
        // ▲修正前 260225

        // ▼修正後 260225 貸出履歴または評価データがある場合は削除を阻止する
        if ($this->user->borrowings()->exists() || $this->user->evaluations()->exists()) {
            session()->flash('error', '貸出履歴または評価データが存在するため、このユーザーを削除することはできません。');
            return;
        }
        $this->user->delete();
        // ▲修正後 260225

        return redirect()->route('users.index');//削除したら一覧画面に戻る。
    }
    
    public function render()
    {
        return view('livewire.users.show');
    }
}
