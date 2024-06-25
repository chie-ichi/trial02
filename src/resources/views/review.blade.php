@extends('layouts.app')

@section('title')
<title>Review | Rese</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/review.css') }}">
@endsection

@section('content')
<div class="review">
    <div class="inner review__inner">
        <h1 class="review__title">レビューを書く</h1>
        <p class="review__lead">{{ $restaurant->name }}へのレビューを投稿します。</p>
        <div class="review__contents-wrap">
            <form action="/add-review" class="review-form" method="post">
                @csrf
                <input type="hidden" name="user_id" class="review-form__hidden" value="{{ $user_id }}">
                <input type="hidden" name="restaurant_id" class="review-form__hidden" value="{{ $restaurant->id }}">
                <div class="review-form__item">
                    <h5 class="review-form__item-title">評価</h5>
                    <div class="review-form__stars">
                        <input id="star05" type="radio" name="stars" value="5"  class="review-form__stars-radio" @if(old('stars') == '5') checked @endif><label for="star05"  class="review-form__stars-label">★</label>
                        <input id="star04" type="radio" name="stars" value="4" class="review-form__stars-radio" @if(old('stars') == '4') checked @endif><label for="star04" class="review-form__stars-label">★</label>
                        <input id="star03" type="radio" name="stars" value="3" class="review-form__stars-radio" @if(old('stars') == '3') checked @endif><label for="star03" class="review-form__stars-label">★</label>
                        <input id="star02" type="radio" name="stars" value="2" class="review-form__stars-radio" @if(old('stars') == '2') checked @endif><label for="star02" class="review-form__stars-label">★</label>
                        <input id="star01" type="radio" name="stars" value="1" class="review-form__stars-radio" @if(old('stars') == '1') checked @endif><label for="star01" class="review-form__stars-label">★</label>
                    </div>
                    <div class="review-form__error">
                        @error('stars')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="review-form__item">
                    <h5 class="review-form__item-title">コメント</h5>
                    <textarea name="comment" class="review-form__textarea">{{ old('comment') }}</textarea>
                    <div class="review-form__error">
                        @error('comment')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="review-form__button-wrap">
                    <button class="review-form__button" type="submit">送信</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

