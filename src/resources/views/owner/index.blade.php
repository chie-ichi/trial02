@extends('layouts.app')

@section('title')
<title>店舗代表者用管理画面 | Rese</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/owner/index.css') }}">
@endsection

@section('content')
<div class="owner">
    <div class="owner__heading">
        <h1 class="owner__ttl">店舗代表者用管理画面</h1>
    </div>
    <div class="inner owner__inner">
        <p class="owner__lead">こんにちは、{{ $owner->name }}さん</p>
        <div class="register">
            <h2 class="section-title">飲食店情報登録</h2>
            <div class="register__block">
                <div class="register__block-body">
                    <form action="/add" class="form" method="post" novalidate enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="owner_id" class="form__hidden" value="{{ $owner->id }}">
                        <dl class="form__group">
                            <dt class="form__group-term">店舗名</dt>
                            <dd class="form__group-description">
                                <div class="form__group-content">
                                    <div class="form__item-wrap">
                                        <input type="text" name="name" value="{{ old('name') }}" class="form__item-input--text" />
                                    </div>
                                    <div class="form__error">
                                        @error('name')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </dd>
                        </dl>
                        <dl class="form__group">
                            <dt class="form__group-term">エリア</dt>
                            <dd class="form__group-description">
                                <div class="form__group-content">
                                    <div class="form__item-wrap form__item-select-wrap">
                                        <select name="area_id" class="form__item-select">
                                            <option value="">選択してください</option>
                                            @foreach($areas as $area)
                                            <option value="{{ $area['id'] }}" @if($area['id'] == old('area_id')) selected @endif>{{ $area['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form__error">
                                    @error('area_id')
                                    {{ $message }}
                                    @enderror
                                    </div>
                                </div>
                            </dd>
                        </dl>
                        <dl class="form__group">
                            <dt class="form__group-term">ジャンル</dt>
                            <dd class="form__group-description">
                                <div class="form__group-content">
                                    <div class="form__item-wrap form__item-select-wrap">
                                        <select name="category_id" class="form__item-select">
                                            <option value="">選択してください</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category['id'] }}" @if($category['id'] == old('category_id')) selected @endif>{{ $category['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form__error">
                                    @error('category_id')
                                    {{ $message }}
                                    @enderror
                                    </div>
                                </div>
                            </dd>
                        </dl>
                        <dl class="form__group">
                            <dt class="form__group-term">写真</dt>
                            <dd class="form__group-description">
                                <div class="form__group-content">
                                    <div class="form__item-wrap">
                                        <input type="file" name="photo_file" value="{{ old('photo_file') }}" class="form__item-input--file" />
                                    </div>
                                    <div class="form__error">
                                    @error('photo_file')
                                    {{ $message }}
                                    @enderror
                                    </div>
                                </div>
                            </dd>
                        </dl>
                        <dl class="form__group">
                            <dt class="form__group-term">説明文</dt>
                            <dd class="form__group-description">
                                <div class="form__group-content">
                                    <div class="form__item-wrap">
                                        <textarea name="description" class="form__item-textarea">{{ old('description') }}</textarea>
                                    </div>
                                    <div class="form__error">
                                    @error('description')
                                    {{ $message }}
                                    @enderror
                                    </div>
                                </div>
                            </dd>
                        </dl>
                        <div class="form__button-wrap">
                            <button type="submit" class="form__button">登録</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="restaurant">
            <h2 class="section-title">飲食店情報一覧</h2>
            @php
                $restaurants = $owner->getRestaurants();
            @endphp
            @if($restaurants->isEmpty())
            <p>飲食店情報が登録されていません</p>
            @else
            @foreach($restaurants as $restaurant)
            <h3 class="restaurant-name">{{ $restaurant->name }}</h3>
            <form action="/update" method="post" class="restaurant-form" novalidate enctype="multipart/form-data">
            @csrf
                <input type="hidden" name="id" class="restaurant-form__hidden" value="{{ $restaurant->id }}">
                <input type="hidden" name="owner_id" class="restaurant-form__hidden" value="{{ $owner->id }}">
                <table class="restaurant-form__table">
                    <tr class="restaurant-form__table-row">
                        <th class="restaurant-form__table-heading">店舗名</th>
                        <td class="restaurant-form__table-data">
                            <input type="text" name="name" value="{{ $restaurant->name }}" class="restaurant-form__input-text">
                            <div class="reservation-form__error">
                                @error('name')
                                {{ $message }}
                                @enderror
                            </div>
                        </td>
                    </tr>
                    <tr class="restaurant-form__table-row">
                    <th class="restaurant-form__table-heading">エリア</th>
                        <td class="restaurant-form__table-data">
                            <select name="area_id" class="restaurant-form__select">
                                @foreach($areas as $area)
                                    <option value="{{ $area['id'] }}" @if($area['id'] == $restaurant->area_id) selected @endif>{{ $area['name'] }}</option>
                                @endforeach
                            </select>
                            <div class="reservation-form__error">
                                @error('area_id')
                                {{ $message }}
                                @enderror
                            </div>
                        </td>
                    </tr>
                    <tr class="restaurant-form__table-row">
                        <th class="restaurant-form__table-heading">ジャンル</th>
                        <td class="restaurant-form__table-data">
                            <select name="category_id" class="restaurant-form__select">
                                @foreach($categories as $category)
                                    <option value="{{ $category['id'] }}" @if($category['id'] == $restaurant->category_id) selected @endif>{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                            <div class="reservation-form__error">
                                @error('category_id')
                                {{ $message }}
                                @enderror
                            </div>
                        </td>
                    </tr>
                    <tr class="restaurant-form__table-row">
                        <th class="restaurant-form__table-heading">写真</th>
                        <td class="restaurant-form__table-data">
                            <div class="restaurant-form__photo-wrap">
                                <img src="{{ asset($restaurant->photo) }}" alt="{{ $restaurant->name }}" class="restaurant-form__photo restaurant-form__photo--current">
                                <img src="" alt="プレビュー画像" class="restaurant-form__photo restaurant-form__photo--preview" style="display: none;"/>
                            </div>
                            <input type="file" name="photo_file" class="reservation-form__input-file" onchange="previewImage(event)" />
                            <div class="reservation-form__error">
                                @error('photo')
                                {{ $message }}
                                @enderror
                            </div>
                        </td>
                    </tr>
                    <tr class="restaurant-form__table-row">
                        <th class="restaurant-form__table-heading">説明文</th>
                        <td class="restaurant-form__table-data">
                            <textarea name="description" class="restaurant-form__textarea">{{ $restaurant->description }}</textarea>
                            <div class="reservation-form__error">
                                @error('description')
                                {{ $message }}
                                @enderror
                            </div>
                        </td>
                    </tr>
                    <tr class="restaurant-form__table-row">
                        <th class="restaurant-form__table-heading">詳細ページ</th>
                        <td class="restaurant-form__table-data"><a href="{{ url('/detail/' . $restaurant->id) }}" class="restaurant-form__link" target="_blank">{{ url('/detail/' . $restaurant->id) }}</a></td>
                    </tr>
                </table>
                <div class="restaurant-form__button-wrap">
                    <button class="restaurant-form__button" type="submit">飲食店情報を更新</button>
                </div>
            </form>
            @endforeach
            @endif
        </div>
        <div class="reservation">
            <h2 class="section-title">予約情報一覧</h2>
            @if($restaurants->isEmpty())
            <p>予約情報が登録されていません</p>
            @else
            @foreach($restaurants as $restaurant)
            <h3 class="restaurant-name">{{ $restaurant->name }}</h3>
            @php
                $reservations = $restaurant->getReservations();
            @endphp
            @if($reservations->isEmpty())
            <p>予約情報が登録されていません</p>
            @else
                <table class="reservation-table">
                    <tr class="reservation-table__row">
                        <th class="reservation-table__heading">名前</th>
                        <th class="reservation-table__heading">日付</th>
                        <th class="reservation-table__heading">時間</th>
                        <th class="reservation-table__heading">人数</th>
                        <th class="reservation-table__heading">クーポン<br>購入</th>
                        <th class="reservation-table__heading">来店<br>確認</th>
                    </tr>
                    @foreach($reservations as $reservation)
                    <tr class="reservation-table__row">
                        <td class="reservation-table__data">
                            <div class="reservation-table__user-wrap">
                                <span class="reservation-table__user-name">{{ $reservation->getUser() }}</span>
                                <form action="/message" method="get" class="message-form">
                                <input type="hidden" name="restaurant_id" class="message-form__hidden" value="{{ $restaurant->id }}">
                                <input type="hidden" name="user_id" class="message-form__hidden" value="{{ $reservation->user_id }}">
                                <button type="submit" class="message-form__button">メールを送る</button>
                                </form>
                            </div>
                        </td>
                        <td class="reservation-table__data">{{ $reservation->date }}</td>
                        <td class="reservation-table__data">{{ $reservation->time }}</td>
                        <td class="reservation-table__data">{{ $reservation->number }}</td>
                        @if($reservation->visit_confirmation_at)
                        <td class="reservation-table__data">済</td>
                        @else
                        <td class="reservation-table__data">未</td>
                        @endif
                        @if($reservation->paid_at)
                        <td class="reservation-table__data">済</td>
                        @else
                        <td class="reservation-table__data">未</td>
                        @endif
                    </tr>
                    @endforeach
                </table>
            @endif
            @endforeach
            @endif
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        const reader = new FileReader();
        const form = event.target.closest('form');
        const preview = form.querySelector('.restaurant-form__photo--preview');
        const current = form.querySelector('.restaurant-form__photo--current');

        reader.onload = function() {
            if (preview) {
                preview.src = reader.result;
                preview.style.display = 'block';
            }
            if (current) {
                current.style.display = 'none';
            }
        };

        if (file) {
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection

