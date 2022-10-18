@extends('layouts.app', ['title' => 'Добавить новость'])

@section('content')
    <div class="back-button">
        <a href="{{ route('minobr.news')}}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Добавить новость</h1>
    </div>
    <form method="post" id="news-create-form" action="{{ route('minobr.news.store') }}" enctype="multipart/form-data">
        @include('news.form')
    </form>
@endsection
