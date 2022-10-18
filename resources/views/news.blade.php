@extends('layouts.site')

@section('content')

    <header class="header">
        <div class="container">
            <div class="header-body">
                <a href="/" class="header-logo">Комплектования школ</a>
                <div class="header-auth">
                    @guest
                        <a href="{{ route('login') }}" class="header-auth__link">Войти</a>
                        <a href="{{ route('register') }}" class="header-auth__link">Регистрация</a>
                    @else
                        <a href="{{ auth()->user()->home() }}" class="header-auth__link">Личный кабинет</a>
                    @endguest
                </div>
            </div>
        </div><!-- end container -->
    </header><!-- end header -->

    <div class="main">
        <div class="container">
            <ul class="breadcrumbs">
                <li><a href="/">Главная</a></li>
                @if(isset($news))
                    <li>Новости</li>
                @elseif(isset($item))
                    <li><a href="/news">Новости</a></li>
                    <li>{{ $item->title }}</li>
                @endif
            </ul>
            @if(isset($news))
                <div class="news">
                    <div class="news-list">
                        @if($news->count())
                            @foreach ($news as $item)
                                <div class="news-item">
                                    <a href="{{ route('news.show', ['id' => $item->id]) }}" class="news-item-body">
                                        <div class="news-item__date">{{ Date::parse($item->created_at)->format('j.m.Y') }}</div>
                                        <div class="news-item__title">{{ $item->title }}</div>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            @elseif(isset($item))
                <div class="news-single">
                    <h1 class="news-single__title">{{ $item->title }}</h1>
                    <div class="news-single__date">{{ Date::parse($item->created_at)->format('j.m.Y') }}</div>
                    <div class="news-single__text">
                        <p>{{ $item->body }}</p>
                    </div>
                </div>
            @endif
        </div><!-- end container -->
    </div><!-- end main -->
    @if(isset($news))
    <nav class="news-pagination" aria-label="navigation">
        <div class="container">
            {{ $news->links() }}
    </nav>
    @endif
@endsection
