@extends('layouts.app', ['title' => 'Добавление абитуриента'])

@section('content')
    <div class="back-button">
        <a href="{{ route($back)}}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Добавление абитуриента</h1>
    </div>
    <form method="post" id="user-create-form" action="{{ route($route) }}" enctype="multipart/form-data">
        @include('college.applicant.form')
    </form>
@endsection
