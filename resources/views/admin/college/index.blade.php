@extends('layouts.app', ['title' => 'Реестр СПО'])

@section('content')
    <div class="page-title">
        <h1>Реестр СПО</h1>
        <a href="{{ route('colleges.create')}}" class="btn btn-primary btn-add-user">
            <i class="bi bi-plus-lg"></i>Создать СПО</a>
    </div>
    <div class="">
        <table class="table table-secondary table-bordered admin-college-datatable table-striped" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Статус</th>
                <th>Операции</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    @include('admin.part.confirm')
@endsection
