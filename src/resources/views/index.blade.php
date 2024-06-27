@extends('layouts.app')

@section('title')
<title>Rese</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="restaurant">
    <div class="inner restaurant__inner">
        <div class="search">
            <form action="/" class="search-form" method="post">
                @csrf
                <div class="search-form__item">
                    <div class="search-form__item-select-wrap">
                        <select name="area_id" class="search-form__item-select search-form__item-select--area" onchange="submit(this.form)">
                            <option value="">All areas</option>
                            @foreach($areas as $area)
                            <option value="{{ $area['id'] }}" @if ($area['id'] == request()->input('area_id')) selected @endif>{{ $area['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search-form__item-select-wrap">
                        <select name="category_id" class="search-form__item-select search-form__item-select--category" onchange="submit(this.form)">
                            <option value="">All genre</option>
                            @foreach($categories as $category)
                                <option value="{{ $category['id'] }}" @if ($category['id'] == request()->input('category_id')) selected @endif>{{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" name="keyword" class="search-form__item-text" placeholder="Search ..." value="{{ request()->input('keyword') }}" onchange="submit(this.form)">
                </div>
            </form>
        </div>
        <ul class="restaurant-list">
            @foreach($restaurants as $restaurant)
            <li class="restaurant-list__item">
                <div class="restaurant-list__photo">
                    <img src="{{ $restaurant->photo }}" alt="{{ $restaurant->name }}">
                </div>
                <div class="restaurant-list__contents">
                    <p class="restaurant-list__name">{{ $restaurant->name }}</p>
                    <div class="restaurant-list__tag">
                        <p class="restaurant-list__area">{{ $restaurant->getArea() }}</p>
                        <p class="restaurant-list__category">{{ $restaurant->getCategory() }}</p>
                    </div>
                    <div class="restaurant-list__info">
                        <a href="/detail/{{ $restaurant->id }}" class="restaurant-list__link">詳しくみる</a>
                        @php
                            $user_id = Auth::id();
                        @endphp
                        <div class="restaurant-list__favorite">
                            @if($restaurant->isFavorite($user_id))
                            <form class="favorite-form" action="/remove-favorite" method="post">
                                @csrf
                                <input type="hidden" name="user_id" class="favorite-form__hidden" value="{{ $user_id; }}">
                                <input type="hidden" name="restaurant_id" class="favorite-form__hidden" value="{{ $restaurant->id }}">
                                <button class="favorite-form__button" type="submit"><img src="{{ asset('img/icon-favorite-on.svg') }}" alt="お気に入りON" class="restaurant-list__favorite-icon"></button>
                            </form>
                            @else
                            <form class="favorite-form" action="/add-favorite" method="post">
                                @csrf
                                <input type="hidden" name="user_id" class="favorite-form__hidden" value="{{ $user_id; }}">
                                <input type="hidden" name="restaurant_id" class="favorite-form__hidden" value="{{ $restaurant->id }}">
                                <button class="favorite-form__button" type="submit"><img src="{{ asset('img/icon-favorite-off.svg') }}" alt="お気に入りOFF" class="restaurant-list__favorite-icon"></button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection

