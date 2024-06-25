<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @yield('title')
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    @yield('css')
</head>
<body>
    <header class="header">
        <button class="header-hamburger" type="button">
            <div class="header-hamburger__line"></div>
            <div class="header-hamburger__line"></div>
            <div class="header-hamburger__line"></div>
        </button>
        <a href="/" class="header__logo">Rese</a>
    </header>

    <dialog class="modal">
        <div class="inner modal-inner">
            <div class="modal-menu">
                <button class="modal-menu__btn-close">
                    <div class="modal-menu__btn-close-line"></div>
                    <div class="modal-menu__btn-close-line"></div>
                </button>
                <nav class="modal-nav">
                    <ul class="modal-nav__list">
                        <li class="modal-nav__list-item">
                            <a href="/"  class="modal-nav__list-item-link">Home</a>
                        </li>
                        @if(Auth::check())
                        <li class="modal-nav__list-item">
                            <form class="modal-nav__form" action="/logout" method="post">
                                @csrf
                                <button class="modal-nav__form-button" type="submit">User Logout</button>
                            </form>
                        </li>
                        <li class="modal-nav__list-item">
                            <a href="/mypage"  class="modal-nav__list-item-link">Mypage</a>
                        </li>
                        @else
                        <li class="modal-nav__list-item">
                            <a href="/register"  class="modal-nav__list-item-link">Registration</a>
                        </li>
                        <li class="modal-nav__list-item">
                            <a href="/login"  class="modal-nav__list-item-link">User Login</a>
                        </li>
                        @endif
                        @if(Auth::guard('administrators')->check())
                        <li class="modal-nav__list-item">
                            <form class="modal-nav__form" action="/admin/logout" method="post">
                                @csrf
                                <button class="modal-nav__form-button" type="submit">Admin Logout</button>
                            </form>
                        </li>
                        <li class="modal-nav__list-item">
                            <a href="/admin" class="modal-nav__list-item-link">Admin</a>
                        </li>
                        @else
                        <li class="modal-nav__list-item">
                            <a href="/admin/login"  class="modal-nav__list-item-link">Admin Login</a>
                        </li>
                        @endif
                        @if(Auth::guard('owners')->check())
                        <li class="modal-nav__list-item">
                            <form class="modal-nav__form" action="/owner/logout" method="post">
                                @csrf
                                <button class="modal-nav__form-button" type="submit">Owner Logout</button>
                            </form>
                        </li>
                        <li class="modal-nav__list-item">
                            <a href="/owner" class="modal-nav__list-item-link">Owner</a>
                        </li>
                        @else
                        <li class="modal-nav__list-item">
                            <a href="/owner/login"  class="modal-nav__list-item-link">Owner Login</a>
                        </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </dialog>

    <main class="main-contents">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer__inner">
            <span class="copyright">&copy; Rese, inc. 2024</span>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    @include('layouts.flash-message')
</body>
</html>