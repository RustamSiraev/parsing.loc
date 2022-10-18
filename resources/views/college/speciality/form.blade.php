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
<div class="user-add-form">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="education_level">Уровень образования</label>
                <select class="form-control @error('education_level') is-invalid @enderror"
                        name="education_level" id="education_level" required>
                    <option value="1"
                            @if ((isset($speciality) && $speciality->education_level == 1) || old('education_level') == 1) selected @endif>
                        Основное общее (9 классов)
                    </option>
                    <option value="2"
                            @if ((isset($speciality) && $speciality->education_level == 2) || old('education_level') == 2) selected @endif>
                        Среднее общее (11 классов)
                    </option>
                </select>
                @error('education_level')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="education_form">Форма обучения</label>
                <select class="form-control @error('education_form') is-invalid @enderror"
                        name="education_form" id="education_form" required>
                    <option value="1"
                            @if ((isset($speciality) && $speciality->education_form == 1) || old('education_form') == 1) selected @endif>
                        Очная
                    </option>
                    <option value="2"
                            @if ((isset($speciality) && $speciality->education_form == 2) || old('education_form') == 2) selected @endif>
                        Очно-заочная
                    </option>
                    <option value="3"
                            @if ((isset($speciality) && $speciality->education_form == 3) || old('education_form') == 3) selected @endif>
                        Заочная
                    </option>
                </select>
                @error('education_form')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="code">Код специальности</label>
                <input id="code" type="text"
                       class="form-control @error('code') is-invalid @enderror"
                       name="code" value="{{ old('code') ?? $speciality->code ?? ''  }}" required
                       autocomplete="code"
                       autofocus>
                @error('code')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="status">Статус</label>
                <select class="form-control @error('status') is-invalid @enderror"
                        name="status" id="status" required>
                    <option value="1"
                            @if ((isset($speciality) && $speciality->education_level == 1) || old('education_level') == 1) selected @endif>
                        Активна
                    </option>
                    <option value="0"
                            @if ((isset($speciality) && $speciality->education_level == 0) || old('education_level') == 2) selected @endif>
                        Заблокирована
                    </option>
                </select>
                @error('education_level')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin-bottom: 0;">
            <div class="form-group">
                <label class="control-label" for="name">Наименование специальности</label>
                <textarea name="name" id="name" cols="30" rows="2"
                          class="form-control @error('name') is-invalid @enderror">{{ old('name') ?? $speciality->name ?? '' }} </textarea>
                @error('name')
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
                <label class="control-label" for="budgetary">Бюджетных мест</label>
                <input id="budgetary" type="text"
                       class="form-control @error('budgetary') is-invalid @enderror"
                       name="budgetary" value="{{ old('budgetary') ?? $speciality->budgetary ?? ''  }}" required
                       autocomplete="budgetary" onkeyup="this.value=this.value.replace(/[^\d]/,'')"
                       autofocus>
                @error('budgetary')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="commercial">Внебюджетных мест</label>
                <input id="commercial" type="text"
                       class="form-control @error('commercial') is-invalid @enderror"
                       name="commercial" value="{{ old('commercial') ?? $speciality->commercial ?? ''  }}" required
                       autocomplete="commercial" onkeyup="this.value=this.value.replace(/[^\d]/,'')"
                       autofocus>
                @error('commercial')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="education_time">Срок обучения в месяцах</label>
                <input id="education_time" type="text"
                       class="form-control @error('education_time') is-invalid @enderror"
                       name="education_time" value="{{ old('education_time') ?? $speciality->education_time ?? ''  }}"
                       required
                       autocomplete="education_time" onkeyup="this.value=this.value.replace(/[^\d]/,'')"
                       autofocus>
                @error('education_time')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label" for="education_cost">Стоимость обучения за год</label>
                <input id="education_cost" type="text"
                       class="form-control @error('education_cost') is-invalid @enderror"
                       name="education_cost" value="{{ old('education_cost') ?? $speciality->education_cost ?? ''  }}"
                       required
                       autocomplete="education_cost" onkeyup="this.value=this.value.replace(/[^\d]/,'')"
                       autofocus>
                @error('education_cost')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="d-flex btn-footer">
        <button type="submit" class="btn btn-primary btn-add-user">
            <i class="bi bi-save"></i>Сохранить
        </button>
    </div>
</div>
