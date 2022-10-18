@extends('layouts.app', ['title' => 'Контакты'])

@section('content')
    <div class="page-title">
        <h1>Контакты</h1>
    </div>
    <div class="">
        <table class="table table-secondary table-bordered contacts-datatable table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Наименование</th>
                <th>Телефон</th>
                <th>Написать</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
@endsection

