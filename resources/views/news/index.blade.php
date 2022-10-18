@extends('layouts.app', ['title' => 'Все новости'])

@section('content')
    <div class="page-title">
        <h1>Все новости</h1>
        <a href="{{ route('minobr.news.create')}}" class="btn btn-primary btn-add-user">
            <i class="bi bi-plus-lg"></i>Добавить новость</a>
    </div>
    <div class="">
        <table class="table table-secondary table-bordered news-datatable table-striped" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Заголовок</th>
                <th>Дата</th>
                <th>Операции</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    @include('admin.part.confirm')
@endsection
