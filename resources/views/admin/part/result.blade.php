<div id="dataResultModal" class="modal" role="dialog" aria-labelledby="dataResultLabel" aria-hidden="true"
     style="display: none;" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Добавить результаты испытаний
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label" for="password">Выберите специальность</label>
                        <select name="speciality_id" class="speciality-search form-control"
                                title="Выберите специальность" required>
                        </select>
                    </div>
                </div>
                <input class="user_id" type="hidden" name="user_id" id="user_id" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <a href="#" class="btn btn-danger result-button">Добавить</a>
            </div>
        </div>
    </div>
</div>
