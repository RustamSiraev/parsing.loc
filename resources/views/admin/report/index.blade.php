@extends('layouts.app', ['title' => 'Статистика'])

@section('content')
    <div class="page-title">
        <h1>Статистика</h1>
        <div class="form-group" style="width: 300px">
            <select name="college_id" class="college-select form-control" title="СПО">
            </select>
        </div>
    </div>
    <div class="">
        <table class="table table-secondary table-bordered statistic-table table-striped" style="width:100%" id="employee_data">
            <thead>
            <tr>
                <th>Показатель</th>
                <th>Значение</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>Всего специальностей</td>
                <td class="statistic" id="data-1">0</td>
            </tr>
            <tr>
                <td>Всего подано заявлений</td>
                <td class="statistic" id="data-2">0</td>
            </tr>
            <tr>
                <td>Из них на рассмотрении</td>
                <td class="statistic" id="data-3">0</td>
            </tr>
            <tr>
                <td>Из них отклонено</td>
                <td class="statistic" id="data-4">0</td>
            </tr>
            <tr>
                <td>Из них принято</td>
                <td class="statistic" id="data-5">0</td>
            </tr>
            <tr>
                <td>Всего зачислено</td>
                <td class="statistic" id="data-6">0</td>
            </tr>
            <tr>
                <td>Всего отказано в зачислении</td>
                <td class="statistic" id="data-7">0</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="page-title">
        <button type="button" id="export_button" class="btn btn-primary btn-add-user"><i class="bi bi-download"></i>Excel</button>
    </div>
@endsection
