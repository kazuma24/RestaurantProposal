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
                    border-bottom: 1px solid burlywood;">聞きたいことはこちらから</div>
        <form action="" method="POST">
            @csrf
            <fieldset>
                <legend>なまえ</legend>
                <input type="text" name="name" maxlength="20">
            </fieldset>
            <fieldset>
                 <legend>あどれす</legend>
                <input type="email" name="email">
            </fieldset>
             <fieldset>
                 <legend>ないよう</legend>
                <textarea name="content"></textarea>
            </fieldset>
            <div style="display: flex;
                        width: fit-content;
                        margin: auto;">
                <input style="width: 100px; background-color:coral; color: aliceblue; border-radius: 3px;" type="submit" value="おくる" id="submit">
            </div>
        </form>
         <a href="{{ route('main') }}">
                <button id="button">もどる</button>
                </a>
        @isset($dbErrorMessage)
        <p>{{ $dbErrorMessage }}</p>
        @endisset
        @isset($emptyMessage)
        <p>{{ $emptyMessage }}</p>
        @endisset
        @isset($succsesMessage)
        <p id="ok">{{ $succsesMessage }}</p>
        @endisset
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
        background: whitesmoke;
        font-family: arial unicode ms;
    }
    fieldset {
        border: none;
    }
    textarea {
        resize: none;
        width:300px;
        height:200px;
    }
    p {
        color: red;
        text-align: center;
    }
    #ok {
        color: blue;
        text-align: center;
    }

</style>
</html>
