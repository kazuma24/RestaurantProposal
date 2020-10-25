<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>なに食べる？</title>
    <link rel="icon" href="favicon.ico">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" />
    <link href="{{ asset('css/main.css') }}"  rel="stylesheet">
    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet" type="text/css" />
    <link type="text/css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" type="text/css" rel="stylesheet"></link>
</head>

<body>
    @include('commponent.locationinfomation')
    @include('commponent.conditions') @include('commponent.freeword')
    @include('commponent.roulette')
    <div class="container" id="main_container">
        <div class="header" style="display: flex;">
           <div style="width: 40%;">なに食べる？<spna><img class="favicon" src="{{ asset('img/favicon.png') }}"></spna></div>
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
           @if(!Auth::check())
           <div class="PC" style="width: 40%; opacity: 0.8;">
                <div style="text-align: center;
                    font-size: larger;">なに食べる？の使い方
                </div>
                <div class="ms">とにかく店が決まらない時などに使ってください</div>
                <div class="ms">場所、ジャンルから選びたいなら[条件]ボタン</div>
                <div class="ms">リストの中からも決まらない時は[ルーレット]ボタン</div>
                <div class="ms">ざっくり決まってるなら[フリーワード]ボタン</div>
                <div class="ms">近場で済ませたいなら[近くのお店]ボタン</div>
                <div class="ms">変なことには使わないよーに（運営者からのお願い）</div>
            　　 <div class="re_log_area">
                    <a href="{{ route('login') }}">
                    <button class="login">ログイン</button>
                    </a>
                    <a href="{{ route('newmemberguide') }}">
                    <button class="newMember">新規会員登録</button>
                    </a>
                </div>
            </div>
            @else
             <div class="PC" style="width: 40%; opacity: 0.8;">
            　　 <div class="re_log_area">
                    <div style="display: block;">
                        <a href="{{ route('favoshow') }}">
                            <button class="favobutton">お気に入りリスト★</button>
                        </a>
                    </div>
                    <div class="Advertising">
                        @if($advertising == 1)
                        @include('advertising.ad1')
                        @elseif($advertising == 2)
                        @include('advertising.ad2')
                        @elseif($advertising == 3)
                        @include('advertising.ad3')
                        @elseif($advertising == 4)
                        @include('advertising.ad4')
                        @elseif($advertising == 5)
                        @include('advertising.ad5')
                        @elseif($advertising == 6)
                        @include('advertising.ad6')
                        @elseif($advertising == 7)
                        @include('advertising.ad7')
                        @elseif($advertising == 8)
                        @include('advertising.ad8')
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
        @if(!Auth::check())
        <div class="phone">
            <a href="{{ route('login') }}">
               <button class="login">ログイン</button>
            </a>
            <a href="{{ route('newmemberguide') }}">
               <button class="newMember">新規会員登録</button>
            </a>
        </div>
        @else
        <div class="phone">
             <a href="{{ route('favoshow') }}">
                <button class="favobutton">お気に入りリスト★</button>
             </a>
        </div>
        @endif
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
            <main-page
            id="main-page"
            v-bind:view-data="{{ $viewData }}"
            v-bind:used-Terminal="{{ $usedTerminal['terminal'] }}"
            v-bind:user-data="{{ $userData }}">
            </main-page>
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
                    <a href="{{ route('logout') }}">
                        <li>ログアウト</li>
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
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
</body>

</html>
