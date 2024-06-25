@extends('layouts.app')

@section('title')
<title>{{ $restaurant->name }} | Rese</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail">
    <div class="inner detail__inner">
        <div class="detail__contents">
            <div class="info">
                <div class="info__heading">
                    <a href="/" type="button" class="info__btn-back" onClick="history.back(); return false;">&lt;</a>
                    <h1 class="info__title">{{ $restaurant->name }}</h1>
                </div>
                <div class="info__photo">
                    <img src="{{ asset($restaurant->photo) }}" alt="{{ $restaurant->name }}" class="info__photo-img">
                </div>
                <ul class="info__tag">
                    <li class="info__tag-item">{{ $restaurant->getArea()}}</li>
                    <li class="info__tag-item">{{ $restaurant->getCategory() }}</li>
                </ul>
                <p class="info__description">{{ $restaurant->description }}</p>
            </div>
            <div class="reservation">
                <div class="reservation-form__wrap">
                    <form action="/reservation" method="post" class="reservation-form" novalidate>
                        @csrf
                        <div class="reservation-form__contents">
                            <h2 class="reservation__title">予約</h2>
                            <div class="reservation-form__item-wrap">
                                <div class="reservation-form__item">
                                    <input type="date" name="date" class="reservation-form__input" value="{{ old('date') }}" min="{{ now()->addDay()->format('Y-m-d') }}">
                                    <div class="reservation-form__error">
                                        @error('date')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="reservation-form__item">
                                    <div class="reservation-form__select-wrap">
                                        <select name="time" class="reservation-form__select">
                                            @for($h = 9; $h <= 21; $h++)
                                                @for($m = 0; $m < 60; $m += 30)
                                                    @php
                                                        $time = sprintf('%02d:%02d', $h, $m);
                                                    @endphp
                                                    <option value="{{ $time }}" @if(old('time') == $time) selected @endif>{{ $time }}</option>
                                                @endfor
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="reservation-form__error">
                                        @error('time')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="reservation-form__item">
                                    <div class="reservation-form__select-wrap">
                                        <select name="number" class="reservation-form__select">
                                            @for($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" @if(old('number') == $i) selected @endif>{{ $i . '人' }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="reservation-form__error">
                                        @error('number')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <input type="hidden" name="restaurant_id" class="reservation-form__hidden" value="{{ $restaurant->id }}">
                                <input type="hidden" name="user_id" class="reservation-form__hidden" value="{{ Auth::id() }}">
                            </div>
                            <div class="reservation-summary">
                                <table class="reservation-summary__table">
                                    <tr class="reservation-summary__table-row">
                                        <th class="reservation-summary__table-heading">Shop</th>
                                        <td class="reservation-summary__table-data">{{ $restaurant->name }}</td>
                                    </tr>
                                    <tr class="reservation-summary__table-row">
                                        <th class="reservation-summary__table-heading">Date</th>
                                        <td class="reservation-summary__table-data" id="date"></td>
                                    </tr>
                                    <tr class="reservation-summary__table-row">
                                        <th class="reservation-summary__table-heading">Time</th>
                                        <td class="reservation-summary__table-data" id="time"></td>
                                    </tr>
                                    <tr class="reservation-summary__table-row">
                                        <th class="reservation-summary__table-heading">Number</th>
                                        <td class="reservation-summary__table-data" id="number"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <button class="reservation-form__button" type="submit">予約する</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="reviews">
            <h3 class="reviews__title">レビュー一覧</h3>
            <div class="reviews-list__wrapper">
                @if($reviews->isEmpty())
                <p class="reviews-list__not-found">レビューがまだありません</p>
                @else
                <ul class="reviews-list">
                @foreach($reviews as $review)
                <li class="reviews-list__item">
                    <div class="reviews-list__user">
                        <img class="reviews-list__user-icon" alt="user" src="{{ asset('img/icon-user.svg') }}">
                        <p class="reviews-list__user-name">{{ $review->getUser() }}</p>
                    </div>
                    <div class="reviews-list__stars-wrap">
                        @for($i = 1; $i <= 5; $i++)
                        @if($review->stars >= $i)
                        <span class="reviews-list__stars reviews-list__stars-on">★</span>
                        @else
                        <span class="reviews-list__stars reviews-list__stars-off">☆</span>
                        @endif
                        @endfor
                    </div>
                    <p class="reviews-list__comment">{{ $review->comment }}</p>
                </li>
                @endforeach
                </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

