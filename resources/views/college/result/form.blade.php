@csrf
<div class="user-add-form">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="education_level">Уровень образования</label>
                <input type="text" class="form-control" value="{{ $speciality->educationLevel() }}" disabled>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="education_form">Форма обучения</label>
                <input type="text" class="form-control" value="{{ $speciality->educationForm() }}" disabled>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="code">Код специальности</label>
                <input type="text" class="form-control" value="{{ $speciality->code }}" disabled>
                <input type="hidden" name="speciality_id" value="{{ $speciality->id}}">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin-bottom: 0;">
            <div class="form-group">
                <label class="control-label" for="name">Наименование специальности</label>
                <textarea cols="30" rows="2" disabled
                          class="form-control">{{ $speciality->name }} </textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="row">
                    <table class="table table-secondary table-bordered table-striped" id="statements-table"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th colspan="3" rowspan="2">&nbsp;</th>
                            <th colspan="{{ $testings->count() ?? '1' }}">Результаты испытаний</th>
                        </tr>
                        <tr>
                            @foreach($testings as $testing)
                                <th><input type="date" class="form-control" name="date[{{$testing->id}}]"
                                           value="{{ (isset($data['date'][$testing->id]) ? Carbon\Carbon::createFromDate($data['date'][$testing->id])->format('Y-m-d') : '') ?? '' }}">
                                </th>
                            @endforeach
                        </tr>
                        <tr>
                            <th>№</th>
                            <th>ID</th>
                            <th>Абитуриенты</th>
                            @foreach($testings as $testing)
                                <th>{{ $testing->name.' ('.$testing->gradeValue().')' }}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @if($applicants->count())
                            @foreach($applicants as $key=>$applicant)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $applicant->id }}</td>
                                    <td>{{ $applicant->getFullName() }}</td>
                                    @foreach($testings as $testing)
                                        @if($testing->grade	== 1)
                                            <th><select class="form-control"
                                                        name="grade[{{$applicant->id}}][{{$testing->id}}]">
                                                    <option value="">
                                                        Выберите
                                                    </option>
                                                    <option value="1"
                                                            @if(isset($data['grade'][$applicant->id][$testing->id]) && $data['grade'][$applicant->id][$testing->id] == 1) selected @endif>
                                                        Зачет
                                                    </option>
                                                    <option value="0"
                                                            @if(isset($data['grade'][$applicant->id][$testing->id]) && $data['grade'][$applicant->id][$testing->id] == 0) selected @endif>
                                                        Не зачет
                                                    </option>
                                                </select></th>
                                        @elseif($testing->grade	== 2)
                                            <th><input type="text" class="form-control"
                                                       name="grade[{{$applicant->id}}][{{$testing->id}}]"
                                                       value="{{ $data['grade'][$applicant->id][$testing->id] ?? '' }}"
                                                       maxlength="1" pattern="[0-5]{1}"
                                                       onkeyup="this.value=this.value.replace(/[^\d]/,'')"
                                                       title="Введите данные в соответствии бальности"></th>
                                        @elseif($testing->grade	== 3)
                                            <th><input type="text" class="form-control"
                                                       name="grade[{{$applicant->id}}][{{$testing->id}}]"
                                                       value="{{ $data['grade'][$applicant->id][$testing->id] ?? '' }}"
                                                       maxlength="2" pattern="[0-9]{1,2}"
                                                       onkeyup="this.value=this.value.replace(/[^\d]/,'')"
                                                       title="Введите данные в соответствии бальности"></th>
                                        @elseif($testing->grade	== 4)
                                            <th><input type="text" class="form-control"
                                                       name="grade[{{$applicant->id}}][{{$testing->id}}]"
                                                       value="{{ $data['grade'][$applicant->id][$testing->id] ?? '' }}"
                                                       maxlength="3" pattern="[0-9]{1,3}"
                                                       onkeyup="this.value=this.value.replace(/[^\d]/,'')"
                                                       title="Введите данные в соответствии бальности"></th>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">Нет принятых заявлений на эту специальность</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="d-flex btn-footer">
        <button type="submit" class="btn btn-primary btn-add-user">
            <i class="bi bi-save"></i>Сохранить
        </button>
    </div>
</div>
