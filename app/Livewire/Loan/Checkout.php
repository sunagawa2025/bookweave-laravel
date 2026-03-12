<?php
//貸出処理//
namespace App\Livewire\Loan;

use Livewire\Component;
use App\Models\Borrowing;
use App\Models\Stock;
use App\Models\Config;


class Checkout extends Component
{
    public $management_id;
    public $book_title; //表示用本のタイトル
    public $user_id; 
    public $user_name; //表示用ユーザー名
    public $borrowed_at; 
    public $returned_at;
 
    /**
     * 管理IDが入力された瞬間に本の情報を取得する
     */
    public function updatedManagementId($value)
    {
        $cleanId = trim(mb_convert_kana($value, 's'));
        if (empty($cleanId)) {
            $this->book_title = '';
            return;
        }

        $stock = \App\Models\Stock::where('management_id', $cleanId)->with('book')->first();
        $this->book_title = $stock ? $stock->book->title : '存在しない管理IDです';
    }
 
    /**
     * ユーザーIDが入力された瞬間に名前を取得する
     */
    public function updatedUserId($value)
    {
        // スペース除去
        $cleanId = trim(mb_convert_kana($value, 's'));
        
        if (empty($cleanId)) {
            $this->user_name = '';
            return;
        }

        $user = \App\Models\User::find($cleanId);
        $this->user_name = $user ? $user->name : '存在しないユーザーです';
    }
 

    public function save(){
        //前後のスペース（全角含む）を除去
        $this->management_id = trim(mb_convert_kana($this->management_id, 's'));
        $this->user_id = trim(mb_convert_kana($this->user_id, 's'));

        //バリデーション
        $validated = $this -> validate([
        'user_id'  => 'required|exists:users,id',
        'management_id' => 'required|exists:stocks,management_id',
     ],
    [
        'user_id.exists'  => '入力された ユーザーID は存在しません',
        'management_id.exists' => '入力された 管理ID は存在しません',
    ]);
    
    //貸し出せる在庫があるか確認とエラーメッセージ
    $stock = Stock::where('management_id', $validated['management_id'])->firstOrFail();
   
    if($stock->status !== 'available'){
        $this->addError('management_id','この在庫は現在貸出できない状態（貸出中、または廃棄済み等）です。');
        return;
    }
    
    //ユーザーが貸出上限数に達しているか確認とエラーメッセージ
    $userBorrowingsCount = Borrowing::where('user_id',$validated['user_id'])
                            ->whereHas('stock', function ($q) 
                                { $q->where('status', 'borrowed');})
                            ->count();

    $dbConfig = Config::first();

    if($userBorrowingsCount >= $dbConfig->max_loan_count){
        $this->addError('user_id','このユーザーは貸出冊数上限を超えるため、貸出できません。');
        return;
    }

       
    //Borrowingsテーブル新規作成　貸出受付処理

    Borrowing::create([
        'stock_id'    => $stock->id,
        'user_id'     => $validated['user_id'],
         'borrowed_at' => now(),
    ]);
        //Stockテーブルのstatusを貸出中に更新
        $stock->update([
            'status'=>'borrowed'
        ]);
        
        //貸出完了メッセージを出して、一覧画面に戻る
        session()->flash('message', '貸出を受付ました。');//1回だけ表示するメッセージ
        

        return redirect()->route('loan.status');

    }


    public function render()
    {
        return view('livewire.loan.checkout');
    }

    

}
