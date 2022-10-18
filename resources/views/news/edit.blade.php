@extends('layouts.app', ['title' => 'Редактировать новость'])

@section('content')
    <div class="back-button">
        <a href="{{ route('minobr.news')}}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Редактировать новость</h1>
    </div>
    <form method="post" id="news-edit-form" action="{{ route('minobr.news.update', ['news' => $news->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('news.form')
    </form>
@endsection
