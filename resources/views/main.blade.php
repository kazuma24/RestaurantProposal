<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>なに食べる？</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" />
    <link href="{{ asset('css/main.css') }}"  rel="stylesheet">
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>

<body>
    @include('commponent.locationinfomation')
    @include('commponent.conditions') @include('commponent.freeword')
    @include('commponent.roulette')
    <div class="container" id="main_container">
        <div class="header" style="display: flex;">
           <div style="width: 40%;">なに食べる？</div>
           <form method="POST" action="/search" class="search_container">
               @csrf
        　　<input type="text" name="searchword" size="25" placeholder="検索"><input type="submit" value="&#xf002">
           </form>
        </div>
        <div style="display: flex; margin-top: 10px;">
            <div class="row row_phone" style="width: 80%;" id="slide">
                <img src="{{ asset('img/top1.jpg') }}" />
                <img src="{{ asset('img/top2.jpg') }}" style="display: none;" />
                <img src="{{ asset('img/top3.jpg') }}" style="display: none;" />
                <img src="{{ asset('img/top4.jpeg') }}" style="display: none;" />
                <img src="{{ asset('img/top5.jpg') }}" style="display: none;" />
                <img src="{{ asset('img/top6.jpg') }}" style="display: none;" />
        　　</div>
           <div class="PC" style="width: 40%; opacity: 0.8;">
                <div style="text-align: center;
                    font-size: larger;">なに食べる？の使い方
                </div>
                <div>とにかく店が決まらない時などに使ってください</div>
                <div>場所、ジャンルから選びたいなら[条件]ボタン</div>
                <div>リストの中からも決まらない時は[ルーレット]ボタン</div>
                <div>ざっくり決まってるなら[フリーワード]ボタン</div>
                <div>近場で済ませたいなら[近くのお店]ボタン</div>
                <div>変なことには使わないよーに（運営者からのお願い）</div>
            　　<img class="yorosiku" src="{{ asset('img/yorosiku.png') }}">
            </div>
        </div>

        <div class="row menu">
            <button type="button" class="btn" id="key-word">
                条件
            </button>
            <button type="button" class="btn" id="roulette">
                ルーレット
            </button>
            <button type="button" class="btn" id="free-word">
                フリーワード
            </button>
            <button type="button" class="btn" id="location-information">
                近くのお店
            </button>

        </div>
        <div id="app">
            @isset($viewData)
            <main-page id="main-page" v-bind:view-data="{{ $viewData }}"
                v-bind:used-Terminal="{{ $usedTerminal['terminal'] }}">
            </main-page>
            @else
            <div>接続に失敗しました</div>
            @endisset
        </div>
        <footer>
            <div class="footer1">
                <ul>
                    <a href="{{route('guidance')}}">
                        <li>なに食べる？の目的</li>
                    </a>
                    <a href="{{ route('rule') }}">
                        <li>利用規約</li>
                    </a>
                    <a href="{{ route('inquery') }}">
                        <li>問い合わせ</li>
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
