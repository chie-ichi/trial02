@extends('layouts.app')

@section('title')
<title>Done | Rese</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/done.css') }}">
@endsection

@section('content')
<div class="done">
    <div class="inner done__inner">
        <div class="done-block">
            <h1 class="done-block__message">ご予約ありがとうございます</h1>
            <a href="/mypage" class="done-block__button">戻る</a>
        </div>
    </div>
</div>
@endsection

