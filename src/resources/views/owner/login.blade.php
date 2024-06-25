@extends('layouts.app')

@section('title')
<title>店舗代表者用ログイン画面 | Rese</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/login.css') }}">
@endsection

@section('content')
<div class="login">
    <div class="inner login__inner">
        <div class="login__block">
            <h1 class="login__block-ttl">店舗代表者用ログイン</h1>
            <div class="login__block-body">
                <form action="/owner/login" class="form" method="post" novalidate>
                    @csrf
                    <div class="form__group">
                        <div class="form__group-icon">
                            <img src="{{ asset('img/icon-mail.svg') }}" alt="メール">
                        </div>
                        <div class="form__group-content">
                            <div class="form__input--text">
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" autocomplete="new-password" class="form__input--text-input" />
                            </div>
                            <div class="form__error">
                            @error('email')
                            {{ $message }}
                            @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__group">
                        <div class="form__group-icon">
                            <img src="{{ asset('img/icon-lock.svg') }}" alt="パスワード">
                        </div>
                        <div class="form__group-content">
                            <div class="form__input--text">
                            <input type="password" name="password" placeholder="Password" autocomplete="new-password" class="form__input--text-input" />
                            </div>
                            <div class="form__error">
                            @error('password')
                            {{ $message }}
                            @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form__button-wrap">
                        <button type="submit" class="form__button">ログイン</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

