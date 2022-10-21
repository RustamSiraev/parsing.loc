@extends('layouts.app', ['title' => __('User`s parsing history')])

@section('content')
    <div class="back-button">
        <a href="{{ route($back)}}"><i class="bi bi-backspace"></i>{{ __('Back') }}</a>
    </div>
    <div class="page-title">
        <h1>{{ __('User`s parsing history') }}</h1>
    </div>

    @include('part.parsing')
@endsection
