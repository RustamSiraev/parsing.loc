@extends('layouts.app', ['title' => 'Добавление СПО'])

@section('content')
    <div class="back-button">
        <a href="{{ route('colleges.index') }}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Добавление СПО</h1>
    </div>
    <form method="post" id="college-create-form" action="{{ route('colleges.store') }}" enctype="multipart/form-data">
        @include('admin.college.part.form')
    </form>
@endsection
