@extends('layouts.app', ['title' => 'Редактирование СПО'])

@section('content')
    @if(isset($back))
        <div class="back-button">
            <a href="{{ route($back) }}"><i class="bi bi-backspace"></i>Назад</a>
        </div>
    @endif
    <div class="page-title">
        <h1>Редактирование СПО</h1>
    </div>
    <form method="post" id="college-edit-form" action="{{ route($route, ['college' => $college->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.college.part.big-form')
    </form>
@endsection
