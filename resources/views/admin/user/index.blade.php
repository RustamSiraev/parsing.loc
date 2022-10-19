@extends('layouts.app', ['title' => 'Список пользователей'])

@section('content')
    <div class="page-title">
        <h1>Список пользователей</h1>
        <a href="{{ route('users.create')}}" class="btn btn-primary btn-add-user">
            <i class="bi bi-person-plus"></i>Добавить пользователя</a>
    </div>
    <div class="search-form mb-4">
        <table class="table table-secondary table-bordered user-datatable table-striped" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('E-mail') }}</th>
                <th>{{ __('Status') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    @include('admin.part.confirm')
@endsection
