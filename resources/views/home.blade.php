@extends('layouts.site')

@section('content')

    <div class="mainscreen">
        <div class="container">
            <h1 class="mainscreen__title">Прием и регистрация заявлений на обучение <br> по образовательным программам среднего <br> профессионального образования</h1>
            <div class="mainscreen__desc">Цель сервиса — упростить и ускорить процесс зачисления <br> абитуриентов в учебные заведения.</div>
            <div class="mainscreen-form">
                @guest
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mainscreen-form-row">
                        <div class="mainscreen-form-input">
                            <input id="email" type="email"
                                   class="input @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email"
                                   placeholder="E-mail">
                        </div>
                        <div class="mainscreen-form-input">
                            <input type="password" id="password-input"
                                   class="input @error('password') is-invalid @enderror" name="password"
                                   required autocomplete="password" placeholder="Пароль">
                            <button toggle="#password-input" class="pass__toggle" type="button"></button>
                        </div>
                        <div class="mainscreen-form-button">
                            <button type="submit" class="mainscreen-form__enter">Войти <i class="ic-enter"></i></button>
                        </div>
                    </div>
                    @if ($errors->any())
                        <span class="invalid-feedback-my" role="alert">
                            @error('status')
                                <strong>Ваш аккаунт заблокирован</strong>
                            @enderror
                            @error('email')
                                <strong>Неверный логин или пароль</strong>
                            @enderror
                        </span>
                    @endif
                    <div class="mainscreen-form-bottom">
                        <a href="{{ route('password.request') }}" class="mainscreen-form__recovery">Восстановление пароля</a>
                        <a href="{{ route('register') }}" class="mainscreen-form__register button">Регистрация</a>
                    </div>
                </form>
                @else
                    <a href="{{ auth()->user()->home() }}" class="mainscreen-form__register button">Личный кабинет</a>
                @endguest
            </div>
            <div class="stats">
                <div class="stats-item">
                    <div class="stats-item__number">7</div>
                    <div class="stats-item__text">ссузов</div>
                </div>
                <div class="stats-item">
                    <div class="stats-item__number">25 098</div>
                    <div class="stats-item__text">бюджетных мест</div>
                </div>
                <div class="stats-item">
                    <div class="stats-item__number">42 000</div>
                    <div class="stats-item__text">платных мест</div>
                </div>
                <div class="stats-item">
                    <div class="stats-item__number">97</div>
                    <div class="stats-item__text">направлений</div>
                </div>
            </div>
        </div><!-- end container -->
    </div><!-- end mainscreen -->

    <div class="content">
        <div class="container">
            <a href="#" class="content__btn">Список учебных заведений</a>
            <div class="content-row">
                <div class="content-leftside">
                    <div class="features">
                        <h2 class="features__title">Преимущества</h2>
                        <div class="features-list">
                            <div class="features__item">Для работы с сервисом необходимо только устройство с выходом в интернет.</div>
                            <div class="features__item">Подключение и дальнейшее участие в сервисе бесплатны.</div>
                            <div class="features__item">Интерфейсы легки в освоении и интуитивно понятны</div>
                        </div>
                    </div>
                </div>
                <div class="content-rightside">
                    <div class="mainnews">
                        <h2 class="mainnews__title">Новости</h2>
                        <div class="mainnews-list">
                            @if($news->count())
                                @foreach ($news as $item)
                                    <div class="mainnews-item">
                                        <div class="mainnews-item__date">{{ Date::parse($item->created_at)->format('j.m.Y') }}</div>
                                        <a href="{{ route('news.show', ['id' => $item->id]) }}" class="mainnews-item__title">{{ $item->title }}</a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <a href="{{ route('news') }}" class="mainnews__all">Показать все новости</a>
                    </div>
                </div>
            </div>
        </div><!-- end container -->
    </div><!-- end content -->
@endsection
