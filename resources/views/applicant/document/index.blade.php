@extends('layouts.app', ['title' => 'Личный кабинет -> Документы'])

@section('content')
    <div class="page-title">
        <h1>Документы</h1>
    </div>
    <div id="documents-forms">
        @php
            $labels = [
                      'Фотография',
                      'Документ, удостоверяющий личность абитуриента',
                      'Документ или иное доказательство, подтверждающее принадлежность соотечественника, проживающего за рубежом, к группам, предусмотренных статьей 17 ФЗ от 24.05.1999 г. №99-ФЗ "О государственно политике РФ в отношении соотечественников за рубежом"<br>(при наличии)',
                      'СНИЛС<br>(при наличии)',
                      'Документ об образовании',
                      'Приложение к документу об образовании<br>(обязательно при наличии)',
                      'Заверенный в установленном порядке перевод на русский язык документ иностранного государства об образовании и приложение к нему (если последнее предусмотрено законодательством государства, в котором выдан такой документ)<br>(для граждан, не имеющих гражданства РФ)',
                      'Медицинская справка',
                      'Документ, подтверждающий инвалидность<br>(при наличии)',
                      'Документ, подтверждающий ОВЗ<br>(при наличии)',
                      'Документ, подтверждающий статус сироты или ребенка, оставшегося без попечения родителей<br>(при наличии)',
                      'Документ, подтверждающий льготу<br>(при наличии)',
                      'Достижения абитуриента (диплом, сертификат, грамота об участии в олимпиаде и т.п.)<br>(при наличии)',
                    ];
        @endphp
        @for($i=1;$i<14;$i++)
            @if($i==1)
                <form id="documents-form-{{$i}}" class="documents-form">
                    <div class="user-add-form" id="document-form-1">
                        <div class="row" style="margin-bottom: 0;">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>{!! $labels[0] !!} <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="view-file applicant-file" id="parent-block-1">
                                    <img src="{{ $documents[0] ? Storage::disk('')->url($documents[0][0]['file']) : '/images/not-logo.svg '}}"
                                         alt="Фотография" id="photo" class="my-photo">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="d-flex btn-footer" for="uploading-file-{{$i}}">
                                    <input type="file" id="uploading-file-{{$i}}" name="file" class="uploading-file"
                                           data-id="{{$i}}" accept=".jpg,.jpeg,.png">
                                    <input type="hidden" name="type" value="{{$i}}">
                                    <span type="button" class="btn btn-primary btn-add-user">
                                <i class="bi bi-plus-lg"></i><span
                                            id="no-file-btn-{{$i}}">{{ count($documents[$i-1])>0 ? 'Заменить фото' : 'Выберите фото' }}</span>
                            </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <form id="documents-form-{{$i}}" class="documents-form">
                    <div class="user-add-form" id="document-form-{{$i}}">
                        <div class="row" style="margin-bottom: 0;">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>{!! $labels[$i-1] !!} @if(in_array($i, [2,5,8]))<span class="text-danger">*</span>@endif</label>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="view-file applicant-file" id="parent-block-{{$i}}">
                                    @if(count($documents[$i-1])>0)
                                        <input type="hidden" id="documents-count-{{$i}}"
                                               value="{{ count($documents[$i-1]) }}">
                                        @foreach($documents[$i-1] as $document)
                                            <div id="file-{{ $document['id'] }}" data-id="{{ $document['id'] }}"
                                                 class="file-item">
                                                <p>{{ $document['name'] }}</p>
                                                <span data-id="{{ $document['id'] }}" onclick="deleteFile(event)"
                                                      title="Удалить файл" data-num="{{ $i }}">
                                                <i class="bi bi-trash-fill delete-file-item"
                                                   data-id="{{ $document['id'] }}" data-num="{{ $i }}"></i>
                                            </span>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="file-item" id="no-file-{{$i}}"><p>Файл не выбран</p></div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="d-flex btn-footer" for="uploading-file-{{$i}}">
                                    <input type="file" id="uploading-file-{{$i}}" name="file" class="uploading-file"
                                           data-id="{{$i}}" accept=".jpg,.jpeg,.png,.pdf">
                                    <input type="hidden" name="type" value="{{$i}}">
                                    <span type="button" class="btn btn-primary btn-add-user">
                                <i class="bi bi-plus-lg"></i><span
                                            id="no-file-btn-{{$i}}">{{ count($documents[$i-1])>0 ? 'Добавьте файл' : 'Выберите файл' }}</span>
                            </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        <br>
        @endfor
    </div>
@endsection

