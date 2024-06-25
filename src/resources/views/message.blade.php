@extends('layouts.app')

@section('title')
<title>メールを送る | Rese</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/message.css') }}">
@endsection

@section('content')
<div class="message">
    <div class="inner message__inner">
        <h1 class="message__title">メールを送る</h1>
        <p class="message__lead">{{ $restaurant->name }}から{{ $user->name }}様へメールを送信します。</p>
        <div class="message__contents-wrap">
            <form action="/send-message" class="message-form" method="post">
                @csrf
                <input type="hidden" name="restaurant_id" class="message-form__hidden" value="{{ $restaurant->id }}">
                <input type="hidden" name="user_id" class="message-form__hidden" value="{{ $user->id }}">
                <div class="message-form__item">
                    <h5 class="message-form__item-title">件名</h5>
                    <input type="text" name="subject" class="message-form__input-text" value="{{ old('subject') }}">
                    <div class="message-form__error">
                        @error('subject')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="message-form__item">
                    <h5 class="message-form__item-title">本文</h5>
                    <textarea name="body" class="message-form__textarea">{{ old('body') }}</textarea>
                    <div class="message-form__error">
                        @error('body')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="message-form__button-wrap">
                    <button class="message-form__button" type="submit">送信</button>
                </div>
            </form>
            <div class="message__back-link-wrap">
                <a href="/owner" class="message__back-link">管理画面に戻る</a>
            </div>
        </div>
    </div>
</div>
@endsection

