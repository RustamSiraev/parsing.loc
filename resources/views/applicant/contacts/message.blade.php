@extends('layouts.app', ['title' => 'Написать сообщение'])

@section('content')
    <div class="back-button">
        <a href="{{ route('applicant.index') }}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1>Написать сообщение</h1>
    </div>
    <form method="post" id="message-create-form" action="{{ isset($college) ? route('applicant.contacts.store') : route('message.store') }}"
          enctype="multipart/form-data">
        @csrf
        <div class="user-add-form" id="message-form">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Тема <span class="text-danger">*</span></label>
                        <input id="title" type="text"
                               class="form-control @error('title') is-invalid @enderror"
                               name="title" value="{{ old('title') ?? '' }}" required
                               autocomplete="title"
                               autofocus>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Сообщение <span class="text-danger">*</span></label>
                        <textarea id="body" type="text" rows="10"
                                  class="form-control @error('body') is-invalid @enderror"
                                  name="body" required
                                  autocomplete="body"
                                  autofocus>{{ old('body') ?? '' }}</textarea>
                        @error('body')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <input type="hidden" name="college_id" value="{{ isset($college) ? $college->id : '' }}">
            </div>
            <div class="d-flex btn-footer">
                <button type="submit" class="btn btn-primary btn-add-user">
                    <i class="bi bi-save"></i>Отправить
                </button>
            </div>
        </div>
    </form>
@endsection

