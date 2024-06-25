@extends('layouts.app')

@section('title')
<title>メール認証 | Rese</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify.css') }}">
@endsection

@section('content')
<div class="verify">
    <div class="inner verify__inner">
        <div class="card">
            <div class="card-header">{{ __('Verify Your Email Address') }}</div>

            <div class="card-body">
                @if (session('resent'))
                    <div class="card-message__success" role="alert">
                        {{ __('A fresh verification link has been sent to your email address.') }}
                    </div>
                @endif

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }}
                <form class="card-formZ" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="card-link">{{ __('click here to request another') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
