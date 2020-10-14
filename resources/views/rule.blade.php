<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div style="text-align: center;
                    background-color: white;
                    font-size: larger;
                    background: beige;
                    border-bottom: 1px solid burlywood;">なに食べる？の利用規約</div>
        <section>
            <div>第1条　お店考えるのがだるい時に使うべし</div>
        </section>
        <section>
            <div>第2条　それでも決まらないならるーれっと</div>
        </section>
        <section>
            <div>第3条　いいお店に出会えたら迷わず決めるべし</div>
        </section>
        <section>
            <div>第4条　全て無料で使えるよ←規約じゃない</div>
        </seciton>
        <div style="text-align: end;">
            <a href="{{ route('main') }}">
              <button>もどる</button>
            </a>
        </div>
    </div>
</body>
<style>
    body {
            background-image: url('{{ asset("img/back2.jpg") }}');
        }
    .container {
        width: 500px;
        margin: auto;
        background: whitesmoke;
        font-family: arial unicode ms;
        }
    .container >img {
        width: 500px;
        height: 600px;
    }
    section {
        margin: 10px;
    }
    button {
        font-family: arial unicode ms
        ;
    }
</style>
</html>
