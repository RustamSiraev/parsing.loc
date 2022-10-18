@extends('layouts.app', ['title' => 'Активность пользователя: '.$user->name])

@section('content')
    <div class="back-button">
        <a href="{{ route($back) }}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Активность пользователя: {{ $user->name }}</h1>
    </div>
    <div class="">
        <table class="table table-secondary table-bordered activity-datatable table-striped" style="width:100%">
            <thead>
            <tr>
                <th class="dt-id">ID</th>
                <th>Пользователь</th>
                <th>Дата</th>
                <th>Действие</th>
                <th>Таблица</th>
                <th>Операции</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <input type="hidden" id="user-id" value="{{ $user->id }}">
@endsection
