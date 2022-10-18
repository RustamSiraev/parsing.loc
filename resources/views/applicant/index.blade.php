@extends('layouts.app', ['title' => 'Личный кабинет'])

@section('content')
    <div class="">
        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-2 border-primary">
                    <div class="card-header d-flex ">
                        <strong>Инструкция подачи электронного заявления:</strong>
                    </div>
                    <div class="card-body">
                        <p>1. Проверьте актуальность <a href="{{ route('applicant.edit') }}"
                                                        title="Редактировать">данных</a></p>
                        <p>2. Подайте заявление в личном кабинете, раздел - "<a title="Открыть"
                                                                                href="{{ route('applicant.statement.index') }}">Заявления</a>"
                        </p>
                        Чтобы узнать подробнее скачайте и изучите <a title="Скачать" target="_blank"
                                                                     href="{{ route('download', ['file' => '3.pdf']) }}">
                            инструкцию <i
                                class="bi bi-file-earmark-medical"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

