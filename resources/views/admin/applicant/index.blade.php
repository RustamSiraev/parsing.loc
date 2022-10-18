@extends('layouts.app', ['title' => 'Реестр абитуриентов'])

@section('content')
    <div class="page-title">
        <h1>Реестр абитуриентов</h1>
        <a href="{{ route('applicants.create')}}" class="btn btn-primary btn-add-user">
            <i class="bi bi-person-plus"></i>Добавить абитуриента</a>
    </div>
    <div class="">
        <table class="table table-secondary table-bordered admin-applicants-datatable table-striped" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Дата рождения</th>
                <th>Тип документа</th>
                <th>Номер документа</th>
                <th>Операции</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    @include('admin.part.confirm')
@endsection
