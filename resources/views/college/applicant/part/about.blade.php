<div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="about-tab">
    <form>
        <div class="user-add-form">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="parent_l_name">Фамилия</label>
                        <input type="text" class="form-control"
                               value="{{ $applicant->l_name ?? '' }}" disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="parent_f_name">Имя</label>
                        <input type="text" class="form-control"
                               value="{{ $applicant->f_name ?? '' }}" disabled>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="parent_m_name">Отчество</label>
                        <input type="text" class="form-control"
                               value="{{ $applicant->m_name ?? '' }}" disabled>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="parent_gender">Пол:</label>
                        <select class="form-control" disabled>
                            <option
                                @if ($applicant->gender == 1) selected @endif>
                                Мужской
                            </option>
                            <option
                                @if ($applicant->gender == 2) selected @endif>
                                Женский
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="born_at">Дата рождения</label>
                        <div class="rails-bootstrap-forms-date-select">
                            <input type="date"
                                   value="{{ Carbon\Carbon::createFromDate($applicant->born_at)->format('Y-m-d')  ?? '' }}"
                                   class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="parent_snils">СНИЛС:</label>
                        <input type="text" class="form-control"
                               value="{{ $applicant->snils ?? ''  }}" disabled>
                    </div>
                </div>
                <div class="col-sm-3 col-lg-3">
                    <div class="form-group">
                        <label class="control-label" for="citizenship">Гражданство</label>
                        <select class="form-control" disabled>
                            <option value="0" disabled>Выберите</option>
                            <option
                                @if ($applicant->citizenship == 1) selected @endif>
                                Гражданин РФ
                            </option>
                            <option
                                @if ($applicant->citizenship == 2) selected @endif>
                                Гражданин иностранного государства
                            </option>
                            <option
                                @if ($applicant->citizenship == 3) selected @endif>
                                Лицо без гражданства
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-lg-9">
                    <div class="form-group">
                        <label class="control-label" for="born_place">Место рождения</label>
                        <input class="form-control" type="text"
                               value="{{ $applicant->born_place ?? '' }}" disabled>
                    </div>
                </div>
            </div>
            <hr>
            <h4>Документы</h4>
            <div class="row">
                <div class="col-md-3 col-lg-3 document2">
                    <div class="form-group">
                        @php
                            $array = [
                                        1 => 'Свидетельство о рождении',
                                        2 => 'Паспорт гражданина РФ',
                                        3 => 'Временное удостоверение гражданина РФ',
                                        4 => 'Вид на жительства лица без гражданства',
                                        5 => 'Иностранный паспорт',
                                        6 => 'Заграничный паспорт гражданина РФ',
                                    ];
                        @endphp
                        <label class="control-label" for="doc_type">Тип документа</label>
                        <select class="form-control" disabled>
                            @foreach($array as $key=>$item)
                                <option @if ($applicant->doc_type == $key) selected @endif>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                        <label class="control-label" for="doc_seria">Серия документа</label>
                        <input class="form-control" type="text"
                               value="{{ $applicant->doc_seria ?? '' }}" disabled>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                        <label class="control-label" for="doc_number">Номер документа</label>
                        <input class="form-control" type="text"
                               value="{{ $applicant->doc_number ?? '' }}" disabled>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                        <label class="control-label" for="doc_date">Дата выдачи</label>
                        <div class="rails-bootstrap-forms-date-select">
                            <input type="date" disabled class="form-control"
                                   value="{{ Carbon\Carbon::createFromDate($applicant->doc_date)->format('Y-m-d') ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-9 col-lg-9">
                    <div class="form-group">
                        <label class="control-label" for="doc_response">Кем выдан</label>
                        <input class="form-control" type="text"
                               value="{{ $applicant->doc_response ?? '' }}"
                               disabled>
                    </div>
                </div>
            </div>
            <hr>
            <h4>Контакты</h4>
            <h5>Адрес регистрации</h5>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label" for="street">Населенный пункт, улица</label>
                        <select style="width: 100%" class="form-control" disabled>
                            <option
                                value="{{ $applicant->house->street->guid ?? '' }}"
                                selected>{{ $applicant->house->street->title ?? '' }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label" for="house_id">Дом</label>
                        <select style="width: 100%" class="form-control" disabled>
                            <option selected>{{ $applicant->house->house_num ?? '' }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label" for="flat">Квартира</label>
                        <input value="{{ $applicant->flat ?? '' }}" class="form-control" type="text" disabled>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control" disabled
                        {{ $applicant->matches ? 'checked' : '' }}>
                    <label class="custom-control-label" for="matches">Совпадает с адресом фактического
                        проживания</label>
                </div>
            </div>
            @if(!$applicant->matches)
            <br>
            <div class="row">
                <h5>Адрес фактического проживания</h5>
                <div class="col-md-8">
                    <div class="form-group">
                        <label class="control-label" for="fact_street">Населенный пункт, улица</label>
                        <select style="width: 100%" class="form-control" disabled>
                            <option selected>{{ $applicant->factHouse->street->title ?? '' }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label" for="fact_house_id">Дом</label>
                        <select style="width: 100%" class="form-control" disabled>
                            <option selected>{{ $applicant->factHouse->house_num ?? '' }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="control-label" for="fact_flat">Квартира</label>
                        <input class="form-control" value="{{ $applicant->fact_flat ?? '' }}" type="text">
                    </div>
                </div>
            </div>
            @endif
            <div class="row">
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                        <label class="control-label disabled" for="phone">Телефон</label>
                        <input class="form-control" type="text" disabled
                               value="{{ $applicant->getUser()->phone ?? '' }}" disabled>
                    </div>
                </div>
                <div class="col-md-3 col-lg-3">
                    <div class="form-group">
                        <label class="control-label" for="additional_contact">Дополнительный
                            контакт</label>
                        <input class="form-control" disabled type="text"
                               value="{{$applicant->additional_contact ?? '' }}">
                    </div>
                </div>
                <div class="col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="control-label" for="email">E-mail<span
                                class="text-muted">( Логин )</span></label>
                        <input class="form-control" type="email"
                               value="{{ $applicant->getUser()->email ?? '' }}" disabled>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
