@extends('layouts.app', ['title' => __("Users")])

@section('content')
    <div class="page-title">
        <h1>{{ __("Users") }}</h1>
        <a href="{{ route('users.create')}}" class="btn btn-primary btn-add-user">
            <i class="bi bi-person-plus"></i>{{ __("Add User") }}</a>
    </div>
    <div class="search-form mb-4">
        <table class="table table-secondary table-bordered user-datatable table-striped" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('E-mail') }}</th>
                <th>{{ __('Checks') }}</th>
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
