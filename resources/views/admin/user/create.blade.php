@extends('layouts.app', ['title' => __('Add User')])

@section('content')
    <div class="back-button">
        <a href="{{ route($back)}}"><i class="bi bi-backspace"></i>{{ __("Go back") }}</a>
    </div>
    <div class="page-title">
        <h1>{{ __('Add User') }}</h1>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    @extends('layouts.flash-message')
                    <div class="card-body">
                        <form method="post" id="user-create-form" action="{{ route($route) }}" enctype="multipart/form-data">
                            @include('auth.form')

                            <div class="mb-3 row">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }}
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
