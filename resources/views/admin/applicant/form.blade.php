@csrf
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="search-form">
    <div class="row">
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label" for="parent_l_name">Фамилия</label>
                <input id="l_name" type="text"
                       class="form-control @error('l_name') is-invalid @enderror"
                       name="l_name" value="{{ old('l_name') ?? $applicant->l_name ?? '' }}" required
                       autocomplete="l_name"
                       autofocus>
                @error('l_name')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                @enderror
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label" for="parent_f_name">Имя</label>
                <input id="f_name" type="text"
                       class="form-control @error('f_name') is-invalid @enderror"
                       name="f_name" value="{{ old('f_name') ?? $applicant->f_name ?? '' }}" required
                       autocomplete="f_name" autofocus>
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
                       autocomplete="m_name" autofocus>
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
                        name="gender"
                        id="gender" required>
                    <option value="1"
                            @if ((isset($applicant) && $applicant->gender == 1) || old('gender') == 1) selected @endif>
                        Мужской
                    </option>
                    <option value="2"
                            @if ((isset($applicant) && $applicant->gender == 2) || old('gender') == 2) selected @endif>
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
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label required" for="parent_email">Дата рождения:</label>
                <div class="rails-bootstrap-forms-date-select">
                    <input type="date" name="born_at" id="born_at"
                           max="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                           value="{{ old('born_at') ?? (isset($applicant) ? Carbon\Carbon::createFromDate($applicant->born_at)->format('Y-m-d') : '') ?? '' }}"
                           pattern="[0-9]{2}.[0-9]{2}.[0-9]{4}"
                           class="form-control birth-day @error('born_at') is-invalid @enderror"
                           required>
                    @error('born_at')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label required" for="parent_snils">СНИЛС:</label>
                <input id="snils" type="text"
                       class="form-control @error('snils') is-invalid @enderror"
                       name="snils" value="{{ old('snils') ?? $applicant->snils ?? ''  }}" required autocomplete="snils"
                       autofocus maxlength="11" pattern="[0-9]{11}"
                       title="11 цифр"
                       onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                @error('snils')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label required" for="parent_email">E-mail:</label>
                <input id="email" type="text"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') ?? (isset($applicant) ? $applicant->getUser()->email : '') ?? ''  }}" required autocomplete="email"
                       autofocus>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label required" for="parent_phone">Телефон:</label>
                <input id="phone" type="text"
                       class="form-control @error('phone') is-invalid @enderror"
                       name="phone" value="{{ old('phone') ?? (isset($applicant) ? $applicant->getUser()->phone : '') ?? ''  }}" required autocomplete="phone"
                       autofocus>
                @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    @if(!isset($applicant))
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label required" for="new-password">Пароль:</label>
                    <input id="new-password" type="password"
                           class="form-control @error('new-password') is-invalid @enderror"
                           name="new-password" value="{{ old('new-password') ?? '' }}" required
                           autocomplete="new-password"
                           autofocus>
                    <span class="message-label">
                        Пароль должен быть 8 и более символов, содержать минимум одну строчную и одну прописную букву латинского алфавита и одну цифру.
                    </span>
                    @error('new-password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label required" for="new-password-confirm">Повторите пароль:</label>
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
        <div class="custom-control custom-checkbox">
            <input type="hidden" name="edit-agree" value="0">
            <input type="checkbox" class="custom-control @error('agree') is-invalid @enderror"
                   id="agree"
                   required name="agree"
                   value="1" @if(old('agree')){{ 'checked'  }}@endif>
            <label class="custom-control-label" for="agree">Получено согласие на обработку
                <a href="#" title="Прочитать" id="agree">персональных данных</a></label>
            @error('agree')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    @endif
    <div class="d-flex btn-footer">
        <button type="submit" class="btn btn-primary btn-add-user">
            <i class="bi bi-save"></i>Сохранить
        </button>
    </div>
</div>
