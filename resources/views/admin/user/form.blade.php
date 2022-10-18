@csrf
<div class="user-add-form">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label required" for="parent_name">Имя пользователя:</label>
                <input id="name" type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       name="name" value="{{ old('name') ?? $user->name ?? '' }}" required autocomplete="name"
                       autofocus>
                @error('name')
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
                       name="email" value="{{ old('email') ?? $user->email ?? ''  }}" required autocomplete="email"
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
                       name="phone" value="{{ old('phone') ?? $user->phone ?? ''  }}" required autocomplete="phone"
                       autofocus>
                @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label required" for="parent_role_id">Роль:</label>
                @if((isset($user) &&  $user->role_id == 2 && !$user->isDirector()))
                    @php
                        $user->role_id = 3;
                    @endphp
                @endif
                <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror"
                        title="Роль" required
                        autocomplete="role_id"
                        autofocus>
                    <option value="">Выберите роль</option>
                    @if (count($roles))
                        @foreach($roles as $item)
                            <option value="{{ $item->id }}" @if (old('role_id') == $item->id || (isset($user) && $user->role_id == $item->id)) selected @endif>
                                {{ $item->name }}
                            </option>
                        @endforeach
                    @endif
                </select>
                @error('role_id')
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
                <label class="control-label required" for="parent_gender">Пол:</label>
                <select class="form-control @error('gender') is-invalid @enderror"
                        name="gender"
                        id="gender" required>
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
        <div class="col-md-3">
            <div class="form-group">
                <label class="control-label required" for="parent_email">Дата рождения:</label>
                <div class="rails-bootstrap-forms-date-select">
                    <input type="date" name="born_at" id="born_at"
                           max="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                           value="{{ old('born_at') ?? (isset($user) ? Carbon\Carbon::createFromDate($user->born_at)->format('Y-m-d') : '') ?? '' }}"
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
                       name="snils" value="{{ old('snils') ?? $user->snils ?? ''  }}" required autocomplete="snils"
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
        <div class="col-md-3 level-0 level-2 level-3"
             style="{{ in_array(old('role_id'), [2,3]) ||(isset($user) && in_array($user->role_id, [2,3])) ? '' : 'display: none'}}">
            <div class="form-group">
                <label class="control-label" for="parent_college_id">СПО:</label>
                <select name="college_id" class="college-search form-control @error('college_id') is-invalid @enderror"
                        title="СПО">
                    <option value="{{ old('college_id') ?? $user->college_id ?? '' }}"
                            selected>{{ $user->college->title ?? '' }}</option>
                </select>
                @error('college_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        @if(!isset($user))
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
        @endif
    </div>
    <div class="d-flex btn-footer">
        <button type="submit" class="btn btn-primary btn-add-user">
            <i class="bi bi-save"></i>Сохранить
        </button>
    </div>
</div>
