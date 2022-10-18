@extends('layouts.app', ['title' => 'Список пользователей'])

@section('content')
    <div class="page-title">
        <h1>Список пользователей</h1>
        <a href="{{ route('college.users.create')}}" class="btn btn-primary btn-add-user">
            <i class="bi bi-person-plus"></i>Добавить пользователя</a>
    </div>
    <div class="">
        <table class="table table-secondary table-bordered user-datatable table-striped" style="width:100%">
            <thead>
            <tr>
                <th class="dt-id">ID</th>
                <th>Имя</th>
                <th>Логин</th>
                <th class="dt-body-status">Роль</th>
                <th class="dt-body-status">Статус</th>
                <th>Операции</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    @include('admin.part.confirm')
@endsection
