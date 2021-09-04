$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function* entries(obj) {
  for (let key of Object.keys(obj)) {
    yield [key, obj[key]];
  }
}

function closeForm(clear = false) {
    $(".form-create").css('display', 'none');
    $(".form-create").css('padding-right', '');
    $(".form-create").removeClass("show");
    $(".form-create-dark").remove();
    if (clear) $(".form-create").find("input").each(function (i, item) {
        item.value = ""
    });
}

$(document).ready(function () {
    var grid, countries;
    var tapath = $('#grid')[0].attributes.getNamedItem("tapath").value;
    var column = {
        dataSource: '/action/' + tapath,
        uiLibrary: 'bootstrap4',
        primaryKey: 'id',
        inlineEditing: {mode: 'command'},
        pager: {
            limit: 5,
            leftControls: [
                $('<button class="btn btn-default btn-sm gj-cursor-pointer" title="First Page" data-role="page-first" disabled=""><i class="gj-icon first-page"></i></button>'),
                $('<button class="btn btn-default btn-sm gj-cursor-pointer" title="Previous Page" data-role="page-previous" disabled=""><i class="gj-icon chevron-left"></i></button>'),
                $('<div>Страница</div>'),
                $('<div class="input-group"><input data-role="page-number" class="form-control form-control-sm" type="text" value="0"></div>'),
                $('<div>из</div>'),
                $('<div data-role="page-label-last">1</div>'),
                $('<button class="btn btn-default btn-sm gj-cursor-pointer" title="Next Page" data-role="page-next" disabled=""><i class="gj-icon chevron-right"></i></button>'),
                $('<button class="btn btn-default btn-sm gj-cursor-pointer" title="Last Page" data-role="page-last" disabled=""><i class="gj-icon last-page"></i></button>'),
                $('<button class="btn btn-default btn-sm gj-cursor-pointer" title="Refresh" data-role="page-refresh"><i class="gj-icon refresh"></i></button>'),
                $('<select data-role="page-size" class="form-control input-sm" width="60"></select>'),],
            rightControls: [
                $('<div>Показано результатов&nbsp;</div>'),
                $('<div data-role="record-first">1</div>'),
                $('<div>-</div>'),
                $('<div data-role="record-last">2</div>'),
                $('<div class="gj-grid-mdl-pager-label">из</div>'),
                $('<div data-role="record-total">2</div>')]
        }
    }

    switch (tapath) {
        case "group":
            column["columns"] = [
                {field: 'id', hidden: true},
                {field: 'name', title: 'Наименование группы', editor: true},
                {
                    field: 'branch_name',
                    title: 'Филиал',
                    type: "dropdown",
                    editField: "branch_id",
                    editor: {dataSource: '/action/branch', valueField: 'id', textField: "name"}
                },
                {field: 'children_age', title: 'Возраст детей', editor: true},
            ]
            break;
        case "children":
            column["columns"] = [
                {field: 'id', hidden: true},
                {field: 'fio', title: 'ФИО', editor: true},
                {
                    field: 'branch_name',
                    title: 'Филиал',
                    type: "dropdown",
                    editField: "branch_id",
                    editor: {dataSource: '/action/branch', valueField: 'id', textField: "name"}
                },
                {field: 'date_birth', title: 'Дата рождения', type: "date", editor: true, format: 'yyyy-mm-dd'},
                {
                    field: 'institution_name',
                    title: 'Учреждение',
                    type: "dropdown",
                    editField: "institution_id",
                    editor: {dataSource: '/action/institution', valueField: 'id', textField: "name"}
                },
                {field: 'date_enrollment', title: 'Дата зачисления', type: "date", editor: true, format: 'yyyy-mm-dd'},
                {field: 'address', title: 'Адрес проживания', width: 200, editor: true},
                {field: 'fio_mother', title: 'ФИО матери', editor: true},
                {field: 'phone_mother', title: 'Телефон матери', editor: true},
                {field: 'fio_father', title: 'ФИО отца', editor: true},
                {field: 'phone_father', title: 'Телефон отца', editor: true},
                {field: 'comment', title: 'Комментарий', editor: true},
                {field: 'rate', title: 'Тариф', editor: true},
                {
                    field: 'group_name',
                    title: 'Группа',
                    type: "dropdown",
                    editField: "group_id",
                    editor: {dataSource: '/action/group-array', valueField: 'id', textField: "name"}
                },
                {field: 'date_exclusion', title: 'Дата ухода', type: "date", editor: true, format: 'yyyy-mm-dd'},
                {field: 'reason_exclusion', title: 'Причина ухода', editor: true},
            ]
            break;
        case "staff":
            column["columns"] = [
                {field: 'id', hidden: true},
                {field: 'fio', title: 'ФИО', editor: true},
                {
                    field: 'branch_name',
                    title: 'Филиал',
                    type: "dropdown",
                    editField: "branch_id",
                    editor: {dataSource: '/action/branch', valueField: 'id', textField: "name"}
                },
                {field: 'phone', title: 'Телефон', editor: true},
                {
                    field: 'position_name',
                    title: 'Должность',
                    type: "dropdown",
                    editField: "position_id",
                    editor: {dataSource: '/action/position', valueField: 'id', textField: "name"}
                },
                {field: 'date_birth', title: 'Дата рождения', editor: true},
                {field: 'address', title: 'Адрес проживания', editor: true},
                {field: 'date_enrollment', title: 'Дата зачисления', editor: true},
                {
                    field: 'group_name',
                    title: 'Группа',
                    type: "dropdown",
                    editField: "group_id",
                    editor: {dataSource: '/action/group-array', valueField: 'id', textField: "name"}
                },
                {field: '-', title: 'Отпуск всего', editor: true},
                {field: '-', title: 'Отгулено', editor: true},
                {field: '-', title: 'Остаток на сегодня', editor: true},
                {field: 'date_dismissal', title: 'Дата увольнения', editor: true},
                {field: 'reason_dismissal', title: 'Причина увольнения', editor: true},
            ]
            break;
    }
    grid = $('#grid').grid(column);
    grid.on('rowDataChanged', function (e, id, record) {
        var new_record = []
        for (let [key, value] of entries(record)) {
            if (value!="")
                new_record[key] = value;
        }
        var data = $.extend(true, {"_method": "PUT"}, new_record);
        $.ajax({url: '/action/' + tapath + "/" + id, data: data, method: 'POST'})
            .fail(function () {
                alert('Failed to save.');
            });
    });
    grid.on('rowRemoving', function (e, $row, id, record) {
        if (confirm('Are you sure?')) {
            $.ajax({url: '/action/' + tapath + "/" + id, data: {_method: "DELETE"}, method: 'POST'})
                .done(function () {
                    grid.reload();
                })
                .fail(function () {
                    alert('Failed to delete.');
                });
        }
    });


    $(".btn-create-row").click(function () {
        $(".form-create").css('display', 'block');
        $(".form-create").css('padding-right', '17px');
        $(".form-create").addClass("show");
        $("body").append('<div class="modal-backdrop fade show form-create-dark"></div>')

        $(document).mousedown(function (event) {
            if (event.target, $(event.target).is(".form-create")) {
                closeForm();
            }
        });

        $(".modal-header>.close").click(function (event) {
            closeForm();
        });

    })

    // Формы //
    $.ajax({
        url: '/action/branch',
        method: 'GET',
        success: function (data) {
            data.forEach(item => {
                $('select[name="branch_id"]').append(new Option(item.name, item.id));
            })
        }
    })

    $('.custom-validation').submit(function (d) {
        var data = {}
        $(this).serializeArray().forEach(item => {
            data[item.name] = item.value;
        })
        var tapath = $(this)[0].attributes.getNamedItem("tapath").value
        $.ajax({url: '/action/' + tapath, data: data, method: 'POST'})
            .done(function () {
                closeForm(true);
                grid.reload();
            })
            .fail(function () {
                alert('Failed to delete.');
            });
        return false;
    });


});
