<?php
//返却処理//
namespace App\Livewire\Loan;

use App\Models\Borrowing;
use App\Models\Stock;
use Livewire\Component;

// 本の管理IDを受け取って、Stocksテーブルのstatusをavailable(貸出可)に更新、
// Borrowingsテーブルの返却日に今日の日付をいれる。
class Checkin extends Component
{
    public $management_id;
    public $book_title; //表示用本のタイトル

    //管理IDが入力された瞬間に本の情報を取得する
    public function updatedManagementId($value)
    {
        $cleanId = trim(mb_convert_kana($value, 's'));
        if (empty($cleanId)) {
            $this->book_title = '';
            return;
        }

        $stock = Stock::where('management_id', $cleanId)->with('book')->first();
        $this->book_title = $stock ? $stock->book->title : '存在しない管理IDです';
    }

    public function update()
    {
        //前後のスペース（全角含む）を除去
        $this->management_id = trim(mb_convert_kana($this->management_id, 's'));

        // バリデーション
        $this->validate(
            ['management_id' => 'required|exists:stocks,management_id'],
            ['management_id.exists' => '入力された 管理ID は存在しません']
        );

        // stockテーブル更新のためDBレコード取得
        $stock = Stock::where('management_id', $this->management_id)->firstOrFail();

        // Borrowingsテーブルの返却日に今日の日付をいれるため、DBレコード取得
        $borrowing = Borrowing::where('stock_id', $stock->id)
            ->whereNull('returned_at')
            ->whereHas('stock', function ($q) 
                    { $q->where('status', 'borrowed');})
            ->first();

        //更新作業　返却日とステータス更新
        if (! $borrowing) {
            $this->addError('management_id', 'この本は貸出中ではありません');
            return;
        }

        //更新作業　返却日とステータス更新
        $borrowing->update([
            'returned_at' => now(),
        ]);

        $stock->update([
            'status' => 'available',
        ]);

        $this->reset('management_id');
        session()->flash('message', '返却を受付ました。');//1回だけ表示するメッセージ
    }

    //在庫を廃棄状態(disposed)にする処理
    public function dispose()
    {
        //前後のスペース（全角含む）を除去
        $this->management_id = trim(mb_convert_kana($this->management_id, 's'));

        //バリデーション
        $this->validate(
            ['management_id' => 'required|exists:stocks,management_id'],
            ['management_id.exists' => '入力された 管理ID は存在しません']
        );

        $stock = Stock::where('management_id', $this->management_id)->first();

        //もし貸出中であれば、返却処理（履歴のクローズ）も同時に行う
        $borrowing = Borrowing::where('stock_id', $stock->id)
            ->whereNull('returned_at')
            ->first();

        if ($borrowing) {
            $borrowing->update([
                'returned_at' => now(),
            ]);
        }

        //在庫の状態を廃棄済みに更新
        $stock->update([
            'status' => 'disposed',
        ]);

        $this->reset('management_id');
        session()->flash('message', '在庫を廃棄処分しました。');
    }

    public function render()
    {
        return view('livewire.loan.checkin');
    }
}
