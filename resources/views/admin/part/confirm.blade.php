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
                <button type="button"
                        id="user-change"
                        class="btn btn-danger confirm-button" data-bs-dismiss="modal" data-id="">Да
                </button>
            </div>
        </div>
    </div>
</div>

<div id="dataDestroyModal" class="modal" role="dialog" aria-labelledby="dataDestroyLabel" aria-hidden="true"
     style="display: none;" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Вы подтверждаете удаление пользователя без возможности восстановления?
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="password">Введите пароль:</label>
                        <input id="confirm_password" type="password"
                               class="form-control @error('confirm_password') is-invalid @enderror"
                               name="confirm_password" value=""
                               autofocus>
                        @error('confirm_password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <input class="user_id" type="hidden" name="user_id" id="user_id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button"
                        id="user-delete"
                        class="btn btn-danger delete-button" data-bs-dismiss="modal" data-id="">Удалить
                </button>
            </div>
        </div>
    </div>
</div>
