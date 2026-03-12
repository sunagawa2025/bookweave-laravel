<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>クイズゲーム</title>
    {{-- 共通CSS読み込み --}}
    @vite(['resources/css/app.css', 'resources/css/games/quiz.css'])

    @php
        $quizId = request()->query('id');
        // 許可されたクイズIDリスト (ファイルが存在するもの)
        $availableQuizzes = [
            '1' => '男塾検定',
            '2' => 'NARUTO検定',
        ];
    @endphp

    @if($quizId && array_key_exists($quizId, $availableQuizzes))
        {{-- 選択されたクイズのJSを読み込む --}}
        @vite(['resources/js/games/quiz' . $quizId . '.js'])
    @endif
</head>
<body class="quiz-page">
    {{-- BGM再生機能 --}}
    <audio id="quiz-bgm" src="{{ asset('music/games/bgm.mp3') }}" loop></audio>
    <script>
        // ブラウザの自動再生ブロックを回避するため、初回クリック時に再生を開始する
        document.addEventListener('click', function() {
            const bgm = document.getElementById('quiz-bgm');
            if (bgm && bgm.paused) {
                bgm.play().catch(error => {
                    console.log("再生に失敗しました:", error);
                });
            }
        }, { once: true }); // 一回限り
    </script>
    

    <div id="quiz-box" class="quiz-container">
        
        @if(!$quizId || !array_key_exists($quizId, $availableQuizzes))
            {{-- ▼ クイズ選択画面 --}}
            <h1 class="quiz-title">クイズを選択してください</h1>
            <form action="{{ route('games.quiz') }}" method="GET" class="text-center">
                <div class="select-wrapper">
                    <select name="id" class="quiz-select">
                        @foreach($availableQuizzes as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="btn-container">
                    <button type="submit" class="btn-submit">GO!</button>
                </div>
            </form>
            {{-- ▲ クイズ選択画面 --}}

        @else
            {{-- ▼ クイズ実行画面 --}}
            <h1 class="quiz-title">{{ $availableQuizzes[$quizId] }}</h1>
            
            <div id="question-container" class="section-container">
                <h2 class="section-title">問題</h2>
                <div id="question" class="question-box">
                    {{-- JSにより問題文が挿入されます --}}
                    読み込み中...
                </div>
            </div>

            <div id="choices-container" class="section-container">
                <h2 class="section-title">選択肢</h2>
                <div id="choices" class="choices-list">
                    {{-- JSにより選択肢が挿入されます --}}
                </div>
            </div>

            <div id="result-container" class="result-area">
                <div id="result"></div>
            </div>

            <div class="btn-container btn-group">
                <a href="{{ route('games.quiz') }}" class="btn-secondary">戻る</a>
                <button onclick="nextQuestion()" class="btn-submit">
                    回答する
                </button>
            </div>
            {{-- ▲ クイズ実行画面 --}}
        @endif

    </div>
</body>
</html>
