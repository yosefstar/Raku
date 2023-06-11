<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <!-- <ul class="navbar-nav ms-auto"> -->
                    <div class="bar">
                        <!-- Authentication Links -->
                        <div class="d-flex">
                            @guest
                            @if (Route::has('login'))
                            <div class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('ログイン') }}</a>
                            </div>
                            @endif

                            @if (Route::has('register'))
                            <div class="nav-item-register">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('新規登録') }}</a>
                            </div>
                            @endif
                            @else
                        </div>
                        <!-- <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre> -->
                        <div class="nav-item dropdown">
                            <div class="d-flex">
                                <div class="nav-user">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <img src="{{ asset('images/user.png') }}" alt="Ping Icon Add" width="35" height="auto" style="margin-top: 0px; margin-right: -5px;">
                                        {{ Auth::user()->name }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <!-- ドロップダウンメニューの内容を追加 -->
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            {{ __('ログアウト') }}
                                        </a>
                                    </ul>
                                </div>
                                <div class="add-item" style="display: flex; align-items: center; padding-left: 15px;">
                                    <a href="{{ route('search.index') }}">
                                        <img src="{{ asset('images/ping_icon_add.png') }}" alt="Ping Icon Add" width="15" height="auto" style="margin-top: -5px;">
                                        アイテムを追加
                                    </a>
                                </div>

                                <div class="nav-ranking" style="display: flex; align-items: center; padding-left: 15px;">
                                    <a href="{{ route('showRanking') }}">
                                        <img src="{{ asset('images/ranking.png') }}" alt="Ranking Icon" width="27" height="auto" style="margin-top: -9px; margin-right: -3px;">
                                        ランキング
                                    </a>
                                </div>
                            </div>



                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        @endguest
                    </div>
                    <!-- </ul> -->
                </div>
            </div>
        </nav>

        <main class="py-4 custom-height">
            @yield('content')
        </main>


    </div>
</body>

</html>