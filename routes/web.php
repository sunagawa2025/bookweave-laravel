<?php

use Illuminate\Support\Facades\Route;
//
use App\Livewire\Top;

//ユーザー
use App\Livewire\Users\Index as UserIndex; //追加
use App\Livewire\Users\Create as UserCreate; //追加
use App\Livewire\Users\Edit as UserEdit; //追加
use App\Livewire\Users\Show as UserShow; //追加
//図書
use App\Livewire\Books\Index as BookIndex; //追加
use App\Livewire\Books\Create as BookCreate; //追加
use App\Livewire\Books\Show as BookShow; //追加
use App\Livewire\Books\Edit as BookEdit; //追加
use App\Livewire\Books\Stocks as BookStocks; //追加 
//貸出
use App\Livewire\Loan\Checkout;
use App\Livewire\Loan\Checkin;
use App\Livewire\Loan\Status;
use App\Livewire\Loan\Overdue;
//利用者履歴
use App\Livewire\LoanHistory\Index as LoanHistoryIndex;
//カテゴリーマスタ
use App\Livewire\Categories\Index as CategoryIndex;
use App\Livewire\Categories\Create as CategoryCreate;
use App\Livewire\Categories\Edit as CategoryEdit;

//設定
use App\Livewire\Configs\Index as ConfigIndex;
use App\Livewire\Configs\Edit as ConfigEdit;



Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/top', Top::class)->name('top');

    // === 👇 一般利用者・管理者 共通ルート ===
    // 図書ルート (一覧は誰でも可能)
    Route::get('/books', BookIndex::class)->name('books.index');
    
    // 利用者履歴
    Route::get('/loan-history', LoanHistoryIndex::class)->name('loan-history.index');
    
    // 評価・ランキング
    Route::get('/evaluations', \App\Livewire\Evaluations\Index::class)->name('evaluations.index');
    Route::get('/evaluations/ranking', \App\Livewire\Evaluations\Ranking::class)->name('evaluations.ranking');
    

    // === 👇 管理者専用ルート ===
    
    Route::middleware('can:admin')->group(function () {
        // ユーザー管理
        Route::get('/users', UserIndex::class)->name('users.index');
        Route::get('/users/create', UserCreate::class)->name('users.create');
        Route::get('/users/{user}', UserShow::class)->name('users.show');
        Route::get('users/{user}/edit', UserEdit::class)->name('users.edit');
        
        // 図書登録・編集 (※個別についていた can:admin はここで括られるため不要だが、安全のためそのまま)
        Route::get('/books/create', BookCreate::class)->name('books.create');
        Route::get('books/{book}/edit', BookEdit::class)->name('books.edit');

        // 貸出管理関連
        Route::get('/loan/status', Status::class)->name('loan.status');
        Route::get('/loan/overdue', Overdue::class)->name('loan.overdue');
        Route::get('/loan/checkout', Checkout::class)->name('loan.checkout');
        Route::get('/loan/checkin', Checkin::class)->name('loan.checkin');

        // カテゴリーマスタ
        Route::get('/categories', CategoryIndex::class)->name('categories.index');
        Route::get('/categories/create', CategoryCreate::class)->name('categories.create');
        Route::get('/categories/{category}/edit', CategoryEdit::class)->name('categories.edit');
        
        // システム設定
        Route::get('/configs', ConfigIndex::class)->name('configs.index');
        Route::get('/configs/{config}/edit', ConfigEdit::class)->name('configs.edit');
    });
    

    // 図書詳細・在庫 (ワイルドカードを含むため、固定パスのルートより後に定義)
    Route::get('/books/{book}', BookShow::class)->name('books.show');
    Route::get('/books/{book}/stocks', BookStocks::class)->name('books.stocks'); // 追加 260223
    

});

Route::get('/', function () {
    if (Auth::check()) { //ログインしてたらTop画面へ
        return redirect()->route('top');
    }
    //ランディングページ不要のため直接/loginへ
    return redirect()->route('login');
    
})->name('home');

//クイズ
Route::view('/games/quiz', 'games.quiz')->name('games.quiz');
require __DIR__ . '/settings.php';
