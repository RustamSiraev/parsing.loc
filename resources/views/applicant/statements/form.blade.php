@csrf
@if(count($alerts) == 0)
    <div class="user-add-form" id="statement-create-form">
        <div class="row">
            <div class="col-md-7">
                <div class="form-group">
                    <h5>У Вас загружен <span id="doc_type">{{ $diploma->type() }}</span></h5>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control @error('first') is-invalid @enderror"
                               id="first" name="first" value="1" checked>
                        <label class="custom-control-label" for="first">Получаю среднее профессиональное образование
                            впервые</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label>Выберите образовательную организацию:</label>
                    <select id="college_id" class="form-control @error('college_id') is-invalid @enderror"
                            name="college_id" required>
                        <option value="" selected disabled>Выберите</option>
                        @foreach($colleges as $college)
                            <option value="{{ $college->id }}"
                                    @if (old('college_id') == $college->id) selected @endif>{{ $college->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Выберите форму обучения:</label>
                    <select id="education_form" class="form-control @error('education_form') is-invalid @enderror"
                            name="education_form" required disabled>
                        <option value="" selected disabled>Выберите образовательную организацию</option>
                    </select>
                    @error('child_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <span id="noForm"></span>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label>Выберите специальность:</label>
                    <select id="speciality_id" class="form-control @error('speciality_id') is-invalid @enderror"
                            name="speciality_id" required disabled>
                        <option value="" selected disabled>Выберите форму обучения</option>
                        @foreach($colleges as $college)
                            <option value="{{ $college->id }}"
                                    @if (old('speciality_id') == $college->id) selected @endif>{{ $college->title }}</option>
                        @endforeach
                    </select>
                    @error('speciality_id')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                    <span id="noSpeciality"></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control @error('target') is-invalid @enderror"
                               id="target" name="target" value="1" @if(old('target')){{ 'checked'  }}@endif>
                        <label class="custom-control-label" for="target"><h5>Целевой прием</h5></label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control @error('benefit') is-invalid @enderror"
                               id="benefit" name="benefit" value="1" @if(old('benefit')){{ 'checked'  }}@endif>
                        <label class="custom-control-label" for="benefit"><h5>Есть льготная категория</h5></label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control @error('limited') is-invalid @enderror"
                               id="limited" name="limited" value="1" @if(old('limited')){{ 'checked'  }}@endif>
                        <label class="custom-control-label" for="limited"><h5>Наличие ОВЗ</h5></label>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control @error('disabled') is-invalid @enderror"
                               id="disabled" name="disabled" value="1" @if(old('disabled')){{ 'checked'  }}@endif>
                        <label class="custom-control-label" for="disabled"><h5>Наличие инвалидности</h5></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control @error('agree') is-invalid @enderror"
                   id="agree" required name="agree" value="1" @if(old('agree')){{ 'checked'  }}@endif>
            <label class="custom-control-label" for="agree">Даю согласие на обработку
                <a href="#" title="Прочитать" id="agree">персональных данных</a></label>
            @error('agree')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <br>
        <div class="custom-control custom-checkbox" style="display: flex; position: relative">
            <input type="checkbox" class="custom-control @error('documents') is-invalid @enderror"
                   style="position: absolute; top: 30%;"
                   id="documents" required name="documents" value="1" @if(old('documents')){{ 'checked'  }}@endif>
            <label class="custom-control-label" for="documents" style="margin-left: 20px;">
                Я ознакомлен с Уставом, с лицензией на осуществление
                образовательной деятельности, со свидетельством об аккредитации, с образовательными программами,
                правилами приема и другими документами, регламентирующими организацию и осуществление образовательной
                деятельности, права и обязанности обучающихся</label>
            @error('documents')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <br>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control @error('deadlines') is-invalid @enderror" required
                   id="deadlines" name="deadlines" value="1" @if(old('deadlines')){{ 'checked'  }}@endif>
            <label class="custom-control-label" for="deadlines">Я ознакомлен со сроками предоставления оригиналов
                документов</label>
            @error('deadlines')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="d-flex btn-footer">
            <button type="submit" class="btn btn-primary btn-add-user">
                <i class="bi bi-save"></i>Подать заявление
            </button>
        </div>
    </div>
@else
    <div class="user-add-form" id="child-form">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <h4>У Вас не заполнены:</h4>
                    @foreach($alerts as $alert)
                        <h5><span class="text-danger">*</span>{{ $alert }}</h5>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

