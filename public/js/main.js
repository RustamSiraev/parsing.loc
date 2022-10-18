$(document).ready(function () {
    // Порядковый номер предмета
    let gradeIndex = 0;

    //Нормализация числа с плавающей точкой до 2-х знаков после запятой
    function floatNormalize(number) {
        return number.toFixed(2);
    }

    //Выбор типа аттестата
    $(document).on('change', '#doc_type', function (e) {
        let num = $(this).val();
        console.log(num);
        if (['2', '4'].includes(num)) {
            $(".level-1").hide();
            $("#doc_series").removeAttr('required');
            $("#doc_number").attr("pattern", '[0-9]{14}').attr("maxlength", '14').attr("onkeyup", "this.value=this.value.replace(/[^\\d+]/,'')").attr("title", "14 цифр без пробела");
        } else {
            $(".level-1").show();
            $("#doc_series").attr('required', 'true');
            $("#doc_number").removeAttr('pattern maxlength onkeyup title');
        }
    });

    if (document.getElementById('doc_type')) {
        if (['2', '4'].includes($('#doc_type').val())) {
            $(".level-1").hide();
            $("#doc_series").removeAttr('required');
            $("#doc_number").attr("pattern", '[0-9]{14}').attr("maxlength", '14').attr("onkeyup", "this.value=this.value.replace(/[^\\d+]/,'')").attr("title", "14 цифр без пробела");
        }
    }

    //Пересчет среднего балла
    $('#diploma-form').on('change', '.grade-score', function () {
        setTotal();
        //Удаление предмета
    }).on('click', '.subject-delete', function () {
        let index = $(this).data('index');
        $(this).parents('.subject_item').remove();
        setTotal();
        //Добавление дополнительного текста
    }).on('keyup', '.additional-text', function () {
        let index = $(this).data('index');
        $('#text-' + index).val($(this).val());
    });

    //Модалка добавления предмета
    $('#dataAdditionModal').on('keyup', '#adding-name', function () {
        $('#subject-addition').prop('disabled', $(this).val() === '')
        //Добавление предмета
    }).on('click', '.subject-add', function () {
        let name = $('#adding-name').val(),
            index = $('#index').val(),
            text = $('#adding-text').val();
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/applicant/diploma/add-subject',
            data: {
                'name': name,
                'text': text,
                'index': index,
            },
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    $('#subject-addition').attr('disabled', 'disabled');
                    $('#adding-name').val('');
                    $('#adding-text').val('');
                    $('.grade-block').append(data);
                    setTotal();
                }
            }
        });
    })

    //Обновление среднего балла
    function setTotal() {
        gradeIndex = 0;
        let total = 0,
            counter = 0;
        $(".grade-score").each(function (index) {
            gradeIndex++;
            if ($(this).val() !== 0 && $(this).val() !== '') {
                total += parseInt($(this).val());
                counter += 1;
            }
        });
        $('.average').val((total === 0 || counter === 0) ? '-' : floatNormalize(total / counter));
    }

    setTotal();

    var statementTable = $('.statement-datatable').DataTable({
        responsive: true,
        language: {
            url: '/js/ru.json'
        },
        scrollX: true,
        processing: true,
        serverSide: false,
        paging: false,
        ordering: false,
        info: false,
        searching: false,
        ajax: '/applicant/statement/list',
        columns: [
            {data: 'college', name: 'college', orderable: false, searchable: false, className: 'orderable-false'},
            {data: 'code', name: 'code', orderable: false, searchable: false},
            {data: 'speciality', name: 'speciality', orderable: false, searchable: false},
            {
                data: 'qualifications[</br>]',
                name: 'qualifications',
                className: 'orderable-false',
                orderable: false
            },
            {data: 'educationForm', name: 'educationForm', orderable: false, searchable: false},
            {data: 'educationTime', name: 'educationTime', orderable: false, searchable: false},
            {data: 'statusValue', name: 'statusValue', orderable: false, searchable: false},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    $('#statement-create-form').on('change', '#college_id', function (e) {
        $("#education_form option:first").prop("selected", "selected");
        $('#education_form option:not(:first)').remove();
        document.querySelector('#education_form').setAttribute('disabled', 'disabled');
        $("#speciality_id option:first").prop("selected", "selected");
        $('#speciality_id option:not(:first)').remove();
        document.querySelector('#speciality_id').setAttribute('disabled', 'disabled');
        let id = document.querySelector('#college_id').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/applicant/education-form",
            type: "POST",
            dataType: "json",
            data: {'id': id},
            success: function (data) {
                if (data['error']) {
                    document.querySelector('#noForm').innerHTML = data['error'];
                } else {
                    if (!data[0]) {
                        noForm.innerHTML = 'error';
                    } else {
                        document.querySelector('#noForm').innerHTML = '';
                        for (var i = 0; i < data.length; i++) {
                            var option = document.createElement('option');
                            option.innerHTML = data[i]['title'];
                            option.value = data[i]['id'];
                            document.querySelector('#education_form').removeAttribute("disabled");
                            document.querySelector('#education_form').appendChild(option);
                        }
                    }
                }
            }
        });
    }).on('change', '#education_form', function (e) {
        $("#speciality_id option:first").prop("selected", "selected");
        $('#speciality_id option:not(:first)').remove();
        document.querySelector('#speciality_id').setAttribute('disabled', 'disabled');
        let id = document.querySelector('#college_id').value,
            form = document.querySelector('#education_form').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: "/applicant/speciality",
            type: "POST",
            dataType: "json",
            data: {'id': id, 'form': form},
            success: function (data) {
                if (data['error']) {
                    noSpeciality.innerHTML = data['error'];
                } else {
                    if (!data[0]) {
                        noSpeciality.innerHTML = '<span class="invalid" role="alert"><strong>Нет специальностей по этой форме обучения</strong></span>';
                    } else {
                        noSpeciality.innerHTML = '';
                        for (var i = 0; i < data.length; i++) {
                            var option = document.createElement('option');
                            option.innerHTML = data[i]['name'];
                            option.value = data[i]['id'];
                            document.querySelector('#speciality_id').removeAttribute("disabled");
                            document.querySelector('#speciality_id').appendChild(option);
                        }
                    }
                }
            }
        });
    })

    $(document).on('click', '.confirm-id', function () {
        $('#dataConfirmModal').find('#exampleModalLabel').text($(this).attr('data-confirm'));
        $('.confirm-button').attr('id', $(this).attr('data-route')).attr('data-id', $(this).attr('data-id'));
    });

    $(document).on('click', '#statement-delete', function () {
        let id = document.querySelector('#statement-delete').dataset.id;
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/applicant/statement/delete',
            type: 'POST',
            dataType: 'json',
            data: {'id': id},
            success: function (data) {
                if (data['error']) {
                    alert(data['error']);
                } else {
                    statementTable.ajax.reload();
                }
            }
        });
    });

    $(document).on('click', '.message-modal', function (e) {
        let id = $(this).attr('data-id');
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/applicant/statement/message',
            type: 'POST',
            dataType: 'json',
            data: {'id': id},
            success: function (data) {
                if (data['error']) {
                    alert(data['error']);
                } else {
                    $('#dataMessageModal').find('.message').text(data);
                }
            }
        });
    });

    $('.contacts-datatable thead th').each(function (index) {
        if (index === 0) {
            var title = $('.contacts-datatable thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="' + title + '" />');
        }
    });

    var contactsTable = $('.contacts-datatable').DataTable({
        responsive: true,
        language: {
            url: '/js/ru.json'
        },
        scrollX: true,
        processing: true,
        serverSide: false,
        ajax: '/applicant/contacts/list',
        columns: [
            {data: 'title', name: 'title', orderable: false},
            {data: 'phone', name: 'phone', orderable: false},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        initComplete: function () {
            this.api().columns([1]).every(function (colIdx) {
                var that = this;
                $('input', this.header()).on('keyup change clear', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });

                $('input', contactsTable.column(colIdx).header()).on('click', function (e) {
                    e.stopPropagation();
                });
            });
        }
    });
});

//Файлы
if (document.querySelector('#documents-forms')) {
    let modelArr = []

    for (let i = 1; i < 14; i++) {
        modelArr[i] = [];
    }

    //Обновление кнопки
    function setButton(buttonNum) {
        if (document.querySelector('#no-file-' + buttonNum)) {
            document.querySelector('#no-file-' + buttonNum).style.display = modelArr[buttonNum].length > 0 ? 'none' : 'block';
        }
        document.querySelector('#no-file-btn-' + buttonNum).innerHTML = modelArr[buttonNum].length > 0 ? 'Добавьте файл' : 'Выберите файл';
    }

    //Загрузка файла
    $('.documents-form').on('change', '.uploading-file', function (e) {
        let num = $(e.target).attr('data-id');
        const input = document.querySelector('#uploading-file-' + num),
            form = document.querySelector('#documents-form-' + num),
            parent = document.querySelector('#parent-block-' + num);

            formData = new FormData(form);
            if (/\.(jpe?g|png|pdf)$/i.test(input.files[0].name) === false) {
                input.value = '';
                alert('Вы можете загружать только файлы с расширением jpg, jpeg, png, pdf.')
                return false;
            }
            if (input.files[0].size > 5000000) {
                input.value = '';
                alert('Вы можете загрузить файл размером не более 5 МБ.')
                return false;
            }
            if (modelArr[num].length === 5) {
                input.value = '';
                alert('Вы можете загрузить не больше 5 файлов.')
                return false;
            }
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/documents/store-file',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (res) {
                    if (res) {
                        if (res.photo) {
                            $('#photo').attr('src', res.url);
                        } else {
                            modelArr[num].push(res.id);
                            input.value = '';
                            setButton(num);
                            let html = [],
                                output = document.createElement('div');
                            output.setAttribute("id", 'file-' + res.id);
                            output.setAttribute("data-id", res.id);
                            output.classList.add('file-item');

                            html.push('<p>' + res.name + '</p><span data-id="' + res.id + '" data-num="' + num + '" onclick="deleteFile(event)" title="Удалить файл"><i class="bi bi-trash-fill delete-file-item" data-id="' + res.id + '" data-num="' + num + '"></i></span>');
                            html.push('</div>');
                            html.push('</div>');
                            output.innerHTML = html.join('');
                            parent.append(output);
                        }
                    }
                },
                error: function () {
                    console.log('Не получилось');
                }
            });
            e.preventDefault();
    });

    //Удаление файла
    function deleteFile(event) {
        let id = event.target.getAttribute('data-id'),
            num = event.target.getAttribute('data-num');
        confirmAction = confirm("Вы действительно хотите удалить файл?");
        if (confirmAction) {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: '/documents/delete-file',
                type: 'POST',
                data: {'id': id},
                dataType: "json",
                success: function (res) {
                    document.getElementById('file-' + id).remove();
                    modelArr[num].splice(modelArr[num].findIndex((el) => el['id'] === id), 1);
                    setButton(num);
                },
                error: function (res) {
                    console.log(res);
                }
            });
        }
    }
}
