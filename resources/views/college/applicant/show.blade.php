@extends('layouts.app', ['title' => $applicant->getFullName()])

@section('content')
    <div class="back-button">
        <a href="{{ route($back)}}"><i class="bi bi-backspace"></i>Назад</a>
    </div>
    <div class="page-title">
        <h1> {{ $applicant->getFullName() }}</h1>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="about-tab" data-bs-toggle="tab" data-bs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="true">Об абитуриенте</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="diploma-tab" data-bs-toggle="tab" data-bs-target="#diploma" type="button" role="tab" aria-controls="diploma" aria-selected="false">Аттестат</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab" aria-controls="files" aria-selected="false">Файлы</button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        @include('admin.applicant.part.about')
        @include('admin.applicant.part.diploma')
        @include('admin.applicant.part.files')
    </div>
@endsection
