<div class="tab-pane fade show active" id="status" role="tabpanel" aria-labelledby="status-tab">
    <form>
        <div class="search-form">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="control-label" for="parent_l_name">Заявление поступило</label>
                        <input type="text" class="form-control"
                               value="{{ date('d.m.Y / H:i', strtotime($statement->created_at)) ?? '' }}" disabled>
                    </div>
                </div>
                @if($statement->status_id == 1)
                    <div class="col-md-7">
                        <div class="form-group">
                            <label class="control-label" for="parent_l_name"> </label>
                            <div class="custom-control custom-checkbox statement-btn">
                                <a href="{{ route('college.statements.accept', ['statement' => $statement->id])}}"
                                   class="btn btn-primary">
                                    Принять в обработку</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label" for="parent_l_name"> </label>
                            <div class="custom-control custom-checkbox statement-btn">
                                <a href="#" class="btn btn-secondary confirm-id" title="Отказать в принятии"
                                   data-bs-toggle="modal" data-bs-target="#dataRejectModal"
                                   data-id="{{ $statement->id }}">
                                    Отказать в принятии</a>
                            </div>
                        </div>
                    </div>
                @elseif($statement->status_id == 2)
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label" for="parent_l_name">Заявление принято</label>
                            <input type="text" class="form-control"
                                   value="{{ date('d.m.Y / H:i', strtotime($statement->accepted_at)) ?? '' }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="parent_l_name"> </label>
                            <div class="custom-control custom-checkbox statement-btn">
                                <a href="{{ route('college.statements.refute', ['statement' => $statement->id])}}"
                                   class="btn btn-primary">
                                    Отменить одобрение</a>
                            </div>
                        </div>
                    </div>
                @elseif($statement->status_id == 3)
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label" for="parent_l_name">Зачислен</label>
                            <input type="text" class="form-control"
                                   value="{{ date('d.m.Y / H:i', strtotime($statement->going_at)) ?? '' }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="parent_l_name"> </label>
                            <div class="custom-control custom-checkbox statement-btn">
                                <a href="{{ route('college.statements.refute', ['statement' => $statement->id])}}"
                                   class="btn btn-primary">
                                    Отчислить</a>
                            </div>
                        </div>
                    </div>
                @elseif($statement->status_id == 4)
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label" for="parent_l_name">Заявление отклонено</label>
                            <input type="text" class="form-control"
                                   value="{{ date('d.m.Y / H:i', strtotime($statement->rejected_at)) ?? '' }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="parent_l_name"> </label>
                            <div class="custom-control custom-checkbox statement-btn">
                                <a href="{{ route('college.statements.refute', ['statement' => $statement->id])}}"
                                   class="btn btn-primary">
                                    Восстановить</a>
                            </div>
                        </div>
                    </div>
                @elseif($statement->status_id == 5)
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label" for="parent_l_name">Отказ в зачислении</label>
                            <input type="text" class="form-control"
                                   value="{{ date('d.m.Y / H:i', strtotime($statement->refused_at)) ?? '' }}" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label" for="parent_l_name"> </label>
                            <div class="custom-control custom-checkbox statement-btn">
                                <a href="{{ route('college.statements.refute', ['statement' => $statement->id])}}"
                                   class="btn btn-primary">
                                    Восстановить</a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control" disabled
                            @if($statement->target){{ 'checked'  }}@endif>
                            <label class="custom-control-label" for="target">
                                <h5 class="@if($statement->target){{'fw-bold'}}@endif">Целевой прием</h5></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control" disabled
                            @if($statement->benefit){{ 'checked'  }}@endif>
                            <label class="custom-control-label" for="benefit">
                                <h5 class="@if($statement->benefit){{'fw-bold'}}@endif">Есть льготная категория</h5>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control" disabled
                            @if($statement->limited){{ 'checked'  }}@endif>
                            <label class="custom-control-label" for="limited">
                                <h5 class="@if($statement->limited){{'fw-bold'}}@endif">Наличие ОВЗ</h5></label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control" disabled
                            @if($statement->disabled){{ 'checked'  }}@endif>
                            <label class="custom-control-label" for="disabled">
                                <h5 class="@if($statement->disabled){{'fw-bold'}}@endif">Наличие инвалидности</h5>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            @if(in_array($statement->status_id, [2,3,5]))
                @if(count($data)>0)
                <h3>Результаты испытаний</h3>
                <div class="row">
                    <table class="table table-secondary table-bordered table-striped" id="statements-table" style="width:100%">
                        <thead>
                        <tr>
                            <th>Испытание</th>
                            <th>Оценка</th>
                            <th>Результат</th>
                            <th>Дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $item)
                            <tr>
                                <td>{{ $item['testing'] }}</td>
                                <td>{{ $item['grade'] }}</td>
                                @if($item['grade'] == 'Зачет / Незачет')
                                    @if($item['res'] == 1)
                                        <td>Зачет</td>
                                    @else
                                        <td>Незачет</td>
                                    @endif
                                @else
                                    <td>{{ $item['res'] }}</td>
                                @endif
                                <td>{{ $item['date'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                    <h3>Результаты испытаний не заполнены</h3>
                @endif
            @endif

            @if(in_array($statement->status_id, [4]))
                <h3>Причина отклонения</h3>
                <div class="row">
                    <textarea class="form-control" cols="30" rows="5">{{ $statement->message }}</textarea>
                </div>
            @endif

            @if($statement->status_id == 2)
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label class="control-label" for="parent_l_name"> </label>
                            <div class="custom-control custom-checkbox statement-btn">
                                <a href="{{ route('college.statements.going', ['statement' => $statement->id])}}"
                                   class="btn btn-primary">
                                    Зачисление</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="control-label" for="parent_l_name"> </label>
                            <div class="custom-control custom-checkbox statement-btn">
                                <a href="{{ route('college.statements.refuse', ['statement' => $statement->id])}}"
                                   class="btn btn-secondary">
                                    Отказ в зачислении</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </form>
</div>
