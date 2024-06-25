@extends('layouts.app')

@section('title')
<title>管理画面 | Rese</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/index.css') }}">
@endsection

@section('content')
<div class="admin">
    <div class="admin__heading">
        <h1 class="admin__ttl">管理画面</h1>
    </div>
    <div class="inner admin__inner">
        <div class="register">
            <h2 class="section-title">店舗管理者登録</h2>
            <div class="register__block">
                <div class="register__block-body">
                    <form action="/owner/register" class="form" method="post" novalidate>
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
        <div class="owner">
            <h2 class="section-title">店舗管理者一覧</h2>
            @if($owners->isEmpty())
            <p class="owner__not-found">店舗管理者が登録されていません</p>
            @else
            <table class="owner-table">
                <tr class="owner-table__row">
                    <th class="owner-table__heading">ID</th>
                    <th class="owner-table__heading">管理者名</th>
                    <th class="owner-table__heading">Eメール</th>
                    <th class="owner-table__heading">店舗名</th>
                </tr>
                @foreach($owners as $owner)
                <tr class="owner-table__row">
                    <td class="owner-table__data">{{ $owner->id }}</td>
                    <td class="owner-table__data">{{ $owner->name }}</td>
                    <td class="owner-table__data">{{ $owner->email }}</td>
                    <td class="owner-table__data">
                        @php
                            $restaurants = $owner->getRestaurants();
                        @endphp
                        @if(!$restaurants->isEmpty())
                        <ul class="owner-table__owner-list">
                        @foreach($restaurants as $restaurant)
                            <li class="owner-table__owner-list-item">{{ $restaurant->name }}</li>
                        @endforeach
                        </ul>
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
            @endif
        </div>
    </div>
</div>
@endsection

