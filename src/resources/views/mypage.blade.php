@extends('layouts.app')

@section('title')
<title>My Page | Rese</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="mypage">
    <div class="inner mypage__inner">
        <h1 class="mypage__title">{{ Auth::user()->name }}さん</h1>
        <div class="mypage__contents-wrap">
            <div class="reservation">
                <h2 class="mypage__contents-title">予約状況</h2>
                <div class="reservation__block-wrap">
                    @if($reservations->isEmpty())
                    <p class="reservation__not-found">予約がありません</p>
                    @else
                    @foreach($reservations as $reservation)
                    @if($reservation->isPast() || $reservation->visit_confirmation_at)
                    <div class="reservation__block reservation__block--past">
                        <h3 class="reservation__block-title">予約#{{ $reservation->id }} (履歴) − @if($reservation->visit_confirmation_at) 来店確認済 @else 来店未確認 @endif</h3>
                        <table class="reservation__table">
                            <tr class="reservation__table-row">
                                <th class="reservation__table-heading">Shop</th>
                                <td class="reservation__table-data">
                                    {{ $reservation->getRestaurant() }}
                                </td>
                            </tr>
                            <tr class="reservation__table-row">
                                <th class="reservation__table-heading">Date</th>
                                <td class="reservation__table-data">{{ \Carbon\Carbon::parse($reservation->date)->format('Y/m/d') }}</td>
                            </tr>
                            <tr class="reservation__table-row">
                                <th class="reservation__table-heading">Time</th>
                                <td class="reservation__table-data">{{ \Carbon\Carbon::parse($reservation->time)->format('H:i') }}</td>
                            </tr>
                            <tr class="reservation__table-row">
                                <th class="reservation__table-heading">Number</th>
                                <td class="reservation__table-data">{{ $reservation->number }}人</td>
                            </tr>
                        </table>
                        @if($reservation->visit_confirmation_at)
                        <div class="review">
                            <form action="/review" class="review-form" method="get">
                                <input type="hidden" name="user_id" class="review-form__hidden" value="{{ $reservation->user_id }}">
                                <input type="hidden" name="restaurant_id" class="review-form__hidden" value="{{ $reservation->restaurant_id }}">
                                <div class="review-form__button-wrap">
                                    <button class="review-form__button" type="submit">レビューを書く</button>
                                </div>
                            </form>
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="reservation__block">
                        <h3 class="reservation__block-title">予約#{{ $reservation->id }}</h3>
                        <div class="cancel-wrap">
                            <form action="/cancel" class="cancel-form" method="post" onsubmit="return confirmCancel()">
                                @csrf
                                <input type="hidden" name="id" class="cancel-form__hidden" value="{{ $reservation->id }}">
                                <button class="cancel-form__button" type="submit">
                                    <img src="{{ asset('img/icon-close.svg') }}" alt="close" class="cancel-form__button-img">
                                </button>
                            </form>
                        </div>
                        <form action="/edit-reservation" method="post" class="reservation__edit-form" novalidate>
                            @csrf
                            <input type="hidden" name="id" value="{{ $reservation->id }}" class="reservation__hidden">
                            <table class="reservation__table">
                                <tr class="reservation__table-row">
                                    <th class="reservation__table-heading">Shop</th>
                                    <td class="reservation__table-data">
                                        {{ $reservation->getRestaurant() }}
                                    </td>
                                </tr>
                                <tr class="reservation__table-row">
                                    <th class="reservation__table-heading">Date</th>
                                    <td class="reservation__table-data">
                                        <input type="date" name="date" value="{{ $reservation->date }}" class="reservation__table-input" min="{{ now()->addDay()->format('Y-m-d') }}">
                                        <div class="reservation-table__error">
                                            @error('date')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                                <tr class="reservation__table-row">
                                    <th class="reservation__table-heading">Time</th>
                                    <td class="reservation__table-data">
                                        <select name="time" class="reservation__table-select">
                                            @for($h = 9; $h <= 21; $h++)
                                                @for($m = 0; $m < 60; $m += 30)
                                                    @php
                                                        $time = sprintf('%02d:%02d', $h, $m);
                                                        $time_value = $time . ":00";
                                                    @endphp
                                                    <option value="{{ $time }}" @if($reservation->time == $time_value) selected @endif>{{ $time }}</option>
                                                @endfor
                                            @endfor
                                        </select>
                                        <div class="reservation-table__error">
                                            @error('time')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                                <tr class="reservation__table-row">
                                    <th class="reservation__table-heading">Number</th>
                                    <td class="reservation__table-data">
                                        <select name="number" class="reservation__table-select">
                                            @for($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" @if($reservation->number == $i) selected @endif>{{ $i . '人' }}</option>
                                            @endfor
                                        </select>
                                        <div class="reservation-table__error">
                                            @error('number')
                                            {{ $message }}
                                            @enderror
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="reservation__button-wrap">
                                <button class="reservation__button" type="submit">更新</button>
                            </div>
                        </form>
                        <div class="payment">
                            <p class="payment__lead">100円のクーポンを事前購入いただくと、全員にワンドリンクサービスいたします。</p>
                            @if($reservation->paid_at)
                            <div class="payment__paid-wrap">
                                <span class="payment__paid">ご購入済み</span>
                            </div>
                            @else
                            <form action="{{route('stripe.charge')}}" method="POST" class="payment-form">
                                @csrf
                                <input type="hidden" name="reservation_id" value="{{ $reservation->id }}" class="payment-form__hidden">
                                <script
                                    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                    data-key="{{ env('STRIPE_KEY') }}"
                                    data-amount="100"
                                    data-name="クーポンを購入する"
                                    data-label="クーポンを購入"
                                    data-description="お支払い情報をご入力ください"
                                    data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                    data-locale="auto"
                                    data-currency="JPY">
                                </script>
                            </form>
                            @endif
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @endif
                </div>
            </div>
            <div class="restaurant">
                <h2 class="mypage__contents-title">お気に入り店舗</h2>
                <ul class="restaurant-list">
                    @if($favorites->isEmpty())
                    <p class="restaurant-list__not-found">お気に入り店舗がありません</p>
                    @else
                    @foreach($favorites as $favorite)
                    <li class="restaurant-list__item">
                        <div class="restaurant-list__photo">
                            <img src="{{ $favorite->restaurant->photo }}" alt="{{ $favorite->restaurant->name }}">
                        </div>
                        <div class="restaurant-list__contents">
                            <p class="restaurant-list__name">{{ $favorite->restaurant->name }}</p>
                            <div class="restaurant-list__tag">
                                <p class="restaurant-list__area">{{ $favorite->restaurant->getArea() }}</p>
                                <p class="restaurant-list__category">{{ $favorite->restaurant->getCategory() }}</p>
                            </div>
                            <div class="restaurant-list__info">
                                <a href="/detail/{{ $favorite->restaurant->id }}" class="restaurant-list__link">詳しくみる</a>
                                @php
                                    $user_id = Auth::id();
                                @endphp
                                @if(Auth::check())
                                <div class="restaurant-list__favorite">
                                    <form class="favorite-form" action="/remove-favorite" method="post">
                                        @csrf
                                        <input type="hidden" name="user_id" class="favorite-form__hidden" value="{{ $user_id; }}">
                                        <input type="hidden" name="restaurant_id" class="favorite-form__hidden" value="{{ $favorite->restaurant->id }}">
                                        <button class="favorite-form__button" type="submit"><img src="{{ asset('img/icon-favorite-on.svg') }}" alt="お気に入りON" class="restaurant-list__favorite-icon"></button>
                                    </form>
                                </div>
                                @else
                                <img src="{{ asset('img/icon-favorite-off.svg') }}" alt="お気に入りOFF" class="restaurant-list__favorite-icon">
                                @endif
                            </div>
                        </div>
                    </li>
                    @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<script>
function confirmCancel() {
    return confirm('本当に予約を削除してもよろしいですか？');
}
</script>
@endsection

