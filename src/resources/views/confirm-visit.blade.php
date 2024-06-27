@extends('layouts.app')

@section('title')
<title>来店確認 | Rese</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm-visit.css') }}">
@endsection

@section('content')
<div class="visit">
    <div class="inner visit__inner">
        <div class="visit-block">
            <h1 class="visit-block__message">来店確認</h1>
            @if($confirmed)
            <p class="visit-block__lead">予約ID{{ $reservation->id }}: ご予約情報は以下の通りです</p>
            <table class="visit-table">
                <tr class="visit-table__row">
                    <th class="visit-table__heading">店舗名</th>
                    <td class="visit-table__data">{{ $reservation->getRestaurant() }}</td>
                </tr>
                <tr class="visit-table__row">
                    <th class="visit-table__heading">名前</th>
                    <td class="visit-table__data">{{ $reservation->getUser() }}</td>
                </tr>
                <tr class="visit-table__row">
                    <th class="visit-table__heading">日付</th>
                    <td class="visit-table__data">{{ $reservation->date }}</td>
                </tr>
                <tr class="visit-table__row">
                    <th class="visit-table__heading">時間</th>
                    <td class="visit-table__data">{{ $reservation->time }}</td>
                </tr>
                <tr class="visit-table__row">
                    <th class="visit-table__heading">人数</th>
                    <td class="visit-table__data">{{ $reservation->number }}</td>
                </tr>
                <tr class="visit-table__row">
                    <th class="visit-table__heading">クーポン</th>
                    @if($reservation->paid_at)
                    <td class="visit-table__data">購入済</td>
                    @else
                    <td class="visit-table__data">未購入</td>
                    @endif
                </tr>
            </table>
            @else
            <p class="visit-block__lead">予約ID{{ $reservation->id }}: 担当外店舗のご予約のため、内容確認できません</p>
            @endif
            <a href="/owner" class="visit-block__button">管理画面へ</a>
        </div>
    </div>
</div>
@endsection

