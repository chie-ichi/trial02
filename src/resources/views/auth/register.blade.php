@extends('layouts.app')

@section('title')
<title>Register | Rese</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register">
    <div class="inner register__inner">
        <div class="register__block">
            <h1 class="register__block-ttl">Registration</h1>
            <div class="register__block-body">
                <form action="/register" class="form" method="post" novalidate>
                    @csrf
                    <div class="form__group">
                        <div class="form__group-icon">
                            <img src="{{ asset('img/icon-user.svg') }}" alt="ユーザー">
                        </div>
                        <div class="form__group-content">
                            <div class="form__input--text">
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="Username" autocomplete="new-password" class="form__input--text-input" />
                            </div>
                            <div class="form__error">
                            @error('name')
                            {{ $message }}
                            @enderror
                            </div>
                        </div>
                    </div>
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
                        <button type="submit" class="form__button">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

