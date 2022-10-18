@extends('layouts.site')
@section('content')
    <div class="mainscreen">
        <div class="container">
            <div class="col-md-12">
                @extends('layouts.flash-message')
                <div class="page-title">
                    <h1 style="color: #fff; font-size: 34px;">Регистрация абитуриента</h1>
                    <a href="/" class="mainscreen-form__register button">На главную</a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="user-register-form" action="{{ route('register') }}">
                            @include('auth.form')
                            <div class="btn-footer" style="margin-top: 20px">
                                <button type="submit" class="btn btn-primary btn-add-user float-end" style="margin-right: 0">
                                    <i class="bi bi-save"></i>Зарегистрироваться
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
