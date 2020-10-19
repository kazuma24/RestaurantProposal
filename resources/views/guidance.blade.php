<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>目的</title>
</head>
<body>
    <div class="container">
        <h3>なに食べるの目的</h3>
        <p>お店が決まらない時、決めるのがめんどくさいと思ってしまう方々に<br>
            お店の情報を提供し、また決定まで導かせるのが目的です。<br>
        </p>
        <p>まだ新しいサイトなのでこれからも徐々に機能等を増やしていくつもりです。<br>
        もし、「このような機能があったらいい」などあればご意見をお聞かせください。<br>
           意見や質問は<a href="{{ route('inquery') }}">こちら</a>からお願いいたします。
    　　</p>
        <a href="{{ route('main') }}">
            <button>もどる</button>
        </a>
    </div>

</body>
<style>
    body {
        font-family: arial unicode ms;
        }
        h3 {
            border-bottom: 1px solid black;
        }
    .container {
        width: 500px;
        margin: auto;
        }
    .container >img {
        width: 500px;
        height: 600px;
    }
</style>
</html>
