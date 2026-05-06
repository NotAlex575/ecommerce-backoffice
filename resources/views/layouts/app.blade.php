<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Ecommercione'))</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    @vite(['resources/js/app.js'])
</head>

<body class="bg-dark text-light">

    <div id="app" class="min-vh-100 d-flex flex-column">

        {{-- NAVBAR --}}
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-lg border-bottom border-info">
            <div class="container">

                <a class="navbar-brand fw-bold text-primary d-flex align-items-center" href="{{ url('/') }}">
                    <span class="me-2">🛒</span>
                    <span style="font-size: 23px; letter-spacing: 1.5px;">
                        ECOMMERCIONE
                    </span>
                </a>

                <button class="navbar-toggler border-info" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">

                    <ul class="navbar-nav ms-auto">

                        @guest
                            <li class="nav-item">
                                <a class="nav-link text-light fw-semibold" href="{{ route('login') }}">
                                    Login
                                </a>
                            </li>

                            @if (Route::has('register'))
                                <li class="nav-item ms-md-2">
                                    <a class="nav-link text-light fw-semibold"
                                        href="{{ route('register') }}">
                                        Register
                                    </a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-info fw-semibold"
                                    href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end bg-dark border border-info shadow-lg">
                                    <a class="dropdown-item text-info" href="{{ url('dashboard') }}">
                                        Dashboard
                                    </a>

                                    <a class="dropdown-item text-info" href="{{ url('profile') }}">
                                        Profile
                                    </a>

                                    <hr class="dropdown-divider border-info">

                                    <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest

                    </ul>
                </div>
            </div>
        </nav>

        {{-- MAIN --}}
        <main class="flex-grow-1 py-5">
            <div class="container">
                @yield('content')
            </div>
        </main>

        {{-- FOOTER --}}
        <footer class="bg-dark text-light py-4 border-top border-info">
            <div class="container d-flex flex-column flex-md-row justify-content-between align-items-center">

                <div class="mb-3 mb-md-0 text-info fw-semibold">
                    © {{ date('Y') }} Ecommercione — Created by Alessandro Agnello
                </div>

                <div class="d-flex gap-3">
                    <a href="https://www.facebook.com/alessandro.agnello.794/" target="_blank"
                        class="btn btn-outline-info btn-sm rounded-circle d-flex align-items-center justify-content-center"
                        style="width:40px; height:40px;">
                        <i class="bi bi-facebook"></i>
                    </a>

                    <a href="https://www.instagram.com/notalex575_/" target="_blank"
                        class="btn btn-outline-info btn-sm rounded-circle d-flex align-items-center justify-content-center"
                        style="width:40px; height:40px;">
                        <i class="bi bi-instagram"></i>
                    </a>

                    <a href="https://github.com/NotAlex575" target="_blank"
                        class="btn btn-outline-info btn-sm rounded-circle d-flex align-items-center justify-content-center"
                        style="width:40px; height:40px;">
                        <i class="bi bi-github"></i>
                    </a>
                </div>

            </div>
        </footer>

    </div>
</body>

</html>