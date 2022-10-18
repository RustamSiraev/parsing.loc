@extends('layouts.app', ['title' => 'Специальности'])

@section('content')
    <div class="page-title">
        <h1>Специальности</h1>
        @noRole('root')
        <a href="{{ route('college.specialities.create')}}" class="btn btn-primary btn-add-user">
            <i class="bi bi-plus-lg"></i>Добавить специальность</a>
        @endrole
    </div>
    <div class="">
        <table class="table table-secondary table-bordered college-speciality-datatable table-striped" style="width:100%">
            <thead>
            <tr>
                <th>Уровень образования</th>
                <th>СПО</th>
                <th>Код</th>
                <th>Наименование специальности</th>
                <th>Квалификации</th>
                <th>Форма обучения</th>
                <th>Бюджетных мест</th>
                <th>Внебюджетных мест</th>
                <th>Стоимость обучения за год</th>
                <th>Срок обучения, мес.</th>
                <th>Операции</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    @include('admin.part.confirm')
@endsection
