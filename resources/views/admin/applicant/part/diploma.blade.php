<div class="tab-pane fade show" id="diploma" role="tabpanel" aria-labelledby="diploma-tab">
    <form>
        @if($diploma)
            <div class="search-form">
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
                            <label>Тип документа</label>
                            <input class="form-control" type="text"
                                   disabled value="{{ $array[$diploma->doc_type] ?? '' }}">
                        </div>
                    </div>
                    @if($diploma->doc_series)
                        <div class="col-md-2 level-1">
                            <div class="form-group">
                                <label>Серия документа</label>
                                <input class="form-control" type="text"
                                       disabled value="{{ $diploma->doc_series ?? '' }}">
                            </div>
                        </div>
                    @endif
                    <div class="col-md-2 level-2">
                        <div class="form-group">
                            <label>Номер документа</label>
                            <input class="form-control" type="text"
                                   value="{{ $diploma->doc_number ?? '' }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>Дата выдачи</label>
                            <div class="rails-bootstrap-forms-date-select">
                                <input type="text"
                                       value="{{ date('d.m.Y', strtotime($diploma->doc_date)) ?? '' }}"
                                       class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Выдан</label>
                            <input class="form-control" type="text"
                                   value="{{ $diploma->doc_issued ?? '' }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="grade-block">
                    @if(isset($grades))
                        <input type="hidden" value="{{ count($grades) }}" id="index">
                        @foreach($grades as $key=>$grade)
                            <div class="row subject_item">
                                <div class="col-md-11 subject_name">
                                    <div class="subject_grade grade-name">
                                        <h5>{{ $grade['name'] }}</h5>
                                        @if($grade['text'] != 0)
                                            <h5 class="grade-text">
                                                <input type="text" class="additional-text" disabled
                                                       value="{{ $grade['text'] ?? '' }}">
                                            </h5>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <input class="form-control grade-score" type="number" disabled
                                               value="{{ $grade['score'] }}">
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
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
                                <input class="form-control average" value="{{ $diploma->average ?? '' }}" id="average" type="text" disabled>
                                <input class="form-control average" value="" type="hidden" name="average">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="search-form">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Данные не загружены</h2>
                    </div>
                </div>
            </div>
        @endif
    </form>
</div>
