@extends('layouts.app', ['title' => 'Все заявления'])

@section('content')
    <div class="page-title">
        <h1>Все заявления</h1>
    </div>
    <div class="">
        <table class="table table-secondary table-bordered college-statements-datatable table-striped" id="statements-table" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Код</th>
                <th>Специальность</th>
                <th>Уровень</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
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
