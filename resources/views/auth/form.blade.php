@csrf
<div class="mb-3 row">
    <label for="name" class="col-md-4 col-form-label text-end">
        {{ __('Name') }}:
    </label>
    <div class="col-md-6">
        <input id="name" type="text"
               class="form-control @error('name') is-invalid @enderror"
               name="name" value="{{ old('name') ?? $user->name ?? '' }}" required autocomplete="name"
               autofocus onkeyup="this.value=this.value.replace(/[^A-aZ-zА-Яа-яЁё]/gi,'')">
        @error('name')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

<div class="mb-3 row">
    <label for="phone" class="col-md-4 col-form-label text-end">
        {{ __('Phone') }}:
    </label>
    <div class="col-md-6">
        <input id="phone" type="text"
               class="form-control @error('phone') is-invalid @enderror"
               name="phone" value="{{ old('phone') ?? $user->phone ?? '' }}" required autocomplete="phone"
               autofocus>
        @error('phone')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>

@role('root')
<div class="mb-3 row">
    <label for="password-confirm" class="col-md-4 col-form-label text-end">
        {{ __('Choose a role') }}:
    </label>
    <div class="col-md-6">
        <select name="role_id" id="role_id" class="form-control @error('role_id') is-invalid @enderror"
                title="{{ __('Role') }}" required
                autocomplete="role_id"
                autofocus>
            <option value="">{{ __('Choose a role') }}</option>
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

<div class="mb-3 row">
    <label for="email" class="col-md-4 col-form-label text-end">
        {{ __('E-Mail') }}:
    </label>
    <div class="col-md-6">
        <input id="email" type="email"
               class="form-control @error('email') is-invalid @enderror"
               name="email" value="{{ old('email') ?? $user->email ?? '' }}" required autocomplete="email"
               autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
</div>
@endRole

@if(!isset($user))
    <div class="mb-3 row">
        <label for="password" class="col-md-4 col-form-label text-end">
            {{ __('Password') }}:
        </label>
        <div class="col-md-6">
            <input id="password" type="password"
                   class="form-control @error('password') is-invalid @enderror" name="password"
                   required autocomplete="current-password" minlength="8">
            @error('password')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
    </div>

    <div class="mb-3 row">
        <label for="password-confirm" class="col-md-4 col-form-label text-end">
            {{ __('Confirm Password') }}:
        </label>
        <div class="col-md-6">
            <input id="password-confirm" type="password"
                   class="form-control @error('password-confirm') is-invalid @enderror"
                   name="password-confirm"
                   required autocomplete="current-password" minlength="8">
            @error('password-confirm')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
    </div>

    <div class="mb-3 row">
        <label for="password-confirm" class="col-md-4 col-form-label text-end">
        </label>
        <div class="col-md-6">
            <input type="hidden" name="edit-agree" value="0">
            <input type="checkbox" class="custom-control @error('agree') is-invalid @enderror"
                   id="agree"
                   required name="agree"
                   value="1" @if(old('agree'))
                {{ 'checked'  }}
                @endif>
            <label class="custom-control-label"
                   for="agree">{{ Request::is('*admin*') ? 'Получено' : 'Даю' }} согласие на
                обработку
                <a href="#" title="Прочитать" id="agreement">персональных данных</a></label>
            @error('agree')
            <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
    </div>
@endif
