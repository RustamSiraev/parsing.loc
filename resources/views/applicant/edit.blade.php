@extends('layouts.app', ['title' => 'Личный кабинет'])

@section('content')
    <div class="page-title">
        <h1>Мои данные</h1>
    </div>
    <div class="user-add-form">
        <form method="post" id="parent-edit-form" action="{{ route('applicant.update', ['applicant' => $applicant->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @include('auth.form')
            <div class="d-flex btn-footer">
                <button type="submit" class="btn btn-primary btn-add-user">
                    <i class="bi bi-save"></i>Сохранить изменения
                </button>
            </div>
        </form>
    </div>
@endsection

