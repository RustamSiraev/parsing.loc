<div id="dataConfirmModal" class="modal" role="dialog" aria-labelledby="dataConfirmLabel" aria-hidden="true"
     style="display: none;" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Вы подтверждаете?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет</button>
                <button type="button" id=""
                        class="btn btn-danger confirm-button" data-bs-dismiss="modal" data-id="">Да
                </button>
            </div>
        </div>
    </div>
</div>

<div id="dataQualificationModal" class="modal" role="dialog" aria-labelledby="dataQualificationLabel" aria-hidden="true"
     style="display: none;" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавление квалификации</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label required" for="qualification_name">Наименование квалификации</label>
                        <input id="qualification_name" type="text"
                               class="form-control @error('qualification_name') is-invalid @enderror"
                               name="qualification_name" value="{{ old('qualification_name') ?? '' }}" required
                               autocomplete="qualification_name"
                               autofocus>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" disabled id=""
                        class="btn btn-danger qualification-button" data-bs-dismiss="modal" data-id="">Сохранить
                </button>
            </div>
        </div>
    </div>
</div>

<div id="dataTestingModal" class="modal" role="dialog" aria-labelledby="dataTestingLabel" aria-hidden="true"
     style="display: none;" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавление испытания</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label required" for="testing_name">Наименование испытания</label>
                        <input id="testing_name" type="text"
                               class="form-control @error('testing_name') is-invalid @enderror"
                               name="testing_name" value="{{ old('testing_name') ?? '' }}" required
                               autocomplete="testing_name"
                               autofocus>
                    </div>
                </div>
            </div>
            <div class="modal-body row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="testing_grade">Результат</label>
                        <select class="form-control @error('testing_grade') is-invalid @enderror"
                                name="testing_grade" id="testing_grade" required>
                            <option value="1">
                                Зачет / Незачет
                            </option>
                            <option value="2">
                                5 бальная оценка
                            </option>
                            <option value="3">
                                10 бальная оценка
                            </option>
                            <option value="4">
                                100 бальная оценка
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" disabled id=""
                        class="btn btn-danger testing-button" data-bs-dismiss="modal" data-id="">Сохранить
                </button>
            </div>
        </div>
    </div>
</div>
