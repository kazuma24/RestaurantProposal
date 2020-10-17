<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>なに食べる？</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            background-image: url('{{ asset("img/back2.jpg") }}');
            font-family: arial unicode ms !important;
            color: whitesmoke !important;
        }
        fieldset {
            color: black;
        }

        /* お店画像サイズ */
        img {
            height: 100%;
            width: 100%;
            max-height: 265px;
        }

        #slide img {
            max-height: 350px;
            max-width: 700px;
        }
        #slide {
            width: 60%;
        }

        .roulette-p {
            text-align: center;
            font-size: 1rem;
            white-space: nowrap;
            border-bottom: 2px solid burlywood;
            background-color: beige;
            color: black;
        }
        .roulette-p:hover {
            color: black;
            text-decoration: none;
        }

        /* クレジット */
        .gurunavi {
            height: auto;
            width: auto;
            max-height: none;
        }

        /* ヘッダー画像 */
        .header {
            background: border-box;
            font-size: xx-large;
            margin-top: unset !important;
            color: black;
            letter-spacing: 2px;
            text-align: center;
            background-color: burlywood;
            border: 5px double beige;
        }

        /* メニュー */
        .menu {
            height: 50px !important;
            background-color: unset !important;
            border: unset !important;
            margin-top: 10px !important;
        }

        /* 条件ポップアップ */
        .popup {
            display: none;
            height: 100vh;
            width: 100%;
            background: black;
            opacity: 0.9;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 5;
        }

        .popupButtonArea {
            display: flex;
        }

        .popupButtonArea button {
            margin: auto;
        }

        /* フリーワードポップアップ */
        .freeWordPopup {
            display: none;
            height: 100vh;
            width: 100%;
            background: black;
            opacity: 0.9;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 5;
        }

        .freeWordContent {
            background: #fff;
            padding: 30px;
            background-color: beige;
            border: 10px double burlywood;
            border-radius: 5px;
        }

        /* jquery表示クラス */
        .show {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* ボタンレイアウト */
        .research {
            height: 50px !important;
        }

        .btn {
            width: 10rem !important;
            margin: 0px 10px;
            color: #fff;
        }

        /* ルーレットボタンデザイン */
        #roulette,
        #location-information,
        #key-word,
        #free-word {
            position: relative;
            display: inline-block;
            font-weight: bold;
            padding: 8px 10px 5px 10px;
            text-decoration: none;
            color: #FFA000;
            background: #fff1da;
            border-bottom: solid 4px #FFA000;
            border-radius: 15px 15px 0 0;
            transition: .4s;
            margin: 0px !important;
            width: 25% !important;
        }
        #roulette:hover {
            opacity: 0.8;
            border-color: sandybrown;
        }
        #key-word:hover {
            opacity: 0.8;
            border-color: sandybrown;
        }
        #free-word:hover {
            opacity: 0.8;
            border-color: sandybrown;
        }
        #location-information:hover {
            opacity: 0.8;
            border-color: sandybrown;
        }

        /* 条件ポップアップ */
        .popup {
            display: none;
            height: 100vh;
            width: 100%;
            background: black;
            opacity: 0.9;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 5;
        }

        .content {
            background: #fff;
            padding: 30px;
            width: auto;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: beige;
            border: 10px double burlywood;
            border-radius: 5px;
        }

        .popupButtonArea {
            display: flex;
        }

        .container {
            border: 1px solid black;
            box-shadow: 5px 5px 5px black;
            background: currentColor !important;
        }

        #main-page {
            max-height: 600px;
            overflow-y: scroll;
            overflow-x: hidden;
            border-top: 1px solid darkgray;
        }

        .row {
            margin-left: auto !important;
            margin-right: auto !important;
        }

        .row button {
            margin: 0px auto !important;
        }

        /* ルーレットポップアップ */
        .roulette img {
            height: 200px;
            width: 200px;
            margin: 5px auto;
        }

        .roulettepopup {
            display: none;
            height: 100vh;
            width: 100%;
            background: black;
            opacity: 0.9;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 5;
        }

        .rouletteContent {
            background: #fff;
            width: 80%;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: beige;
            border: 10px double burlywood;
            border-radius: 5px;
        }

        .rouletteContent>h4 {
            text-align: center;
            margin-top: 10px;
        }

        .targetBorder {
            background: aquamarine;
            opacity: 1;
        }

        .target {
            opacity: 0.9;
        }

        .top-banner {
            display: flex;
            flex-wrap: wrap;
        }

        .top-banner li {
            width: calc(100% / 5);
            /*←画像を横に4つ並べる場合*/
            padding: 15px;
            border: 1px solid black;
            /*←画像の左右に5pxの余白を入れる場合*/
            box-sizing: border-box;
        }
        .top-banner-6 li{
            width: calc(100% / 3) !important;
            padding: 30px 50px;
        }
        .top-banner-7 li{
            width: calc(100% / 4) !important;
        }
        .top-banner-8 li{
            width: calc(100% / 4) !important;
        }

        .top-banner {
            list-style: none;
            padding: 20px;
        }

        .top-banner li img {
            height: 200px;
            width: 100%;
            margin: 0px auto;
            max-height: 200px;
            min-height: 200px;
            /* min-width: 200px; */
            border: 1px solid black;
            box-shadow: 1px 1px 1px black;
            border-radius: 5px;
        }

        .btnArea {
            text-align: center;
        }

        .btnArea button {
            min-width: 200px;
            border: none;
            border-radius: 5px;
            color: whitesmoke;
        }

        #start {
            background-color: cornflowerblue;
            height: 50px;
        }

        #stop {
            background-color: brown;
            height: 50px;
        }

        #rouletteclose {
            border: none;
            background-color: white;
            font-size: x-large;
        }

        .rouletteclose {
            text-align: end;
        }

        /* フッター */
        footer {
            background-color: whitesmoke;
            display: flex !important;
        }

        .footer1 {
            width: 30%;
        }

        .footer2 {
            width: 40%;
            text-align: center;
            margin: auto;
            color: black;
        }

        .footer3 {
            width: 30%;
            text-align: end;
        }

        .footer1>ul {
            margin: auto;
        }

        .gurunavi {
            margin: 1px;
        }
        .yorosiku {
            height: 200px;
            width: 250px;
        }
        a {
            text-decoration: none;
        }
        .Phone {
            display: none;
        }
        .PC div {
            padding-left: 5px;
        }

        /* スマホ */
        @media screen and (max-width: 450px) {
            .btn {
                width: 70px !important;
                font-size: x-small !important;
            }

            .menu {
                height: auto !important;
            }

            /* 飲食店表示 */
            .contentArea p {
                margin-bottom: 0px !important;
            }

            .restName {
                font-size: x-small !important;
            }

            img {
                max-height: 150px;
            }

            .viewdata {
                min-height: auto !important;
                font-size: xx-small;
            }

            .restName {
                margin-top: 0px;
                margin: 0px;
            }

            /* お店の詳細ボタン */
            .view-btn {
                padding: 0px !important;
                height: -weblit-fill-availabel;
                width: 100px !important;

            }


            /* 条件絞り込みポップアップ */
            .popup {
                height: 100%;
            }

            /* .content {
                left: 35%;
                transform: translate(-50%, -85%);
            } */

            /* フリーワードポップアップ */
            .freeWordPopup {
                height: 100%;
            }

            .freeWordContent {
                width: 90%;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            /* ルーレットポップアップ  */
            .rouletteContent {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%, -50%);
                width: 99%;
            }

            .top-banner li {
                max-height: 150px;
                padding: 5px !important;
            }

            .top-banner li img {
                min-width: 50px !important;
                max-height: 50px !important;
                min-height: 50px !important;
            }

            .top-banner {
                padding-bottom: 0px !important;
                margin-bottom: 0px;
            }

            .roulette-p {
                font-size: 1px;
                max-height: 30px;
                margin-bottom: 0px !important;

            }

            #start,
            #stop {
                min-width: 100px;
                height: 30px;
                margin-top: 10px;
            }

            .rouletteclose {
                height: 25px;
            }

            #rouletteclose {
                font-size: small;
            }

            /* フッター */
            footer {
                font-size: 1px;
            }

            .footer1 ul {
                padding-left: 20px;
            }

            .footer1 {
                width: 40%;
            }

            .footer2 {
                width: 60%;
                color: black;
            }

            .footer3 {
                display: none;
            }
            .PC {
                display: none;
            }
            .Phone {
                display: block;
                width: 100% !important;
            }
            #slide img {
                max-height: 150px;
                border: 3px double gold;
            }
            .row_phone {
                max-height: 150px;
            }
            #slide {
            width: 100%;
            }
            .noimage {
                max-height: 150px;
                background-size: cover;
            }
            .yorosiku {
                width: 150px;
                height: 100px;
            }
            .footer1 {
                display: none;
            }
            .footer2 {
                background-color: palegoldenrod;
                height: 20px;
                width: 100% !important;
            }
            .roulette-p {
                white-space: normal;
            }
        }
    </style>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css" />
</head>

<body>
    @include('commponent.locationinfomation')
    @include('commponent.conditions') @include('commponent.freeword')
    @include('commponent.roulette')
    <div class="container">
        <div class="header">
            なに食べる？
        </div>
        <div style="display: flex;">
            <div class="row row_phone" id="slide">
                <img src="{{ asset('img/top1.jpg') }}" />
                <img src="{{ asset('img/top2.jpg') }}" style="display: none;" />
                <img src="{{ asset('img/top3.jpg') }}" style="display: none;" />
                <img src="{{ asset('img/top4.jpeg') }}" style="display: none;" />
                <img src="{{ asset('img/top5.jpg') }}" style="display: none;" />
                <img src="{{ asset('img/top6.jpg') }}" style="display: none;" />
        　　</div>
           <div class="PC" style="width: 40%; color: black;">
               <!-- <img style="min-height: 350px;" src="{{ asset('img/nanitabetai.jpg') }}"> -->
                <div style="text-align: center;
                    background-color: white;
                    font-size: larger;
                    background: beige;
                    border-bottom: 1px solid burlywood;">なに食べる？の使い方
                </div>
                <div>とにかく店が決まらない時などに使ってね</div>
                <div>場所、ジャンルから選びたいなら[じょうけん]ボタン</div>
                <div>リストの中からも決まらない時は[るーれっと]ボタン</div>
                <div>ざっくり決まってるなら[ふりーわーど]ボタン</div>
                <div>近場で済ませたいなら[ちかくのばしょ]ボタン</div>
                <div>変なことには使わないよーに（運営者からのお願い）</div>
            　　<img class="yorosiku" src="{{ asset('img/yorosiku.png') }}">
            </div>
        </div>

        <div class="row menu">
            <button type="button" class="btn" id="key-word">
                じょうけん
            </button>
            <button type="button" class="btn" id="roulette">
                るーれっと
            </button>
            <button type="button" class="btn" id="free-word">
                ふりーわーど
            </button>
            <button type="button" class="btn" id="location-information">
                ちかくのみせ
            </button>
            @isset($totalHitCount)
            <form action="" method="post">
                @csrf
                <!-- 経度 -->
                <input type="hidden" name="latitude" value="{{ $latitude }}" />
                <!-- 緯度 -->
                <input type="hidden" name="longitude" value="{{ $longitude }}" />
                <input type="hidden" name="totalHitCount" value="{{ $totalHitCount }}" />
                <button type="submit" class="btn btn-danger research">
                    お店を再検索
                </button>
            </form>
            @endisset
        </div>
        <div id="app">
            @isset($viewData)
            <main-page id="main-page" v-bind:view-data="{{ $viewData }}"
                v-bind:used-Terminal="{{ $usedTerminal['terminal'] }}">
            </main-page>
            @else
            <div>せつぞくがわるいです。。。</div>
            @endisset
        </div>
        <footer>
            <div class="footer1">
                <ul>
                    <a href="{{route('guidance')}}">
                        <li>なに食べる？の目的</li>
                    </a>
                    <a href="{{ route('rule') }}">
                        <li>利用規約という名にしておく</li>
                    </a>
                    <a href="{{ route('inquery') }}">
                        <li>ききたいこととがあれば</li>
                    </a>
                </ul>
            </div>
            <div class="footer2">
                Copyright © 2020 なに食べる？ All Rights Reserved.
            </div>
            <div class="footer3">
                <a href="https://api.gnavi.co.jp/api/scope/" target="_blank">
                    <img class="gurunavi" src="https://api.gnavi.co.jp/api/img/credit/api_265_65.gif" width="265"
                        height="65" border="0" alt="グルメ情報検索サイト　ぐるなび" />
                </a>
            </div>
        </footer>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
