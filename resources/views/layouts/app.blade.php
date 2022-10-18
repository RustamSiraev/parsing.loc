<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    @auth
        <link href="{{ asset('css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    @endauth
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/_style.css') }}" rel="stylesheet">
</head>

<body>
<div id="app">
    <div class="header-menu">
        <nav class="navbar navbar-expand-md navbar-light bg-white-main shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="@auth{{ auth()->user()->home() }}@else{{ '/' }}@endauth">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            @role('root')
                            @php $instruction = '1.pdf'; @endphp
                            @endrole
                            @role('admin')
                            @php $instruction = '2.pdf'; @endphp
                            @endrole
                            @role('college')
                            @php $instruction = '2.pdf'; @endphp
                            @endrole
                            @role('user')
                            @php $instruction = '3.pdf'; @endphp
                            @endrole

                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link" target="_blank"
                                       href="{{ route('download', ['file' => $instruction]) }}"
                                       role="button" aria-expanded="false">
                                        <i class="bi bi-file-earmark-medical"></i>Инструкции
                                    </a>
                                </li>
                            </ul>

                            @noRole('root')
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="{{ route('message') }}" role="button"
                                       aria-expanded="false">
                                        <i class="bi bi-person-lines-fill"></i>Тех. помощь
                                    </a>
                                </li>
                            </ul>
                            @endrole
                            @role('user')
                            <ul class="navbar-nav ms-auto">
                                <li class="nav-item dropdown">
                                    <a class="nav-link" href="{{ route('applicant.contacts') }}" role="button"
                                       aria-expanded="false">
                                        <i class="bi bi-telephone-outbound"></i>Контакты
                                    </a>
                                </li>
                            </ul>
                            @endrole

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                   data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </a>

                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('password') }}">
                                            Сменить пароль
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                    </li>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    @auth
        @role('root')
        @include('layouts.part.root')
        @endrole
        @role('admin')
        @include('layouts.part.college')
        @endrole
        @role('college')
        @include('layouts.part.college')
        @endrole
        @role('user')
        @include('layouts.part.applicant')
        @endrole
    @endauth

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    @include('layouts.flash-message')
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Scripts -->
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script src="{{ asset('js/script.js') }}"></script>
@auth
    <script src="{{ asset('js/xlsx.full.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
    @role('root')
    <script src="{{ asset('js/admin.js') }}"></script>
    @endrole
    @role('admin')
    <script src="{{ asset('js/college.js') }}"></script>
    @endrole
    @role('user')
    <script src="{{ asset('js/main.js') }}"></script>
    @endrole
@endauth
</body>

</html>
