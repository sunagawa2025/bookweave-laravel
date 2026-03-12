
const quiz = [
    {
        q: "螺旋丸の修行に使ったものは？",
        c: ["テニスボール", "野球ボール", "バスケットボール", "ゴムボール"],
        a: 3
    },

    {
        q: "ナルトの五大性質は？",
        c: ["火遁", "水遁", "風遁", "土遁"],
        a: 2
    },

    {
        q: "はたけカカシの口寄せ動物は？",
        c: ["犬", "蛙", "ナメクジ", "猿"],
        a: 0
    },
       {
        q: "うちはイタチが使う万華鏡写輪眼の瞳術は？",
        c: ["神威", "別天神", "加具土命", "天照"],
        a: 3
        },
 
       {
        q: "我愛羅が持つ尾獣の名前は？",
        c: ["磯撫", "守鶴", "牛鬼", "九喇嘛"],
        a: 1
        },

       {
        q: "サスケが大蛇丸のアジトを向かう前に体を乗っ取ったのは？",
        c: ["君麻呂", "重吾", "次郎坊", "幻幽丸"],
        a: 3
        },
  
];

let index = 0;
let score = 0;

function loadQuiz() {
    const questionEl = document.getElementById("question");
    if (!questionEl) return;

    document.getElementById("result").textContent = "";
    const q = quiz[index];
    questionEl.textContent = q.q;

    const choicesDiv = document.getElementById("choices");
    choicesDiv.innerHTML = "";

    q.c.forEach((choice, i) => {
        const label = document.createElement("label");
        label.innerHTML = `<input type="radio" name="choice" value="${i}"> ${choice}<br>`;
        choicesDiv.appendChild(label);
    });
}

window.nextQuestion = function() {
    const selected = document.querySelector("input[name='choice']:checked");
    if (!selected) {
        alert("選択肢を選んでください");
        return;
    }

    if (Number(selected.value) === quiz[index].a) {
        score++;
        document.getElementById("result").textContent = "正解！";
    } else {
        document.getElementById("result").textContent =
            "不正解… 正解は「" + quiz[index].c[quiz[index].a] + "」";
    }

    index++;

    if (index < quiz.length) {
        setTimeout(loadQuiz, 1000);
    } else {
        setTimeout(showFinal, 1000);
    }
};

function showFinal() {
    document.getElementById("quiz-box").innerHTML =
        `<h2>結果発表</h2>
         <p>${quiz.length}問中 ${score}問正解！</p>
         <p>${score === quiz.length ? "満点！おめでとう！" :
            score >= 7 ? "もう少し！" :
            "また挑戦してね"}</p>`;
}

// 画面読み込み時に初期化
document.addEventListener("DOMContentLoaded", loadQuiz);