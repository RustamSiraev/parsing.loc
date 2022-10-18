@extends('layouts.app', ['title' => 'Личный кабинет -> Аттестат'])

@section('content')
    <div class="page-title">
        <h1>Аттестат</h1>
    </div>
    <form method="post" id="diploma-form" action="{{ route('diploma.update') }}" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="user-add-form" id="child-form">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        @php
                            $array = [
                                        1 => 'Аттестат об основном общем образовании РФ выданный до 2014',
                                        2 => 'Аттестат об основном общем образовании РФ выданный с 2014',
                                        3 => 'Аттестат о полном общем образовании РФ выданный до 2014',
                                        4 => 'Аттестат о полном общем образовании РФ выданный с 2014',
                                        5 => 'Аттестат иностранного государства',
                                    ];
                        @endphp
                        <label>Тип документа <span class="text-danger">*</span></label>
                        <select id="doc_type" class="form-control @error('doc_type') is-invalid @enderror"
                                name="doc_type" required id="doc_type">
                            <option value="">Выберите</option>
                            @foreach($array as $key=>$item)
                                <option value="{{ $key }}"
                                        @if ((isset($diploma) && $diploma->doc_type == $key) || old('doc_type') == $key) selected @endif>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                        @error('doc_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2 level-1">
                    <div class="form-group">
                        <label>Серия документа <span class="text-danger">*</span></label>
                        <input class="form-control @error('doc_series') is-invalid @enderror" type="text"
                               name="doc_series" value="{{ old('doc_series') ?? $diploma->doc_series ?? '' }}"
                               id="doc_series" required>
                        @error('doc_series')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2 level-2">
                    <div class="form-group">
                        <label>Номер документа <span class="text-danger">*</span></label>
                        <input class="form-control @error('doc_number') is-invalid @enderror" type="text"
                               name="doc_number" value="{{ old('doc_number') ?? $diploma->doc_number ?? '' }}"
                               id="doc_number" required>
                        @error('doc_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>Дата выдачи <span class="text-danger">*</span></label>
                        <div class="rails-bootstrap-forms-date-select">
                            <input type="date" name="doc_date"
                                   max="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                   value="{{ old('doc_date') ?? (isset($diploma) ? Carbon\Carbon::createFromDate($diploma->doc_date)->format('Y-m-d') : '') ?? '' }}"
                                   pattern="[0-9]{2}.[0-9]{2}.[0-9]{4}"
                                   class="form-control @error('doc_date') is-invalid @enderror"
                                   required>
                            @error('doc_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Выдан <span class="text-danger">*</span></label>
                        <input class="form-control @error('doc_issued') is-invalid @enderror" type="text"
                               name="doc_issued" value="{{ old('doc_issued') ?? $diploma->doc_issued ?? '' }}"
                               id="doc_issued" required>
                        @error('doc_issued')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="grade-block">
                @if(isset($grades))
                    <input type="hidden" value="{{ count($grades) }}" id="index">
                    @foreach($grades as $key=>$grade)
                        <div class="row subject_item">
                            <div class="col-md-10 subject_name">
                                <div class="subject_grade grade-name">
                                    <h5>{{ $grade['name'] }}</h5>
                                    @if($grade['text'] != 0)
                                        <h5 class="grade-text">
                                            <input type="text" class="additional-text"
                                                   data-index="{{$key+1}}" value="{{ $grade['text'] ?? '' }}">
                                        </h5>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-1">
                                <div class="form-group">
                                    <input type="hidden" name="grade_name[{{$key+1}}]" value="{{ $grade['name'] }}">
                                    <input type="hidden" name="grade_text[{{$key+1}}]" value="{{ $grade['text'] ?? 0 }}"
                                           id="text-{{$key+1}}">
                                    <input class="form-control grade-score" type="number"
                                           name="grade_score[{{$key+1}}]" value="{{ $grade['score'] }}"
                                           id="grade-score[{{$key+1}}]" min="0" max="5">
                                </div>
                            </div>
                            <div class="col-md-1" style="position:relative;padding-bottom:0;">
                                <span class="text-frame subject-delete"
                                      title="Вы можете удалить предмет из списка, если он отсутствует в Вашем аттестате"><i
                                        class="bi bi-trash-fill"></i></span>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="">
                        <h5 class="">Если в списке отсутствует предмет, Вы можете его добавить</h5>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <button type="button" class="btn btn-primary btn-add-user" style="width: 100%"
                                data-bs-toggle="modal" data-bs-target="#dataAdditionModal">
                            <i class="bi bi-plus-lg"></i>Добавить предмет
                        </button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-11">
                    <div class="">
                        <h3 class="">Средний балл аттестата:</h3>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="form-group">
                        <div class="form-group">
                            <input class="form-control average" value="" id="average"  type="text" disabled>
                            <input class="form-control average" value="" type="hidden" name="average">
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex btn-footer">
                <button type="submit" class="btn btn-primary btn-add-user">
                    <i class="bi bi-save"></i>Сохранить
                </button>
            </div>
        </div>
    </form>
@endsection

<div id="dataAdditionModal" class="modal" role="dialog" aria-labelledby="dataAdditionLabel" aria-hidden="true"
     style="display: none;" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Добавление предмета
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="adding-name">Название предмета:</label>
                        <input id="adding-name" type="text"
                               class="form-control" name="adding-name" value="" autofocus>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="adding-text">Дополнительное поле (при необходимости):</label>
                        <input id="adding-text" type="text"
                               class="form-control" name="adding-text" value="" autofocus>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" id="subject-addition" disabled
                        class="btn btn-danger delete-button subject-add" data-bs-dismiss="modal" data-id="">Добавить
                </button>
            </div>
        </div>
    </div>
</div>

