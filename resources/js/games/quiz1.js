
const quiz = [
    {
        q: "男塾の塾長・江田島平八の名台詞として最も有名なのは？",
        c: ["わしが男塾塾長、江田島平八である！", "わしが日本一の教師である！", "わしが天下無双の軍人である！", "わしが世界一の柔道家である！"],
        a: 0
    },

    {
        q: "男塾入塾時に獄悔房行きになった人物は？",
        c: ["松尾鯛雄", "極小路秀麻呂", "虎丸龍次", "J"],
        a: 2
    },

    {
        q: "田沢慎一郎が九九で9×9をどう答えた？",
        c: ["9", "18", "81", "88"],
        a: 3
    },


       {
        q: "男塾名物、灼熱の油がなみなみと注がれたたらいに浸かる修行の名は？",
        c: ["地獄風呂", "極楽風呂", "油風呂", "男風呂"],
        a: 2
        },
 
       {
        q: "男塾名物「直進行軍」。進む先に家があった場合、塾生はどうしなければならない？",
        c: ["迂回する", "家の主にお願いする", "屋根に登る", "壁を突き破って直進する"],
        a: 3
        },

       {
        q: "男塾名物を解説する時に登場する書物は？",
        c: ["百科事典", "民明書房", "広辞苑", "男塾大百科"],
        a: 1
        },
  

       {
        q: "二号生との御対面式で瓶杯の儀に挑んだのは？",
        c: ["松尾鯛雄", "極小路秀麻呂", "富樫源次", "田沢慎一郎"],
        a: 0
        },

       {
        q: "独眼鉄・蝙翔鬼・男爵ディーノが入れている入れ墨は？",
        c: ["閻魔邪刺青", "鬼達磨刺青", "地獄変刺青", "悪魔我刺青"],
        a: 1
        },

       {
        q: "剣桃太郎の就職先は？",
        c: ["内閣総理大臣", "男塾塾長", "金融庁", "ゼネコン会社"],
        a: 0
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