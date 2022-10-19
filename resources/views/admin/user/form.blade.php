@csrf
<div class="search-form">
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
        @if(!isset($user))
            <div class="col-md-3">
                <div class="form-group">
                    <label class="control-label required" for="new-password">Пароль:</label>
                    <input id="new-password" type="password"
                           class="form-control @error('new-password') is-invalid @enderror"
                           name="new-password" value="{{ old('new-password') ?? '' }}" required
                           autocomplete="new-password"
                           autofocus>
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
