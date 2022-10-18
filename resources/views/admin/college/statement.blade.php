@extends('layouts.app', ['title' => 'Все заявления'])

@section('content')
    <div class="page-title">
        <h1>Все заявления</h1>
        @noRole('root')
        <a href="{{ route('college.statements.create')}}" class="btn btn-primary btn-add-user">
            <i class="bi bi-plus-lg"></i>Добавить заявление</a>
        @endrole
    </div>
    <div class="">
        <table class="table table-secondary table-bordered college-statements-datatable table-striped" id="statements-table" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>СПО</th>
                <th>Код</th>
                <th>Специальность</th>
                <th>Уровень</th>
                <th>ФИО</th>
                <th>Статус</th>
                <th>Ср. балл</th>
                <th>Подано</th>
                <th>Испытания</th>
                <th>Инфо</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection
