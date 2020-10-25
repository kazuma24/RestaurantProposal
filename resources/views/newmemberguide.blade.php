@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">会員限定機能<spna><img class="favicon" src="{{ asset('img/favicon.png') }}"></spna></div>
                <div class="card-body">
                    <div>お気に入り機能</div>
                    <p>あなたが気に入ったお店をお気に入りリストとして保存できます。</p>
                     <div style="text-align: end;">
                        <a href="{{route('register')}}">
                         <button class="btn btn-primary"
                                style="margin-top: 10px;
                                margin-bottom: 10px;">登録へ進む</button>
                        </a>
                    </div>
                    <img style="width: 100%;" src="{{ asset('img/nanitabe.png') }}">
                    <img style="width: 100%; margin-top: 3px;" src="{{ asset('img/nanitabe2.png') }}">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
