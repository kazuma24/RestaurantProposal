<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>お気に入りリスト</title>

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
    <div class="container" id="main_container">
        <div class="header" style="display: flex; margin-bottom: 12px;">
           <div class="favotitle">お気に入りリスト<img class="favicon" src="{{ asset('img/favicon.png') }}"></spna></div>
        </div>
        <a href="{{ route('main') }}" class="pankuzu">&lt;トップページ</a>
        <ul class="favo-banner">
            @foreach($favoriteDatas as $favoriteData)
                <li id="favo_li">
                    <a href="" class="favo_a">
                        <p>{{ $favoriteData['restName'] }}</p>
                        @empty($favoriteData['restImageUrl'])
                         <img src="{{ asset('img/noimage.png') }}">
                        @endempty
                        @if($favoriteData['restImageUrl'])
                         <img src="{{ $favoriteData['restImageUrl'] }}">
                        @endif
                    </a>
                    <div style="text-align: end; display: flex;">
                        <a href="tel:{{ $favoriteData['restTel'] }}">
                        <button class="yoyakubutton">予約<span><img class="phone_icon" src="{{ asset('img/phone.png') }}"></span></button>
                        </a>
                        <form action="" method="POST">
                            @csrf
                            <input type="hidden" name="restId" value="{{ $favoriteData['restId'] }}">
                            <input class="deletebutton" type="submit" value="削除">
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="links">
            {{ $favoriteDatas->links() }}
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
