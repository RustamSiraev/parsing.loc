@csrf
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label class="control-label" for="parent_l_name">Фамилия <span
                    class="text-danger">*</span></label>
            <input id="l_name" type="text"
                   class="form-control @error('l_name') is-invalid @enderror"
                   name="l_name" value="{{ old('l_name') ?? $applicant->l_name ?? '' }}" required
                   autocomplete="l_name" maxlength="20" autofocus
                   onkeyup="this.value=this.value.replace(/[^А-Яа-яЁё]/gi,'')">
            @error('l_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="control-label" for="parent_f_name">Имя <span
                    class="text-danger">*</span></label>
            <input id="f_name" type="text"
                   class="form-control @error('f_name') is-invalid @enderror"
                   name="f_name" value="{{ old('f_name') ?? $applicant->f_name ?? '' }}" required
                   autocomplete="f_name" maxlength="15" autofocus
                   onkeyup="this.value=this.value.replace(/[^А-Яа-яЁё]/gi,'')">
            @error('f_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="control-label" for="parent_m_name">Отчество</label>
            <input id="m_name" type="text"
                   class="form-control @error('m_name') is-invalid @enderror"
                   name="m_name" value="{{ old('m_name') ?? $applicant->m_name ?? '' }}"
                   autocomplete="m_name" maxlength="20" autofocus
                   onkeyup="this.value=this.value.replace(/[^А-Яа-яЁё]/gi,'')">
            @error('m_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label required" for="parent_gender">Пол:</label>
            <select class="form-control @error('gender') is-invalid @enderror"
                    name="gender" id="gender" required>
                <option value="1"
                        @if ((isset($user) && $user->gender == 1) || old('gender') == 1) selected @endif>
                    Мужской
                </option>
                <option value="2"
                        @if ((isset($user) && $user->gender == 2) || old('gender') == 2) selected @endif>
                    Женский
                </option>
            </select>
            @error('gender')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <div class="form-group">
            <label class="control-label" for="born_at">Дата рождения<span
                    class="text-danger">*</span></label>
            <div class="rails-bootstrap-forms-date-select">
                <input type="date" name="born_at" onkeydown="return false"
                       max="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                       value="{{ old('born_at') ?? (isset($applicant) ? Carbon\Carbon::createFromDate($applicant->born_at)->format('Y-m-d') : '') ?? '' }}"
                       pattern="[0-9]{2}.[0-9]{2}.[0-9]{4}"
                       class="form-control @error('born_at') is-invalid @enderror" required>
                @error('born_at')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            @error('born_at')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            <label class="control-label required" for="parent_snils">СНИЛС:</label>
            <input id="snils" type="text"
                   class="form-control @error('snils') is-invalid @enderror"
                   name="snils" value="{{ old('snils') ?? $applicant->snils ?? ''  }}" required autocomplete="snils"
                   autofocus maxlength="11" pattern="[0-9]{11}" title="11 цифр"
                   onkeyup="this.value=this.value.replace(/[^\d]/,'')">
            @error('snils')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-sm-3 col-lg-3">
        <div class="form-group">
            <label class="control-label" for="citizenship">Гражданство<span
                    class="text-danger">*</span></label>
            <select class="form-control @error('citizenship') is-invalid @enderror"
                    name="citizenship" id="citizenship" required>
                <option value="0" disabled>Выберите</option>
                <option value="1"
                        @if ((isset($applicant) && $applicant->citizenship == 1) || old('citizenship') == 1) selected @endif>
                    Гражданин РФ
                </option>
                <option value="2"
                        @if ((isset($applicant) && $applicant->citizenship == 2) || old('citizenship') == 2) selected @endif>
                    Гражданин иностранного государства
                </option>
                <option value="3"
                        @if ((isset($applicant) && $applicant->citizenship == 3) || old('citizenship') == 3) selected @endif>
                    Лицо без гражданства
                </option>
            </select>
            @error('citizenship')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-9 col-lg-9">
        <div class="form-group">
            <label class="control-label" for="born_place">Место рождения <span
                    class="text-danger">*</span></label>
            <input class="form-control @error('born_place') is-invalid @enderror" type="text"
                   name="born_place" id="born_place"
                   value="{{ old('born_place') ?? $applicant->born_place ?? '' }}" required>
            @error('born_place')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
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
            <label class="control-label" for="doc_type">Тип документа <span class="text-danger">*</span></label>
            <select class="form-control @error('doc_type') is-invalid @enderror"
                    id="doc_type" name="doc_type" required>
                <option value="0" disabled>Выберите</option>
                @foreach($array as $key=>$item)
                    <option value="1"
                            @if ((isset($applicant) && $applicant->doc_type == $key) || old('doc_type') == $key) selected @endif>
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
    <div class="col-md-3 col-lg-3">
        <div class="form-group">
            <label class="control-label" for="doc_seria">Серия документа</label>
            <input class="form-control @error('doc_seria') is-invalid @enderror" type="text"
                   name="doc_seria" id="doc_seria" value="{{ old('doc_seria') ?? $applicant->doc_seria ?? '' }}">
            @error('doc_seria')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-lg-3">
        <div class="form-group">
            <label class="control-label" for="doc_number">Номер документа <span class="text-danger">*</span></label>
            <input class="form-control @error('doc_number') is-invalid @enderror" type="text"
                   name="doc_number" value="{{ old('doc_number') ?? $applicant->doc_number ?? '' }}"
                   id="doc_number" required>
            @error('doc_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-lg-3">
        <div class="form-group">
            <label class="control-label" for="doc_date">Дата выдачи<span
                    class="text-danger">*</span></label>
            <div class="rails-bootstrap-forms-date-select">
                <input type="date" name="doc_date"
                       max="{{ Carbon\Carbon::now()->format('Y-m-d') }}" onkeydown="return false"
                       value="{{ old('doc_date') ?? (isset($applicant) ? Carbon\Carbon::createFromDate($applicant->doc_date)->format('Y-m-d') : '') ?? '' }}"
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
    <div class="col-md-9 col-lg-9">
        <div class="form-group">
            <label class="control-label" for="doc_response">Кем выдан <span
                    class="text-danger">*</span></label>
            <input class="form-control @error('doc_response') is-invalid @enderror" type="text"
                   name="doc_response" id="doc_response"
                   value="{{ old('doc_response') ?? $applicant->doc_response ?? '' }}"
                   required>
            @error('doc_response')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
</div>
<hr>

<h4>Контакты</h4>
<h5>Адрес фактического проживания</h5>
<div class="row">
    <div class="col-md-8">
        <div class="form-group">
            <label class="control-label" for="street">Населенный пункт, улица <span
                    class="text-danger">*</span></label>
            <select name="street_id" id="street" style="width: 100%"
                    class="form-control select2-hidden-accessible @error('street_id') is-invalid @enderror"
                    required
                    data-select2-id="street">
                <option
                    value="{{ old('street_id') ?? $applicant->house->street->guid ?? '' }}"
                    selected>{{ old('city_street') ?? $applicant->house->street->title ?? '' }}</option>
            </select>
            @error('street_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <input name="city_street" type="hidden" id="city_street"
                   value="{{ old('city_street') ?? $applicant->house->street->title ?? '' }}">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label" for="house_id">Дом</label>
            <select id="house" style="width: 100%"
                    class="form-control select2-hidden-accessible @error('house_id') is-invalid @enderror"
                    name="house_id"
                    required data-select2-id="house" tabindex="-1" aria-hidden="true">
                <option selected
                        value="{{ old('house_id') ?? $applicant->house->id ?? '' }}">{{ old('house_num') ?? $applicant->house->house_num ?? '' }}</option>
            </select>
            @error('house_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
            <input name="house_num" type="hidden" id="house_num"
                   value="{{ old('house_num') ?? $applicant->house->house_num ?? '' }}">
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label" for="flat">Квартира</label>
            <input placeholder="Номер квартиры" value="{{ old('flat') ?? $applicant->flat ?? '' }}"
                   class="form-control" type="text"
                   name="flat" id="flat">
        </div>
    </div>
</div>

<input type="hidden" name="edit-matches" value="0">
<input type="hidden" class="custom-control" id="matches" name="matches"
{{ ((isset($applicant) && $applicant->matches )|| !isset($applicant)) ? 'checked' : '' }} value="1">

<div class="row">
    <div class="col-md-3 col-lg-3">
        <div class="form-group">
            <label class="control-label required" for="phone">Телефон <span
                    class="text-danger">*</span></label>
            <input class="form-control @error('phone') is-invalid @enderror" type="text"
                   value="{{ old('phone') ?? (isset($applicant) ? $applicant->getUser()->phone : '') ?? '' }}"
                   name="phone" id="phone"
                   required>
            @error('phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    <div class="col-md-3 col-lg-3">
        <div class="form-group">
            <label class="control-label" for="additional_contact">Дополнительный
                контакт</label>
            <input class="form-control @error('additional_contact') is-invalid @enderror"
                   type="text" maxlength="16"
                   name="additional_contact"
                   value="{{ old('additional_contact') ?? $applicant->additional_contact ?? '' }}"
                   id="additional_contact">
            @error('additional_contact')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>
    @if(!isset($parent))
        <div class="col-md-6 col-lg-6">
            <div class="form-group">
                <label class="control-label" for="email">E-mail <span
                        class="text-danger">* </span><span
                        class="text-muted">( Логин )</span></label>
                <input class="form-control @error('email') is-invalid @enderror" type="email"
                       value="{{ old('email') ?? (isset($applicant) ? $applicant->getUser()->email : '') ?? '' }}"
                       name="email" id="email"
                       required autocomplete="email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
        </div>
    @endif
</div>

@if(!isset($applicant))
    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label" for="password">Пароль<span
                        class="text-danger">*</span></label>
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password"
                       value="{{ old('password') ?? '' }}"
                       required minlength="8">
                <span class="message-label">
                    Пароль должен быть 8 и более символов, содержать минимум одну строчную и одну прописную букву латинского алфавита и одну цифру.
                </span>
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label" for="password-confirm">Повторите пароль<span
                        class="text-danger">*</span></label>
                <input id="password-confirm" type="password"
                       class="form-control @error('password-confirm') is-invalid @enderror"
                       value="{{ old('password-confirm') ?? '' }}"
                       name="password-confirm" required minlength="8">
                @error('password-confirm')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>

    <div class="custom-control custom-checkbox">
        <input type="hidden" name="edit-agree" value="0">
        <input type="checkbox" class="custom-control @error('agree') is-invalid @enderror"
               id="agree"
               required name="agree"
               value="1" @if(old('agree')){{ 'checked'  }}@endif>
        <label class="custom-control-label" for="agree">{{ Request::is('*admin*') ? 'Получено' : 'Даю' }} согласие на
            обработку
            <a href="#" title="Прочитать" id="agreement">персональных данных</a></label>
        @error('agree')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
@endif
