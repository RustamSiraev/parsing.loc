@extends('layouts.app', ['title' => __('Update Password')])

@section('content')
    <div class="back-button">
        <a href="{{ $back }}"><i class="bi bi-backspace"></i>{{ __('Back') }}</a>
    </div>
    <div class="page-title">
        <h1>{{ __('Update Password') }}</h1>
    </div>

    <form id="password-edit-form" method="POST" action="{{ route('users.password.change') }}">
        @method('POST')
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}">
        <input type="hidden" name="back" value="{{ $back }}">
        <div class="search-form">
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label required" for="new-password">{{ __('New Password') }}:</label>
                        <input id="new-password" type="password"
                               class="form-control @error('new-password') is-invalid @enderror"
                               name="new-password" value="{{ old('new-password') ?? '' }}" required
                               autocomplete="new-password"
                               autofocus>
                        @error('new-password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label required" for="new-password-confirm">
                            {{ __('Confirm Password') }}:
                        </label>
                        <input id="new-password-confirm" type="password"
                               class="form-control @error('new-password-confirm') is-invalid @enderror"
                               name="new-password-confirm" value="{{ old('new-password-confirm') ?? '' }}" required
                               autocomplete="new-password-confirm"
                               autofocus>
                        @error('new-password-confirm')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="d-flex btn-footer">
                <button type="submit" class="btn btn-primary btn-add-user">
                    <i class="bi bi-save"></i>{{ __('Save') }}
                </button>
            </div>
        </div>
    </form>
@endsection
