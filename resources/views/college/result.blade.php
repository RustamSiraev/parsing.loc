@extends('layouts.app', ['title' => 'Результаты испытаний'])

@section('content')
    <div class="page-title">
        <h1>Результаты испытаний</h1>
        <a class="btn btn-primary btn-add-user" href="#" title="Добавить результаты испытаний" data-bs-toggle="modal"
           data-bs-target="#dataResultModal"><i class="bi bi-plus-lg"></i>Добавить результаты испытаний</a>
    </div>
    <div class="">
        <table class="table table-secondary table-bordered college-result-datatable table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Код</th>
                <th>Наименование специальности</th>
                <th>Уровень образования</th>
                <th>Форма обучения</th>
                <th>Операции</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    @include('admin.part.confirm')
    @include('admin.part.result')
@endsection
