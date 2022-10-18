@extends('layouts.app', ['title' => 'Редактирование пользователя'])

@section('content')
    <div class="back-button">
        <a href="{{ route($back) }}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Редактирование пользователя</h1>
    </div>
    <form method="post" id="user-edit-form" action="{{ route($route, ['user' => $user->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.user.form')
    </form>
@endsection
