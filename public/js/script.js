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
        if (index < 5) {
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
        ajax: '/parsing/list',
        order: [[0, 'desc']],
        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, 'All'],
        ],
        columns: [
            {data: 'date', name: 'date'},
            {data: 'href', name: 'href'},
            {data: 'time', name: 'time'},
            {data: 'checked', name: 'checked'},
            {data: 'broken', name: 'broken'},
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },
        ],
        initComplete: function () {
            this.api().columns([0, 1, 2, 3, 4]).every(function (colIdx) {
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

    $(document).on('click', '#submit-button', function (e) {
        let site = $("#site").val().trim();
        if (!isValidURL(site)) {
            alert('This webpage is not available.');
            return;
        }
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
                $('#result .report-datatable thead th').each(function () {
                    const title = $('#result .report-datatable thead th').eq($(this).index()).text();
                    $(this).html('<input type="text" placeholder="' + title + '" />');
                });
            },
            success: function (res) {
                const resultTable = $('#result .report-datatable').DataTable({
                    responsive: true,
                    scrollX: true,
                    scrollY: true,
                    processing: true,
                    serverSide: false,
                    ajax: '/result/list?id=' + res,
                    columns: [
                        {data: 'href', name: 'href'},
                        {data: 'anchor', name: 'anchor'},
                        {data: 'parent', name: 'parent'},
                        {data: 'code', name: 'code'},
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
                reportsTable.ajax.reload();
                let timer = setInterval(() => resultTable.ajax.reload(), 2000);
                let timer2 = setInterval(() => reportsTable.ajax.reload(), 30000);
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
                    success: function () {
                        clearInterval(timer);
                        clearInterval(timer2);
                        resultTable.ajax.reload();
                        reportsTable.ajax.reload();
                        $('.loading').hide();
                        document.getElementById('submit-button').disabled = false;
                    }
                });
            }
        });
        return false;
    });
});
