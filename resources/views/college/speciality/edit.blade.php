@extends('layouts.app', ['title' => 'Редактирование специальности'])

@section('content')
    <div class="back-button">
        <a href="{{ route($back)}}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Редактирование специальности</h1>
    </div>
    <form method="post" id="user-edit-form" action="{{ route($route, ['speciality' => $speciality->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('college.speciality.form')
    </form>
    @include('college.speciality.part.qualification')
    @include('college.speciality.part.testing')
@endsection
