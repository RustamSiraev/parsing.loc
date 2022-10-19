@csrf
<div class="search-form">
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
        <div class="col-md-12">
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
        <div class="col-md-12">
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
    </div>
    <div class="d-flex btn-footer">
        <button type="submit" class="btn btn-primary btn-add-user">
            <i class="bi bi-save"></i>Сохранить
        </button>
    </div>
</div>
