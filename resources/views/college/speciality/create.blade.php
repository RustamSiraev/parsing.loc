@extends('layouts.app', ['title' => 'Создание специальности'])

@section('content')
    <div class="back-button">
        <a href="{{ route($back)}}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Создание специальности</h1>
    </div>
    <form method="post" id="user-create-form" action="{{ route($route) }}" enctype="multipart/form-data">
        @include('college.speciality.form')
    </form>
    <div class="page-title title-secondary">
        <h2>Добавить квалификации и испытания можно после сохранения специальности</h2>
    </div>
@endsection
