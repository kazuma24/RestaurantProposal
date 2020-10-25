@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">本会員登録完了<spna><img class="favicon" src="{{ asset('img/favicon.png') }}"></spna></div>

                    <div class="card-body">
                        <p>本会員登録が完了しました。ログインページからログインしてください</p>
                        <a href="{{ route('login') }}" class="sg-btn">ログインページへ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
