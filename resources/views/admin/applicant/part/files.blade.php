<div class="tab-pane fade show" id="files" role="tabpanel" aria-labelledby="files-tab">
    <form>
        <div class="user-add-form">
            @php
                $labels = [
                          'Фотография',
                          'Документ, удостоверяющий личность абитуриента',
                          'Документ или иное доказательство, подтверждающее принадлежность соотечественника, проживающего за рубежом, к группам, предусмотренных статьей 17 ФЗ от 24.05.1999 г. №99-ФЗ "О государственно политике РФ в отношении соотечественников за рубежом"',
                          'СНИЛС',
                          'Документ об образовании',
                          'Приложение к документу об образовании',
                          'Заверенный в установленном порядке перевод на русский язык документ иностранного государства об образовании и приложение к нему (если последнее предусмотрено законодательством государства, в котором выдан такой документ)<br>(для граждан, не имеющих гражданства РФ)',
                          'Медицинская справка',
                          'Документ, подтверждающий инвалидность',
                          'Документ, подтверждающий ОВЗ',
                          'Документ, подтверждающий статус сироты или ребенка, оставшегося без попечения родителей',
                          'Документ, подтверждающий льготу',
                          'Достижения абитуриента (диплом, сертификат, грамота об участии в олимпиаде и т.п.)',
                        ];
            @endphp
            @for($i=1;$i<14;$i++)
                @if($i==1)
                    <form class="documents-form">
                        <div class="user-add-form" id="document-form-1">
                            <div class="row" style="margin-bottom: 0;">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>{!! $labels[0] !!} </label>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="view-file applicant-file" id="parent-block-1">
                                        <img src="{{ $documents[0] ? Storage::disk('')->url($documents[0][0]['file']) : '/images/not-logo.svg '}}"
                                             alt="Фотография" id="photo" class="my-photo">
                                        @if($documents[0])
                                            <a href="{{  $documents[0] ? Storage::disk('')->url($documents[0][0]['file']) : '#'}}"
                                               title="Скачать файл" target="_blank">
                                                <i class="bi bi-download delete-file-item"></i>
                                            </a>
                                        @else
                                            <span>Файл не выбран</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @else
                    <form id="documents-form-{{$i}}" class="documents-form">
                        <div class="user-add-form" id="document-form-{{$i}}">
                            <div class="row" style="margin-bottom: 0;">
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <label>{!! $labels[$i-1] !!} </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="view-file applicant-file" id="parent-block-{{$i}}">
                                        @if(count($documents[$i-1])>0)
                                            @foreach($documents[$i-1] as $document)
                                                <div id="file-{{ $document['id'] }}" data-id="{{ $document['id'] }}"
                                                     class="file-item">
                                                    <p>{{ $document['name'] }}</p>
                                                    <a href="{{ Storage::disk('')->url($document['file'])}}"
                                                          title="Скачать файл" target="_blank">
                                                        <i class="bi bi-download delete-file-item" ></i>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="file-item" id="no-file-{{$i}}"><p>Файл не выбран</p></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
                <br>
            @endfor
        </div>
    </form>
</div>
