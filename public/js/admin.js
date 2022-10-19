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
        ajax: '/admin/users/list',
        columns: [
            {data: 'id', name: 'id', className: 'dt-id '},
            {data: 'show', name: 'show'},
            {data: 'email', name: 'email'},
            {data: 'statusValue', name: 'statusValue'},
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
            this.api().columns([3]).every(function (colIdx) {
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

    $(document).on('click', '.confirm-id', function () {
        $('#dataConfirmModal').find('#exampleModalLabel').text($(this).attr('data-confirm'));
        $('.confirm-button').attr('id', $(this).attr('data-route')).attr('data-id', $(this).attr('data-id'));
    });

    $(document).on('click', '.destroy-id', function () {
        $('#dataDeleteModal').find('#exampleModalLabel').text($(this).attr('data-confirm'));
        $('.delete-button').attr('data-id', $(this).attr('data-id'));
        $('.user_id').val($(this).attr('data-id'));
        $('.confirm-button').attr('data-id', '').attr('data-id', $(this).attr('data-id'));
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
                    console.log(data);
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

    $(document).on('click', '#user-delete', function (e) {
        let id = document.querySelector('.user_id').value,
            confirm_password = document.querySelector('#confirm_password').value;
        $.ajax({
            type: "GET",
            dataType: "json",
            url: '/admin/deleteUser',
            data: {'id': id, 'confirm_password': confirm_password},
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                } else {
                    usersTable.ajax.reload();
                }
                document.querySelector('#confirm_password').value = '';
            }
        });
    })
});
