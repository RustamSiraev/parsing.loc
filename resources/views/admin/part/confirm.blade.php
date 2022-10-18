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
                        id="@if (Request::is('*users*')){{'user-change'}}@elseif(Request::is('*colleges*')){{'college-change'}}@elseif(Request::is('*applicants*')){{'applicant-change'}}@elseif(Request::is('*address*')){{'address-delete'}}@elseif(Request::is('*news*')){{'news-delete'}}@elseif(Request::is('*specialities*')){{'specialities-change'}}@else{{'parent-delete'}}@endif"
                        class="btn btn-danger confirm-button" data-bs-dismiss="modal" data-id="">Да
                </button>
            </div>
        </div>
    </div>
</div>

<div id="dataDeleteModal" class="modal" role="dialog" aria-labelledby="dataDeleteLabel" aria-hidden="true"
     style="display: none;" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Вы подтверждаете?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет</button>
                <button type="button" id="college-delete"
                        class="btn btn-danger confirm-button" data-bs-dismiss="modal" data-id="">Да
                </button>
            </div>
        </div>
    </div>
</div>

<div id="dataMessageModal" class="modal" role="dialog" aria-labelledby="dataMessageLabel" aria-hidden="true"
     style="display: none;" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Причина отклонения заявления</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <h5 class="message"></h5>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>

<div id="dataRejectModal" class="modal" role="dialog" aria-labelledby="dataRejectLabel" aria-hidden="true"
     style="display: none;" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Укажите причину отклонения заявления</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-sm-12">
                    <div class="form-group">
                        <textarea class="form-control @error('message') is-invalid @enderror" name="message"
                                  id="message" cols="30" rows="5" required>{{ old('message') ?? '' }}</textarea>
                        @error('message')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" disabled
                        id="message-confirm"
                        class="btn btn-danger confirm-button" data-bs-dismiss="modal" data-id="">OK
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
