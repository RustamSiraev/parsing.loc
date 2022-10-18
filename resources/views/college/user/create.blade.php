@extends('layouts.app', ['title' => 'Создание пользователя'])

@section('content')
    <div class="back-button">
        <a href="{{ route('users.index')}}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Создание пользователя</h1>
    </div>
    <form method="post" id="user-create-form" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @include('admin.user.form')
    </form>
@endsection
