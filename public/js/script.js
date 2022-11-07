$(document).ready(function () {
    $('#agreement').on('click', function () {
        alert('В соответствии со статьей 9 Федерального закона от 27 июля 2006 года' +
            ' № 152-ФЗ «О персональных данных» я даю согласие на автоматизированную,' +
            ' а также без использования средств автоматизации обработку моих персональных данных,' +
            ' а именно совершение действий, предусмотренных пунктом 3 статьи 3 Федерального закона' +
            ' от 27 июля 2006 года № 152-ФЗ «О персональных данных», со сведениями, находящимися' +
            ' в распоряжении администрации сайта.');
        return false;
    });

    $('.reports-datatable thead th').each(function (index) {
        if (index < 6) {
            const title = $('.reports-datatable thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="' + title + '" />');
        }
    });
    const reportsTable = $('.reports-datatable').DataTable({
        responsive: true,
        scrollX: true,
        scrollY: true,
        processing: true,
        serverSide: false,
        ajax: '/parsing/list?id=' + document.querySelector('#user-id').dataset.id,
        order: [[0, 'desc']],
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, 'All'],
        ],
        columns: [
            {data: 'id', name: 'id', className: 'dt-id',},
            {data: 'date', name: 'date', className: 'dt-page',},
            {data: 'email', name: 'email', className: 'dt-page',},
            {data: 'href', name: 'href'},
            {data: 'time', name: 'time', className: 'dt-page',},
            {data: 'checked', name: 'checked', className: 'dt-page',},
            {data: 'broken', name: 'broken', className: 'dt-page',},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        initComplete: function () {
            this.api().columns([0, 1, 2, 3, 4, 5]).every(function (colIdx) {
                let that = this;
                $('input', this.header()).on('keyup change clear', function () {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
                $('input', reportsTable.column(colIdx).header()).on('click', function (e) {
                    e.stopPropagation();
                });
            });
        }
    });

    function isValidURL(string) {
        let res = string.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
        return (res !== null)
    }
    let timer;
    let timer2;

    $(document).on('click', '#submit-button', function () {
        let site = $("#site").val().trim();
        if (0) {
            alert('This webpage is not available.');
            return false;
        } else {
            document.getElementById('submit-button').disabled = true;
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "/start",
                data: {
                    'site': site,
                },
                beforeSend: function () {
                    $('#result').show();
                    $('.loading').show();
                    if (!$("#result-table").find('.dataTables_wrapper')) {
                        $('#result .report-datatable thead th').each(function () {
                            const title = $('#result .report-datatable thead th').eq($(this).index()).text();
                            $(this).html('<input type="text" placeholder="' + title + '" />');
                        });
                    } else {
                        $( "#result-table" ).load( "logs/table.php" );
                    }
                },
                success: function (res) {
                    if (res.error) {
                        $('#result').hide();
                        $('.loading').hide();
                        alert(res.error);
                        return false;
                    } else {
                        const resultTable = $('#result .report-datatable').DataTable({
                            responsive: true,
                            scrollX: true,
                            scrollY: true,
                            processing: true,
                            serverSide: false,
                            ajax: '/result/list?id=' + res,
                            columns: [
                                {data: 'link', name: 'link'},
                                {data: 'anchor', name: 'anchor'},
                                {data: 'url', name: 'url', className: 'dt-page',},
                                {data: 'code', name: 'code', className: 'dt-page'},
                            ],
                            initComplete: function () {
                                this.api().columns([0, 1, 2, 3]).every(function (colIdx) {
                                    let that = this;
                                    $('input', this.header()).on('keyup change clear', function () {
                                        if (that.search() !== this.value) {
                                            that
                                                .search(this.value)
                                                .draw();
                                        }
                                    });
                                    $('input', resultTable.column(colIdx).header()).on('click', function (e) {
                                        e.stopPropagation();
                                    });
                                });
                            }
                        });
                        document.getElementById('button-kill').dataset.id = res;
                        reportsTable.ajax.reload();
                        timer = setInterval(() => resultTable.ajax.reload(), 2000);
                        timer2 = setInterval(() => reportsTable.ajax.reload(), 4000);
                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url: "/parsing",
                            data: {
                                'id': res,
                            },
                            beforeSend: function () {
                                resultTable.ajax.reload();
                                reportsTable.ajax.reload();
                            },
                            success: function (data) {
                                if (data.error) {
                                    alert(data.error);
                                }
                                clearInterval(timer);
                                clearInterval(timer2);
                                resultTable.ajax.reload();
                                reportsTable.ajax.reload();
                                $('.loading').hide();
                                document.getElementById('submit-button').disabled = false;
                            }
                        });
                    }
                }
            });
        }
    });

    if (document.getElementById('report')) {
        $('#report .report-datatable thead th').each(function () {
            const title = $('#report .report-datatable thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="' + title + '" />');
        });

        const resultTable = $('#report .report-datatable').DataTable({
            responsive: true,
            scrollX: true,
            scrollY: true,
            processing: true,
            serverSide: false,
            ajax: '/result/list?id=' + document.querySelector('#report-id').dataset.id,
            columns: [
                {data: 'link', name: 'link'},
                {data: 'anchor', name: 'anchor'},
                {data: 'url', name: 'url', className: 'dt-page',},
                {data: 'code', name: 'code', className: 'dt-page'},
            ],
            initComplete: function () {
                this.api().columns([0, 1, 2, 3]).every(function (colIdx) {
                    let that = this;
                    $('input', this.header()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that
                                .search(this.value)
                                .draw();
                        }
                    });
                    $('input', resultTable.column(colIdx).header()).on('click', function (e) {
                        e.stopPropagation();
                    });
                });
            }
        });
    }

    $(document).on('click', '.button-trash', function (e) {
        let id = e.target.dataset.id;
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/parsing/delete",
            data: {'id': id},
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    reportsTable.ajax.reload();
                }
            }
        });
    });

    $(document).on('click', '.button-kill', function (e) {
        let id = e.target.dataset.id;
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "/parsing/kill",
            data: {'id': id},
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    clearInterval(timer);
                    clearInterval(timer2);
                    reportsTable.ajax.reload();
                    $('.loading').hide();
                    document.getElementById('submit-button').disabled = false;
                }
            }
        });
    });
});
