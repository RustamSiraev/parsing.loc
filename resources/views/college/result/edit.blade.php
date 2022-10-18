@extends('layouts.app', ['title' => 'Редактирование результатов испытаний'])

@section('content')
    <div class="back-button">
        <a href="{{ route($back)}}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Редактирование результатов испытаний</h1>
    </div>
    <form method="post" id="user-edit-form" action="{{ route($route, ['result' => $result->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('college.result.form')
    </form>
@endsection
