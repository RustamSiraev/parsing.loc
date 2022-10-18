$(document).ready(function () {

    $('#agreement').on('click', function(){
        alert('В соответствии со статьей 9 Федерального закона от 27 июля 2006 года № 152-ФЗ «О персональных данных» и в связи с предоставлением муниципальной услуги «Зачисление в СПО» я даю согласие на автоматизированную, а также без использования средств автоматизации обработку моих персональных данных, а именно совершение действий, предусмотренных пунктом 3 статьи 3 Федерального закона от 27 июля 2006 года № 152-ФЗ «О персональных данных», со сведениями, находящимися в распоряжении отдела образования и необходимыми в соответствии с нормативными правовыми актами для предоставления вышеуказанной услуги.');
        return false;
    });

    $.fn.select2.amd.define('select2/i18n/ru', [], function () {
        return {
            errorLoading: function () {
                return 'Результат не может быть загружен.';
            },
            inputTooLong: function (args) {
                var overChars = args.input.length - args.maximum;
                var message = 'Пожалуйста, удалите ' + overChars + ' символ';
                if (overChars >= 2 && overChars <= 4) {
                    message += 'а';
                } else if (overChars >= 5) {
                    message += 'ов';
                }
                return message;
            },
            inputTooShort: function (args) {
                var remainingChars = args.minimum - args.input.length;
                var message = 'Пожалуйста, введите ' + remainingChars + ' или более символов';
                return message;
            },
            loadingMore: function () {
                return 'Загружаем ещё ресурсы…';
            },
            maximumSelected: function (args) {
                var message = 'Вы можете выбрать ' + args.maximum + ' элемент';
                if (args.maximum >= 2 && args.maximum <= 4) {
                    message += 'а';
                } else if (args.maximum >= 5) {
                    message += 'ов';
                }
                return message;
            },
            noResults: function () {
                return 'Ничего не найдено';
            },
            searching: function () {
                return 'Поиск…';
            }
        };
    });

    const street = $('#street');

    street.select2({
        language: 'ru',
        cache: true,
        ajax: {
            url: '/ajax-address-search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                $('#no_result').remove();
                if (data.error) {
                    $('.select2-results').addClass('no_result')
                    $('.no_result').append('<span id="no_result">Данный адрес не найден в справочнике. Если Вы уверены в его корректности, нажмите на него для выбора.</span>');
                } else {
                    $('.select2-results').removeClass('no_result');
                }
                return {
                    results: $.map(data.suggestions, function (item) {
                        return {
                            text: item.value,
                            id: item.data.fias_id
                        }
                    }),

                };
            },
        },
        minimumInputLength: 2,
    }).on('select2:open', function (e) {
        $('.select2-results').removeClass('no_result');
        $('#no_result').remove();
        $("[aria-controls='select2-street-results']").val($('#city_street').val());
    }).on('select2:select', function (e) {
        $("#house").prop('disabled', false);
        $('#city_street').val(e.params.data.text);
    });

    $('#house').select2({
        language: 'ru',
        cache: true,
        ajax: {
            url: '/ajax-house-search',
            dataType: 'json',
            type: 'GET',
            data: function (params) {
                $street_fias_id = $('#street').val();
                return {
                    q: params.term,
                    id: $street_fias_id
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.suggestions, function (item) {
                        return {
                            text: item.data.house,
                            id: item.data.street_fias_id + '-' +item.data.house
                        }
                    }),
                };
            }
        },
    }).prop('disabled', street.val() === '').on('select2:select', function (e) {
        $('#house_num').val(e.params.data.text);
    });

    const factStreet = $('#fact_street');

    factStreet.select2({
        language: 'ru',
        cache: true,
        ajax: {
            url: '/ajax-address-search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data.suggestions, function (item) {
                        return {
                            text: item.value,
                            id: item.data.street_fias_id
                        }
                    }),

                };
            },
        },
        minimumInputLength: 2,
    }).on('select2:open', function (e) {
        $("[aria-controls='select2-fact_street-results']").val($('#fact_city_street').val());
    }).on('select2:select', function (e) {
        $("#fact_house").prop('disabled', false);
        $('#fact_city_street').val(e.params.data.text);
    });

    $('#fact_house').select2({
        language: 'ru',
        cache: true,
        ajax: {
            url: '/ajax-house-search',
            dataType: 'json',
            type: 'GET',
            data: function (params) {
                $fact_street_fias_id = $('#fact_street').val();
                return {
                    q: params.term,
                    id: $fact_street_fias_id
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data.suggestions, function (item) {
                        return {
                            text: item.data.house,
                            id: item.data.street_fias_id + '-' +item.data.house
                        }
                    }),
                };
            }
        },
    }).prop('disabled', factStreet.val() === '').on('select2:select', function (e) {
        $('#fact_house_num').val(e.params.data.text);
    });

    jQuery(document).on('select2:open', function (e) {
        window.setTimeout(function () {
            jQuery(".select2-container--open .select2-search__field").get(0).focus();
        }, 200);
    });

    if (document.querySelector('#matches')) {
        if ($('#matches')[0].checked) {
            $("#fact_address").hide();
        } else {
            $("#fact_address").show();
        }

        $(document).on('change', '#matches', function (e) {
            if ($(this)[0].checked) {
                $("#fact_address").hide();
                $("[name='fact_street_id'],[name='fact_house_id']").removeAttr("required");
            } else {
                $("#fact_address").show();
                $("[name='fact_street_id'],[name='fact_house_id']").attr("required", "true");
            }
        })
    }
});
