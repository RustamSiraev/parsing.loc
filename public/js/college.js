$(document).ready(function () {
    $('.user-datatable thead th').each(function (index) {
        if (index < 3) {
            var title = $('.user-datatable thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="' + title + '" />');
        }
    });

    var usersTable = $('.user-datatable').DataTable({
        responsive: true,
        language: {
            url: '/js/ru.json'
        },
        scrollX: true,
        processing: true,
        serverSide: false,
        ajax: '/college/users/list',
        columns: [
            {data: 'id', name: 'id', className: 'dt-id '},
            {data: 'show', name: 'show'},
            {data: 'email', name: 'email'},
            {data: 'role_id', name: 'role_id'},
            {data: 'statusValue', name: 'statusValue', className: 'dt-body-status'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        initComplete: function () {
            this.api().columns([0, 1, 2]).every(function (colIdx) {
                var that = this;
                $('input', this.header()).on('keyup change clear', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });

                $('input', usersTable.column(colIdx).header()).on('click', function (e) {
                    e.stopPropagation();
                });
            });
            this.api().columns([3, 4]).every(function (colIdx) {
                var that = this;
                var title = $('.user-datatable thead th');
                var select = $('<select><option value="">' + title[colIdx].innerHTML + '</option></select>')
                    .appendTo($(that.header()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        that
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                that.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });

                $('select', usersTable.column(colIdx).header()).on('click', function (e) {
                    e.stopPropagation();
                });
            });
        }
    });

    $('.activity-datatable thead th').each(function (index) {
        if (index < 3) {
            var title = $('.activity-datatable thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="' + title + '" />');
        }
    });

    var activityTable = $('.activity-datatable').DataTable({
        responsive: true,
        language: {
            url: '/js/ru.json'
        },
        scrollX: true,
        processing: true,
        serverSide: false,
        ajax: '/users/activity-list',
        columns: [
            {data: 'id', name: 'id', className: 'dt-id orderable-false'},
            {data: 'user_id', name: 'user_id', className: 'dt-hidden'},
            {data: 'log_date', name: 'log_date'},
            {data: 'type', name: 'type'},
            {data: 'table', name: 'table'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        searchCols: [
            null,
            {'search': '^' + $('#user-id').val() + '$', bRegex: true},
            null,
            null,
            null,
        ],
        initComplete: function () {
            this.api().columns([0, 1, 3]).every(function (colIdx) {
                var that = this;
                $('input', this.header()).on('keyup change clear', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });

                $('input', usersTable.column(colIdx).header()).on('click', function (e) {
                    e.stopPropagation();
                });
            });
            this.api().columns([3, 4]).every(function (colIdx) {
                var that = this;
                var title = $('.activity-datatable thead th');
                var select = $('<select><option value="">' + title[colIdx].innerHTML + '</option></select>')
                    .appendTo($(that.header()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        that
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                that.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });

                $('select', activityTable.column(colIdx).header()).on('click', function (e) {
                    e.stopPropagation();
                });
            });
        }
    });

    $('.college-speciality-datatable thead th').each(function (index) {
        if ([2, 3, 4].includes(index)) {
            var title = $('.college-speciality-datatable thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="' + title + '" />');
        }
    });

    var specialityTable = $('.college-speciality-datatable').DataTable({
        responsive: true,
        language: {
            url: '/js/ru.json'
        },
        scrollX: true,
        processing: true,
        serverSide: false,
        ajax: '/college/specialities/list',
        columns: [
            {data: 'educationLevel', name: 'educationLevel', className: 'orderable-false', orderable: false},
            {data: 'college', name: 'college', className: 'dt-body-status', orderable: false},
            {data: 'code', name: 'code', className: 'dt-doc-number', orderable: false},
            {data: 'name', name: 'name', orderable: false},
            {
                data: 'qualifications[</br>]',
                name: 'qualifications',
                className: 'orderable-false',
                orderable: false
            },
            {data: 'educationForm', name: 'educationForm', orderable: false},
            {data: 'budgetary', name: 'budgetary', className: 'dt-doc-seria orderable-false'},
            {data: 'commercial', name: 'commercial', className: 'dt-doc-seria orderable-false'},
            {data: 'education_cost', name: 'education_cost', className: 't-doc-seria orderable-false'},
            {data: 'education_time', name: 'education_time', className: 'dt-doc-seria orderable-false'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        initComplete: function () {
            this.api().columns([2, 3, 4]).every(function (colIdx) {
                var that = this;
                $('input', this.header()).on('keyup change clear', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });

                $('input', specialityTable.column(colIdx).header()).on('click', function (e) {
                    e.stopPropagation();
                });
            });
            this.api().columns([0, 1, 5]).every(function (colIdx) {
                var that = this;
                var title = $('.college-speciality-datatable thead th');
                var select = $('<select><option value="">' + title[colIdx].innerHTML + '</option></select>')
                    .appendTo($(that.header()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        that
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                that.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });

                $('select', specialityTable.column(colIdx).header()).on('click', function (e) {
                    e.stopPropagation();
                });
            });
        }
    });

    var qualificationTable = $('.college-qualification-datatable').DataTable({
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
        ajax: '/college/' + $('#speciality-id').val() + '/qualifications/list',
        columns: [
            {data: 'name', name: 'name', orderable: false, searchable: false, className: 'orderable-false'},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    var testingTable = $('.college-testing-datatable').DataTable({
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
        ajax: '/college/' + $('#speciality-id').val() + '/testings/list',
        columns: [
            {data: 'name', name: 'name', orderable: false, searchable: false, className: 'orderable-false'},
            {data: 'gradeValue', name: 'gradeValue', orderable: false, searchable: false},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ]
    });

    var statisticTable = $('.admin-statistic-datatable').DataTable({
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
        ajax: '/college/statistic/list',
        columns: [
            {data: 'name', name: 'name', orderable: false, searchable: false, className: 'orderable-false'},
            {data: 'data', name: 'data', orderable: false, searchable: false},
        ]
    });

    $('.college-search').select2({
        allowClear: true,
        language: 'ru',
        placeholder: 'Выберите СПО',
        ajax: {
            url: '/ajax-college-search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.title,
                            id: item.id
                        }
                    })
                };
            },
            cache: true,
            theme: "bootstrap5",
            tags: true,
        }
    });

    $('.speciality-search').select2({
        allowClear: true,
        language: 'ru',
        placeholder: 'Выберите специальность',
        ajax: {
            url: '/ajax-speciality-search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true,
            theme: "bootstrap5",
            tags: true,
        }
    }).on('select2:select', function (e) {
        $('.result-button').attr('href', '/college/results/'+$(this).val()+'/create');
    });

    $('.speciality-select').select2({
        allowClear: true,
        language: 'ru',
        placeholder: 'Выберите специальность',
        ajax: {
            url: '/ajax-speciality-search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true,
            theme: "bootstrap5",
            tags: true,
        }
    }).on('select2:close', function (e) {
        let id = $(this).val();
        getStatistic(id);
    });

    function getStatistic(id = 0) {
        $.ajax({
            url: '/college/statistic/list',
            type: 'GET',
            dataType: 'json',
            data: {'id': id},
            success: function (data) {
                if (data['error']) {
                    alert(data['error']);
                } else {
                    $('.statistic').each(function (index) {
                        $(this).text(data[index + 1])
                    });
                }
            }
        });
    }

    if ($('.statistic-table')) getStatistic()

    $('.college-applicants-datatable thead th').each(function (index) {
        if (index < 5 || index === 6) {
            var title = $('.college-applicants-datatable thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="' + title + '" />');
        }
    });

    var applicantsTable = $('.college-applicants-datatable').DataTable({
        responsive: true,
        language: {
            url: '/js/ru.json'
        },
        scrollX: true,
        processing: true,
        serverSide: false,
        ajax: '/college/applicants/list',
        columns: [
            {data: 'id', name: 'id', className: 'dt-id orderable-false'},
            {data: 'l_name', name: 'l_name', className: 'dt-body-status'},
            {data: 'f_name', name: 'f_name', className: 'dt-body-status'},
            {data: 'm_name', name: 'm_name', className: 'dt-body-status'},
            {data: 'birth_day', name: 'birth_day', className: 'dt-birth orderable-false'},
            {data: 'doc_type', name: 'doc_type', className: 'orderable-false'},
            {data: 'doc_number', name: 'doc_number', className: 'dt-body-number orderable-false'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        initComplete: function () {
            this.api().columns([0,1,2,3,4,6]).every(function (colIdx) {
                var that = this;
                $('input', this.header()).on('keyup change clear', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
                $('input', applicantsTable.column(colIdx).header()).on('click', function (e) {
                    e.stopPropagation();
                });
            });
            this.api().columns([5]).every(function (colIdx) {
                var that = this;
                var title = $('.college-applicants-datatable thead th');
                var select = $('<select><option value="">' + title[colIdx].innerHTML + '</option></select>')
                    .appendTo($(that.header()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        that
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });
                that.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
                $('select', applicantsTable.column(colIdx).header()).on('click', function (e) {
                    e.stopPropagation();
                });
            });
        }
    });

    $('.college-statements-datatable thead th').each(function (index) {
        if ([0, 1, 2, 4, 5, 6].includes(index)) {
            var title = $('.college-statements-datatable thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="' + title + '" />');
        }
    });

    var statementsTable = $('.college-statements-datatable').DataTable({
        responsive: true,
        language: {
            url: '/js/ru.json'
        },
        scrollX: true,
        processing: true,
        serverSide: false,
        ajax: '/college/statements/list',
        columns: [
            {data: 'id', name: 'id', orderable: false, className: 'dt-mini orderable-false'},
            {data: 'code', name: 'code', className: 'dt-doc-number', orderable: false},
            {data: 'speciality', name: 'speciality', className: 'dt-title', orderable: false},
            {data: 'educationLevel', name: 'educationLevel', className: 'dt-doc-number', orderable: false},
            {data: 'l_name', name: 'l_name', className: 'dt-body-status'},
            {data: 'f_name', name: 'f_name', orderable: false, className: 'dt-body-status'},
            {data: 'm_name', name: 'm_name', orderable: false, className: 'dt-body-status'},
            {data: 'statusValue', name: 'statusValue', orderable: false, className: 'dt-body-status'},
            {data: 'average', name: 'average', className: 'dt-mini'},
            {data: 'created', name: 'created', className: 'dt-body-status'},
            {
                data: 'results[</br>]',
                name: 'testings',
                className: 'orderable-false',
                orderable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        initComplete: function () {
            this.api().columns([0,1,2,4,5,6]).every(function (colIdx) {
                var that = this;
                $('input', this.header()).on('keyup change clear', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
                $('input', statementsTable.column(colIdx).header()).on('click', function (e) {
                    e.stopPropagation();
                });
            });
            this.api().columns([3,7]).every(function (colIdx) {
                var that = this;
                var title = $('.college-statements-datatable thead th');
                var select = $('<select><option value="">' + title[colIdx].innerHTML + '</option></select>')
                    .appendTo($(that.header()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        that
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });
                that.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
                $('select', statementsTable.column(colIdx).header()).on('click', function (e) {
                    e.stopPropagation();
                });
            });
        }
    }).on('click', 'tbody tr', function() {
        window.location.href = `/college/statements/${statementsTable.row(this).data().id}/show`;
    });

    $('.college-result-datatable thead th').each(function (index) {
        if ([0, 1].includes(index)) {
            var title = $('.college-applicants-datatable thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="' + title + '" />');
        }
    });

    var resultsTable = $('.college-result-datatable').DataTable({
        responsive: true,
        language: {
            url: '/js/ru.json'
        },
        scrollX: true,
        processing: true,
        serverSide: true,
        ajax: '/college/results/list',
        columns: [
            {data: 'code', name: 'code', className: 'dt-doc-number orderable-false', orderable: false},
            {data: 'speciality', name: 'speciality', orderable: false},
            {data: 'educationLevel', name: 'educationLevel', orderable: false},
            {data: 'educationForm', name: 'educationForm', orderable: false},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        initComplete: function () {
            this.api().columns([0,1]).every(function (colIdx) {
                var that = this;
                $('input', this.header()).on('keyup change clear', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
                $('input', resultsTable.column(colIdx).header()).on('click', function (e) {
                    e.stopPropagation();
                });
            });
            this.api().columns([2,3]).every(function (colIdx) {
                var that = this;
                var title = $('.college-result-datatable thead th');
                var select = $('<select><option value="">' + title[colIdx].innerHTML + '</option></select>')
                    .appendTo($(that.header()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
                        that
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });
                that.data().unique().sort().each(function (d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
                $('select', resultsTable.column(colIdx).header()).on('click', function (e) {
                    e.stopPropagation();
                });
            });
        }
    });

    $('#message').on('keypress keyup keydown', function () {
        $('#message-confirm').prop("disabled", !$('#message').val())
    });

    $(document).on('click', '#message-confirm', function (e) {
        let id = document.querySelector('#message-confirm').dataset.id,
            message = document.querySelector('#message').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/statements/reject',
            type: 'POST',
            dataType: 'json',
            data: {'id': id, 'message': message},
            success: function (data) {
                $("#message-confirm").prop('disabled', true);
                if (data['error']) {
                    alert(data['error']);
                } else {
                    location.reload();
                }
            }
        });
    })

    $('#jur_address').select2({
        language: 'ru',
        cache: true,
        ajax: {
            url: '/jur-address-search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data.suggestions, function (item) {
                        return {
                            text: item.unrestricted_value,
                            guid: item.data.area_fias_id ?? item.data.city_fias_id,
                            district: item.data.area ? item.data.area + ' р-н' : 'г. ' + item.data.city,
                            city: item.data.area ? 0 : 1,
                            id: item.unrestricted_value
                        }
                    }),

                };
            },
        },
        minimumInputLength: 2,
    }).on('select2:open', function (e) {
        $("[aria-controls='select2-jur_address-results']").val($(this).val());
    });

    $('#post_address').select2({
        language: 'ru',
        cache: true,
        ajax: {
            url: '/jur-address-search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data.suggestions, function (item) {
                        return {
                            text: item.unrestricted_value,
                            id: item.unrestricted_value
                        }
                    }),

                };
            },
        },
        minimumInputLength: 2,
    }).on('select2:open', function (e) {
        $("[aria-controls='select2-post_address-results']").val($(this).val());
    });

    $(document).on('click', '.confirm-id', function () {
        $('#dataConfirmModal').find('#exampleModalLabel').text($(this).attr('data-confirm'));
        $('.confirm-button').attr('id', $(this).attr('data-route')).attr('data-id', $(this).attr('data-id'));
    });

    $(document).on('click', '.qualification', function () {
        $('#dataQualificationModal').find('#exampleModalLabel').text($(this).attr('data-text')).find('#qualification_name').val($(this).attr('data-name'));
        $('#qualification_name').val($(this).attr('data-name'));
        $('.qualification-button').attr('id', $(this).attr('data-route')).attr('data-id', $(this).attr('data-id'));
    });

    $(document).on('click', '.testing', function () {
        $('#dataTestingModal').find('#exampleModalLabel').text($(this).attr('data-text')).find('#testing_name').val($(this).attr('data-name'));
        $('#testing_name').val($(this).attr('data-name'));
        $('#testing_grade').val($(this).attr('data-grade'));
        $('.testing-button').attr('id', $(this).attr('data-route')).attr('data-id', $(this).attr('data-id'));
    });

    $('#qualification_name').on('keypress keyup keydown', function () {
        $('.qualification-button').prop("disabled", !$('#qualification_name').val())
    });

    $('#testing_name').on('keypress keyup keydown', function () {
        $('.testing-button').prop("disabled", !$('#testing_name').val())
    });

    // let myModal = document.querySelector('#dataQualificationModal');
    //
    // if (myModal) {
    //     myModal.addEventListener('hide.bs.modal', function (event) {
    //         $(".qualification-button").prop('disabled', true);
    //     })
    // }

    $(document).on('click', '#qualification-add', function () {
        let name = document.querySelector('#qualification_name').value,
            speciality = document.querySelector('#speciality-id').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/qualification/add',
            type: 'POST',
            dataType: 'json',
            data: {'name': name, 'speciality': speciality},
            success: function (data) {
                $("#qualification-add").prop('disabled', true);
                if (data['error']) {
                    alert(data['error']);
                } else {
                    qualificationTable.ajax.reload();
                }
            }
        });
    });

    $(document).on('click', '#testing-add', function () {
        let name = document.querySelector('#testing_name').value,
            grade = document.querySelector('#testing_grade').value,
            speciality = document.querySelector('#speciality-id').value;
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/testing/add',
            type: 'POST',
            dataType: 'json',
            data: {
                'name': name,
                'grade': grade,
                'speciality': speciality
            },
            success: function (data) {
                $("#testing-add").prop('disabled', true);
                if (data['error']) {
                    alert(data['error']);
                } else {
                    testingTable.ajax.reload();
                }
            }
        });
    });

    $(document).on('click', '#qualification-edit', function () {
        let name = document.querySelector('#qualification_name').value,
            id = document.querySelector('#qualification-edit').dataset.id;
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/qualification/edit',
            type: 'POST',
            dataType: 'json',
            data: {'name': name, 'id': id},
            success: function (data) {
                $("#qualification-add").prop('disabled', true);
                if (data['error']) {
                    alert(data['error']);
                } else {
                    qualificationTable.ajax.reload();
                }
            }
        });
    });

    $(document).on('click', '#testing-edit', function () {
        let name = document.querySelector('#testing_name').value,
            grade = document.querySelector('#testing_grade').value,
            id = document.querySelector('#testing-edit').dataset.id;
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/testing/edit',
            type: 'POST',
            dataType: 'json',
            data: {
                'name': name,
                'grade': grade,
                'id': id},
            success: function (data) {
                $("#testing-add").prop('disabled', true);
                if (data['error']) {
                    alert(data['error']);
                } else {
                    testingTable.ajax.reload();
                }
            }
        });
    });

    function changeStatus(button, url, table) {
        $(document).on('click', button, function (e) {
            let id = document.querySelector(button).dataset.id;
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                data: {'id': id},
                success: function (data) {
                    if (data.error) {
                        alert(data.error);
                    } else {
                        table.ajax.reload();
                    }
                }
            });
        })
    }

    changeStatus('#user-change', '/changeStatus', usersTable);
    changeStatus('#specialities-change', '/specialityStatus', specialityTable);
    changeStatus('#qualification-change', '/qualificationStatus', qualificationTable);
    changeStatus('#testing-change', '/testingStatus', testingTable);
    changeStatus('#applicant-change', '/changeApplicant', applicantsTable);

    $(document).on('click', '.destroy-id', function () {
        $('.delete-button').attr('data-id', $(this).attr('data-id'));
        $('.user_id').val($(this).attr('data-id'));
        $('.confirm-button').attr('data-id', '').attr('data-id', $(this).attr('data-id'));
    });

    function html_table_to_excel(type)
    {
        var data = document.getElementById('employee_data');
        var file = XLSX.utils.table_to_book(data, {sheet: "sheet1"});
        var name = 'export';
        XLSX.write(file, { bookType: type, bookSST: true, type: 'base64' });
        XLSX.writeFile(file, name + '.' + type);
    }

    $(document).on('click', '#export_button', function (e) {
        html_table_to_excel('xlsx');
    });
});
