@csrf
<div class="user-add-form">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label required" for="parent_name"> Заголовок:</label>
                <input id="title" type="text"
                       class="form-control @error('title') is-invalid @enderror"
                       name="title" value="{{ old('title') ?? $news->title ?? '' }}" required autocomplete="title"
                       autofocus>

                @error('title')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label required" for="body">Текст:</label>
                <textarea name="body" id="body" cols="30" rows="10"
                          class="form-control @error('body') is-invalid @enderror">{{ old('body') ?? $news->body ?? '' }} </textarea>

                @error('body')
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
