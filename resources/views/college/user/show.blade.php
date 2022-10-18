@extends('layouts.app', ['title' => 'Данные о пользователе'])

@section('content')
    <div class="back-button">
        <a href="{{ route('users.index')}}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Данные о пользователе</h1>
    </div>
    <form>
        <div class="user-add-form">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="parent_name">Имя пользователя:</label>
                        <input class="form-control" disabled value="{{ $user->name ?? '' }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="parent_email">E-mail:</label>
                        <input class="form-control" disabled value="{{ $user->email ?? ''  }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label required" for="parent_phone">Телефон:</label>
                        <input class="form-control" disabled value="{{ $user->phone ?? ''  }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label required" for="parent_role_id">Роль:</label>
                        <select class="form-control"  disabled>
                            <option selected>{{ $user->role->title ?? ''  }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label required" for="parent_gender">Пол:</label>
                        <select class="form-control" disabled>
                            <option value="1" @if ($user->gender == 1) selected @endif>
                                Мужской
                            </option>
                            <option value="2" @if ($user->gender == 2) selected @endif>
                                Женский
                            </option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="parent_email">Дата рождения:</label>
                        <div class="rails-bootstrap-forms-date-select">
                            <input disabled class="form-control"
                                   value="{{ Carbon\Carbon::createFromDate($user->born_at)->format('Y-m-d') ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="parent_snils">СНИЛС:</label>
                        <input class="form-control" disabled value="{{ $user->snils ?? ''  }}">
                    </div>
                </div>
                <div class="col-md-3 level-0 level-2 level-3"
                     style="{{ in_array($user->role_id, [2,3]) ? '' : 'display: none'}}">
                    <div class="form-group">
                        <label class="control-label" for="parent_college_id">СПО:</label>
                        <select class="form-control" disabled>
                            <option selected>{{ $user->college->title ?? '' }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
