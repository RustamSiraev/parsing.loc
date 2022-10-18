@extends('layouts.app', ['title' => 'Подача заявления'])

@section('content')
    <div class="back-button">
        <a href="{{ route('applicant.statement.index') }}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Подача заявления</h1>
    </div>
    <form method="post" id="statement-create-form" action="{{ route('applicant.statement.store') }}" enctype="multipart/form-data">
        @include('applicant.statements.form')
    </form>
@endsection
