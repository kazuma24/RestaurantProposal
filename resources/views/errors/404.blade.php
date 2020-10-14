<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>404 (File)Not Found</title>
    <style>
        body {
            text-align: center;
            background-image: url('{{ asset("img/back2.jpg") }}');
        }

        .error-wrap {
            padding: 5px 20px;
            border: 1px solid #dcdcdc;
            display: inline-block;
            background-color: white;
        }

        h1 {
            font-size: 18px;
        }

        p {
            margin-left: 10px;
        }

    </style>
</head>

<body>
    <div class="error-wrap">
        <section>
            <h1>404 (File)Not Found</h1>
            <p>指定した情報の店舗はありませんでした</p>
        </section>
        <img style="height: 300px;" src="{{ asset('img/suman.jpg') }}">
    </div>
</body>

</html>
