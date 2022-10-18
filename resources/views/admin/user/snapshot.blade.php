@extends('layouts.app', ['title' => 'Расшифровка действия'])

@section('content')
    <div class="back-button">
        <a href="{{ route($back, ['user' => $snapshot->user_id])}}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Расшифровка действия</h1>
    </div>
    <div class="">
        <table class="table table-secondary table-bordered table-striped" style="width:100%">
            <thead>
            <tr>
                <td colspan="2">Информация</td>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="field_cell">Действие</td>
                <td ng-switch="selected.log_type">
                    <span>{{ $snapshot->getType() }}</span>
                </td>
            </tr>
            <tr ng-show="['create','edit','delete'].includes(selected.log_type)" class="">
                <td class="field_cell">Таблица</td>
                <td class="ng-binding">{{ $snapshot->getModel() }}</td>
            </tr>
            <tr>
                <td class="field_cell">Время</td>
                <td class="ng-binding">{{ $snapshot->log_date }}</td>
            </tr>
            </tbody>
        </table>
        <br>
        @if($snapshot->log_type	!= 'login')
        <div class="responsive_table">
            <table class="table table-secondary table-bordered table-striped" style="width:100%">
                <thead>
                <tr>
                    <td class="ng-binding">Параметр</td>
                    <td class="ng-binding">Было</td>
                    <td>Стало</td>
                </tr>
                </thead>
                <tbody>
                @foreach($snapshot->getData()['before'] as $key=>$item)
                    <tr class="ng-scope">
                        <td class="field_cell ng-binding">{{ $key }}</td>
                        @if($snapshot->log_type	== 'create')
                            <td class="ng-binding">-</td>
                        @else
                            <td class="ng-binding">{{ $item ?? '-' }}</td>
                        @endif
                        @if($snapshot->log_type	== 'delete')
                            <td class="ng-binding changed">-</td>
                        @elseif($snapshot->log_type	== 'create')
                            <td class="ng-binding">{{ $snapshot->getData()['after'][$key] ?? '-'}}</td>
                        @else
                            <td class="ng-binding @if($item != $snapshot->getData()['after'][$key]) changed @endif">{{ $snapshot->getData()['after'][$key] ?? '-'}}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
@endsection
