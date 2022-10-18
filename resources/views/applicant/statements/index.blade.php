@extends('layouts.app', ['title' => 'Личный кабинет -> Мои заявления'])

@section('content')
    <div class="page-title">
        <h1>Заявления</h1>
        <a href="{{ route('applicant.statement.create')}}" class="btn btn-primary btn-add-user">
            <i class="bi bi-plus-lg"></i>Подать заявление</a>
    </div>
    <div class="">
        <table class="table table-secondary table-bordered statement-datatable table-striped" style="width:100%">
            <thead>
            <tr>
                <th>СПО</th>
                <th>Код</th>
                <th>Наименование специальности</th>
                <th>Квалификации</th>
                <th>Форма обучения</th>
                <th>Срок обучения</th>
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

