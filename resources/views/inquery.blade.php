<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問い合わせ</title>
    <link rel="icon" href="favicon.ico">
</head>
<body>
    <div class="container">
         <div class="title">運営者宛て問い合わせフォーム<spna><img class="favicon" src="{{ asset('img/favicon.png') }}"></spna></div>
        <form action="" method="POST">
            @csrf
            <fieldset>
                <legend>名前</legend>
                <input type="text" name="name" maxlength="20">
            </fieldset>
            <fieldset>
                 <legend>メールアドレス</legend>
                <input type="email" name="email">
            </fieldset>
             <fieldset>
                <legend>問い合わせ内容</legend>
                <lavel>質問<input checked type="radio" name="form" value="質問"></lavel>
                <lavel>機能追加要望<input type="radio" name="form" value="機能追加要望"></lavel>
                <lavel>不具合等のクレーム<input type="radio" name="form" value="不具合等のクレーム"></lavel>
                <lavel>その他<input type="radio" name="form" value="その他"></lavel>
            </fieldset>
            <fieldset>
                 <legend>内容</legend>
                <textarea name="content" maxlength="255" placeholder="250文字程度で入力ください"></textarea>
            </fieldset>
            <div class="submit">
                <input type="submit" value="送信" id="submit">
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
        @isset($mailErrorMessage)
        <p>{{ $mailErrorMessage }}</p>
        @endisset
        @isset($succsesMessage)
        <p id="ok">{{ $succsesMessage }}</p>
        @endisset
    </div>
</body>
<style>
    body {
        font-family: arial unicode ms;
        }
    .container {
        width: 500px;
        margin: auto;
        background: whitesmoke;
        font-family: arial unicode ms;
    }
    .title {
        text-align: center;
        background-color: rgb(239, 238, 238);
        font-size: larger;
        border-bottom: 1px solid black;
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
    .submit {
        display: flex;
        width: fit-content;
        margin: auto;
    }
    #submit {
        width: 100px;
        background-color:cornflowerblue;
        color: aliceblue;
        border: none;
    }
    #submit:hover {
        opacity: 0.8;
    }

</style>
</html>
