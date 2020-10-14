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
    border-bottom: 1px solid burlywood;">こーゆーのを解決したい⇩</div>
        <img src="{{ asset('img/manga.png') }}">
        <a href="{{ route('main') }}">
            <button>もどる</button>
        </a>

    </div>

</body>
<style>
    body {
            background-image: url('{{ asset("img/back2.jpg") }}');
            font-family: arial unicode ms;
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
