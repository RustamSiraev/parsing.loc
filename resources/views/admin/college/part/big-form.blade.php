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
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label" for="full_title">Полное наименование:</label>
                <input id="full_title" type="text"
                       class="form-control @error('full_title') is-invalid @enderror"
                       name="full_title" value="{{ old('full_title') ?? $college->full_title ?? '' }}" required
                       autocomplete="full_title"
                       autofocus>
                @error('full_title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="title">Краткое наименование:</label>
                <input id="title" type="text"
                       class="form-control @error('title') is-invalid @enderror"
                       name="title" value="{{ old('title') ?? $college->title ?? ''  }}" required autocomplete="title"
                       autofocus>
                @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="parent_director_id">Директор:</label>
                @php
                    $director_id = old('director_id') ?? $college->director_id ?? 0;
                @endphp
                <select name="director_id" class="director-search form-control @error('director_id') is-invalid @enderror"
                        title="Директор">
                    <option value="">Выберите директора</option>
                    @if (count($directors))
                        @include('admin.college.part.director', ['items' => $directors, 'level' => -1])
                    @endif
                </select>
                @error('director_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="col-sm-4">
            <div class="form-group">
                <label class="control-label" for="status">Статус</label>
                <select class="form-control @error('status') is-invalid @enderror"
                        name="status"
                        id="status" required>
                    <option value="1"
                            @if ((isset($college) && $college->status == 1) || old('status') == 1) selected @endif>
                        Активен
                    </option>
                    <option value="2"
                            @if ((isset($college) && $college->status == 2) || old('status') == 2) selected @endif>
                        Заблокирован
                    </option>
                    <option value="3"
                            @if ((isset($college) && $college->status == 3) || old('status') == 3) selected @endif>
                        Удален
                    </option>
                </select>
                @error('status')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <h4>Контактная информация</h4>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label" for="jur_address">Юридический адрес</label>
                    <select name="jur_address" id="jur_address" style="width: 100%"
                            class="form-control select2-hidden-accessible @error('jur_address') is-invalid @enderror"
                            required data-select2-id="jur_address">
                        <option value="{{ old('jur_address') ?? $college->jur_address ?? '' }}"
                                selected>{{ old('jur_address') ?? $college->jur_address ?? '' }}</option>
                    </select>
                    @error('jur_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="control-label" for="post_address">Фактический адрес</label>
                    <select name="post_address" id="post_address" style="width: 100%"
                            class="form-control select2-hidden-accessible @error('post_address') is-invalid @enderror"
                            required data-select2-id="post_address">
                        <option value="{{ old('post_address') ?? $college->post_address ?? '' }}"
                                selected>{{ old('post_address') ?? $college->post_address ?? '' }}</option>
                    </select>
                    @error('post_address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="phone">Телефон</label>
                    <input id="phone" type="text"
                           class="form-control @error('phone') is-invalid @enderror"
                           name="phone" value="{{ old('phone') ?? $college->phone ?? '' }}" required
                           autocomplete="phone"
                           autofocus>
                    @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="control-label" for="email">E-mail</label>
                    <input id="email" type="text"
                           class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') ?? $college->email ?? '' }}" required
                           autocomplete="email"
                           autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control-label" for="inn">ИНН</label>
                <input id="inn" type="text"
                       class="form-control @error('inn') is-invalid @enderror"
                       name="inn" value="{{ old('inn') ?? $college->inn ?? '' }}" required
                       autocomplete="inn" maxlength="10" pattern="[0-9]{10}"
                       title="10 цифр"
                       autofocus onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                @error('inn')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control-label" for="kpp">КПП</label>
                <input id="kpp" type="text"
                       class="form-control @error('kpp') is-invalid @enderror"
                       name="kpp" value="{{ old('kpp') ?? $college->kpp ?? '' }}" required
                       autocomplete="kpp" maxlength="9" pattern="[0-9]{9}"
                       title="9 цифр"
                       autofocus onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                @error('kpp')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control-label" for="ogrn">ОГРН</label>
                <input id="ogrn" type="text"
                       class="form-control @error('ogrn') is-invalid @enderror"
                       name="ogrn" value="{{ old('ogrn') ?? $college->ogrn ?? '' }}" required
                       autocomplete="ogrn" maxlength="13" pattern="[0-9]{13}"
                       title="13 цифр"
                       autofocus onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                @error('ogrn')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <hr>
    <h4>Банковские реквизиты</h4>
    <div class="row">
        <div class="col-sm-12">
            <div class="form-group">
                <label class="control-label" for="bank_name">Наименование банка</label>
                <input id="bank_name" type="text"
                       class="form-control @error('bank_name') is-invalid @enderror"
                       name="bank_name" value="{{ old('bank_name') ?? $college->bank_name ?? '' }}" required
                       autocomplete="bank_name"
                       autofocus>
                @error('bank_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control-label" for="bank_bik">БИК</label>
                <input id="bank_bik" type="text"
                       class="form-control @error('bank_bik') is-invalid @enderror"
                       name="bank_bik" value="{{ old('bank_bik') ?? $college->bank_bik ?? '' }}" required
                       autocomplete="bank_bik"  maxlength="9" pattern="[0-9]{9}"
                       title="9 цифр"
                       autofocus onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                @error('bank_bik')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control-label" for="c_acc">Корреспондентский счет</label>
                <input id="c_acc" type="text"
                       class="form-control @error('c_acc') is-invalid @enderror"
                       name="c_acc" value="{{ old('c_acc') ?? $college->c_acc ?? '' }}" required
                       autocomplete="c_acc" maxlength="20" pattern="[0-9]{20}"
                       title="20 цифр"
                       autofocus onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                @error('c_acc')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group">
                <label class="control-label" for="okpo">Код ОКПО</label>
                <input id="okpo" type="text"
                       class="form-control @error('okpo') is-invalid @enderror"
                       name="okpo" value="{{ old('okpo') ?? $college->okpo ?? '' }}" required
                       autocomplete="okpo"  maxlength="10" pattern="[0-9]{10}"
                       title="10 цифр"
                       autofocus onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                @error('okpo')
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
                <label class="control-label" for="ek_acc">Единый казначейский счет</label>
                <input id="ek_acc" type="text"
                       class="form-control @error('ek_acc') is-invalid @enderror"
                       name="ek_acc" value="{{ old('ek_acc') ?? $college->ek_acc ?? '' }}" required
                       autocomplete="ek_acc"
                       autofocus onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                @error('ek_acc')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label" for="k_acc">Казначейский счет</label>
                <input id="k_acc" type="text"
                       class="form-control @error('k_acc') is-invalid @enderror"
                       name="k_acc" value="{{ old('k_acc') ?? $college->k_acc ?? '' }}" required
                       autocomplete="k_acc"
                       autofocus onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                @error('k_acc')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label" for="bl_acc">Лицевой счет (бюджетный)</label>
                <input id="bl_acc" type="text"
                       class="form-control @error('bl_acc') is-invalid @enderror"
                       name="bl_acc" value="{{ old('bl_acc') ?? $college->bl_acc ?? '' }}" required
                       autocomplete="bl_acc"
                       autofocus onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                @error('bl_acc')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-sm-3">
            <div class="form-group">
                <label class="control-label" for="l_acc">Лицевой счет (внебюджетный)</label>
                <input id="l_acc" type="text"
                       class="form-control @error('l_acc') is-invalid @enderror"
                       name="l_acc" value="{{ old('l_acc') ?? $college->l_acc ?? '' }}" required
                       autocomplete="l_acc"
                       autofocus onkeyup="this.value=this.value.replace(/[^\d]/,'')">
                @error('l_acc')
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
