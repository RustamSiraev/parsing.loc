@extends('layouts.app', ['title' => 'Редактирование абитуриента'])

@section('content')
    <div class="back-button">
        <a href="{{ route($back) }}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Редактирование абитуриента</h1>
    </div>
    <form method="post" id="user-edit-form" action="{{ route($route, ['applicant' => $applicant->id]) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.applicant.form')
    </form>
@endsection
