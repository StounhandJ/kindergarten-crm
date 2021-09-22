$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function* entries(obj) {
    for (let key of Object.keys(obj)) {
        yield [key, obj[key]];
    }
}

function closeForm(clear = false) {
    $(".form-create").css("display", "none");
    $(".form-create").css("padding-right", "");
    $(".form-create").removeClass("show");
    $(".form-create-dark").remove();
    if (clear)
        $(".form-create")
            .find("input")
            .each(function (i, item) {
                item.value = "";
            });
}

function current_table(table) {
    var tapath = table[0].attributes.getNamedItem("tapath").value;
    var column = {
        dataSource: "/action/" + tapath,
        uiLibrary: "bootstrap4",
        primaryKey: "id",
        resizableColumns: true,
        notFoundText: "Записей нет",
        inlineEditing: {mode: "command"},
        pager: {
            limit: 5,
            leftControls: [
                $(
                    '<button class="btn btn-default btn-sm gj-cursor-pointer" title="First Page" data-role="page-first" disabled=""><i class="gj-icon first-page"></i></button>'
                ),
                $(
                    '<button class="btn btn-default btn-sm gj-cursor-pointer" title="Previous Page" data-role="page-previous" disabled=""><i class="gj-icon chevron-left"></i></button>'
                ),
                $("<div>Страница</div>"),
                $(
                    '<div class="input-group"><input data-role="page-number" class="form-control form-control-sm" type="text" value="0"></div>'
                ),
                $("<div>из</div>"),
                $('<div data-role="page-label-last">1</div>'),
                $(
                    '<button class="btn btn-default btn-sm gj-cursor-pointer" title="Next Page" data-role="page-next" disabled=""><i class="gj-icon chevron-right"></i></button>'
                ),
                $(
                    '<button class="btn btn-default btn-sm gj-cursor-pointer" title="Last Page" data-role="page-last" disabled=""><i class="gj-icon last-page"></i></button>'
                ),
                $(
                    '<button class="btn btn-default btn-sm gj-cursor-pointer" title="Refresh" data-role="page-refresh"><i class="gj-icon refresh"></i></button>'
                ),
                $(
                    '<select data-role="page-size" class="form-control input-sm" width="60"></select>'
                ),
            ],
            rightControls: [
                $("<div>Показано результатов&nbsp;</div>"),
                $('<div data-role="record-first">1</div>'),
                $("<div>-</div>"),
                $('<div data-role="record-last">2</div>'),
                $('<div class="gj-grid-mdl-pager-label">из</div>'),
                $('<div data-role="record-total">2</div>'),
            ],
        },
    };

    switch (tapath.split("?")[0]) {
        case "branches":
            column["columns"] = [
                {field: "id", hidden: true},
                {
                    field: "name",
                    title: "Наименование филиала",
                    editor: true,
                }
            ];
            break;
        case "group":
            column["columns"] = [
                {field: "id", hidden: true},
                {
                    field: "name",
                    title: "Наименование группы",
                    editor: true,
                },
                {
                    field: "branch_name",
                    title: "Филиал",
                    type: "dropdown",
                    editField: "branch_id",
                    editor: {
                        dataSource: "/action/branch-array",
                        valueField: "id",
                        textField: "name",
                    },
                },
                {
                    field: "children_age",
                    title: "Возраст детей",
                    editor: true,
                },
            ];
            break;
        case "children":
            column["columns"] = [
                {field: "id", hidden: true},
                {field: "fio", title: "ФИО", editor: true},
                {
                    field: "branch_name",
                    title: "Филиал",
                    type: "dropdown"
                },
                {
                    field: "date_birth",
                    title: "Дата рождения",
                    type: "date",
                    editor: true,
                    format: "yyyy-mm-dd",
                },
                {
                    field: "institution_name",
                    title: "Учреждение",
                    type: "dropdown",
                    editField: "institution_id",
                    editor: {
                        dataSource: "/action/institution",
                        valueField: "id",
                        textField: "name",
                    },
                },
                {
                    field: "date_enrollment",
                    title: "Дата зачисления",
                    type: "date",
                    editor: true,
                    format: "yyyy-mm-dd",
                },
                {
                    field: "address",
                    title: "Адрес проживания",
                    width: 200,
                    editor: true,
                },
                {field: "fio_mother", title: "ФИО матери", editor: true},
                {
                    field: "phone_mother",
                    title: "Телефон матери",
                    editor: true,
                },
                {field: "fio_father", title: "ФИО отца", editor: true},
                {
                    field: "phone_father",
                    title: "Телефон отца",
                    editor: true,
                },
                {field: "comment", title: "Комментарий", editor: true},
                {field: "rate", title: "Тариф", editor: true},
                {
                    field: "group_name",
                    title: "Группа",
                    type: "dropdown",
                    editField: "group_id",
                    editor: {
                        dataSource: "/action/group-array",
                        valueField: "id",
                        textField: "name",
                    },
                },
                {
                    field: "date_exclusion",
                    title: "Дата ухода",
                    type: "date",
                    editor: true,
                    format: "yyyy-mm-dd",
                },
                {
                    field: "reason_exclusion",
                    title: "Причина ухода",
                    editor: true,
                },
            ];
            break;
        case "staff":
            column["columns"] = [
                {field: "id", hidden: true},
                {field: "fio", title: "ФИО", editor: true},
                {field: "login", title: "Логин", editor: true},
                {field: "password", title: "Пароль", renderer: () => "<b>Скрыт</b>", editor: true},
                {
                    field: "branch_name",
                    title: "Филиал",
                    type: "dropdown",
                    editField: "branch_id",
                    editor: {
                        dataSource: "/action/branch-array",
                        valueField: "id",
                        textField: "name",
                    },
                },
                {field: "salary", title: "Зарплата", editor: true},
                {field: "phone", title: "Телефон", editor: true},
                {
                    field: "position_name",
                    title: "Должность",
                    type: "dropdown",
                    editField: "position_id",
                    editor: {
                        dataSource: "/action/position",
                        valueField: "id",
                        textField: "name",
                    },
                },
                {
                    field: "date_birth",
                    title: "Дата рождения",
                    type: "date",
                    editor: true,
                    format: "yyyy-mm-dd",
                },
                {
                    field: "address",
                    title: "Адрес проживания",
                    editor: true,
                },
                {
                    field: "date_employment",
                    title: "Дата принятия",
                    type: "date",
                    editor: true,
                    format: "yyyy-mm-dd",
                },
                {
                    field: "group_name",
                    title: "Группа",
                    type: "dropdown",
                    editField: "group_id",
                    headerCssClass: "min-width170",
                    editor: {
                        dataSource: "/action/group-array",
                        valueField: "id",
                        textField: "name",
                    },
                },
                {field: "-", title: "Отпуск всего", editor: true},
                {field: "-", title: "Отгулено", editor: true},
                {field: "-", title: "Остаток на сегодня", editor: true},
                {
                    field: "date_dismissal",
                    title: "Дата увольнения",
                    type: "date",
                    editor: true,
                    format: "yyyy-mm-dd",
                },
                {
                    field: "reason_dismissal",
                    title: "Причина увольнения",
                    editor: true,
                },
            ];
            break;
        case "general-journal-staff":
            column["columns"] = [
                {field: "id", hidden: true},
                {
                    renderer: (value, record) => {
                        return record.staff.fio
                    },
                    title: "ФИО",
                },
                {
                    renderer: (value, record) => {
                        return record.staff.branch_name
                    },
                    title: "Филиал",
                },
                {field: "cost_day", title: "Стоимость дня"},
                {
                    renderer: (value, record) => {
                        return record.staff.salary
                    }, title: "З/П"
                },
                {field: "reduction_salary", title: "Уменьшить З/П", editor: true},
                {field: "increase_salary", title: "Увеличить З/П", editor: true},
                {field: "salary", title: "З/П К выплате"},
                {field: "paid", title: "З/П выплачена"},
                {field: "advance_payment", title: "Аванс", editor: true},
                {field: "comment", title: "Комментарий", editor: true},
                {
                    field: "payment_list", renderer: (value) => {
                        return `<a href="${value}">Скачать</a>`
                    }, title: "Расчётный лист"
                },
            ];
            column["detailTemplate"] = '<div><b>Кол-во дней:</b> {days}' +
                '<br><b>Посещаемость:</b> {attendance}' +
                '<br><b>Больничных:</b> {sick_days}' +
                '<br><b>Отпуск:</b> {vacation_days}' +
                '<br><b>Пропущено:</b> {truancy_days}</div>';
            break;
        case "general-journal-child":
            column["columns"] = [
                {field: "id", hidden: true},
                {
                    renderer: (value, record) => {
                        return record.child.fio
                    },
                    title: "ФИО",
                    editor: false,
                },
                {
                    renderer: (value, record) => {
                        return record.child.branch_name
                    },
                    title: "Филиал",
                    editor: false,
                },
                {field: "cost_day", title: "Стоимость дня"},
                {
                    renderer: (value, record) => {
                        return record.child.rate
                    }, title: "Тариф"
                },
                {field: "reduction_fees", title: "Уменьшить плату", editor: true},
                {field: "increase_fees", title: "Увеличить плату", editor: true},
                {field: "need_paid", title: "Необходимо оплатить"},
                {field: "paid", title: "Оплачено за текущий месяц"},
                {field: "debt", title: "Долг"},
                {field: "transferred", title: "Переносится на сл. месяц"},
                {field: "comment", title: "Комментарий", editor: true},
                {field: "notification", type: "checkbox", title: "Уведомление отправлено"},
            ];
            column["detailTemplate"] = '<div><b>Кол-во дней:</b> {days}' +
                '<br><b>Посещаемость:</b> {attendance}' +
                '<br><b>Больничных:</b> {sick_days}' +
                '<br><b>Отпуск:</b> {vacation_days}' +
                '<br><b>Пропущено:</b> {truancy_days}</div>';
            break;
        case "cost":
            column["columns"] = [
                {field: "id", hidden: true},
                {field: "amount", title: "Сумма"},
                {field: "date", title: "Дата"},
                {
                    renderer: (value, record) => {
                        return record.child != null ? record.child.fio : "Не указан";
                    }, title: "Ребёнок"
                },
                {
                    renderer: (value, record) => {
                        return record.staff != null ? record.staff.fio : "Не указан";
                    }, title: "Сотрудник"
                },
                {field: "branch_name", title: "Филиал"},
                {field: "comment", title: "Комментарий", editor: true},
            ];
            column["inlineEditing"] = {};
            break;
    }
    let grid = table.grid(column);
    grid.on("rowDataChanged", function (e, id, record) {
        var new_record = [];
        for (let [key, value] of entries(record)) {
            if (value != "" || key == "date_exclusion" || key == "date_dismissal") new_record[key] = value;
        }
        var data = $.extend(true, {_method: "PUT"}, new_record);
        $.ajax({
            url: "/action/" + tapath + "/" + id,
            data: data,
            method: "POST",
        }).fail(function () {
            alert("Failed to save.");
        });
    });
    grid.on("rowRemoving", function (e, $row, id, record) {
        if (confirm("Are you sure?")) {
            $.ajax({
                url: "/action/" + tapath + "/" + id,
                data: {_method: "DELETE"},
                method: "POST",
            })
                .done(function () {
                    grid.reload();
                })
                .fail(function () {
                    alert("Failed to delete.");
                });
        }
    });

    $(".btn-create-row").click(function () {
        $(".form-create").css("display", "block");
        $(".form-create").css("padding-right", "17px");
        $(".form-create").addClass("show");
        $("body").append(
            '<div class="modal-backdrop fade show form-create-dark"></div>'
        );

        $(document).mousedown(function (event) {
            if ((event.target, $(event.target).is(".form-create"))) {
                closeForm();
            }
        });

        $(".modal-header>.close").click(function (event) {
            closeForm();
        });
    });

    $(".custom-validation").submit(function (d) {
        var data = {};
        $(this)
            .serializeArray()
            .forEach((item) => {
                data[item.name] = item.value;
            });
        var tapath = $(this)[0].attributes.getNamedItem("tapath").value;
        $.ajax({url: "/action/" + tapath, data: data, method: "POST"})
            .done(function () {
                closeForm(true);
                grid.reload();
            })
            .fail(function () {
                alert("Failed to delete.");
            });
        return false;
    });

    $("#journal-date").change(function () {
        grid.reload({date: $(this)[0].value});
    })

    $("#income-date").change(function () {
        grid.reload({date: $(this)[0].value});
    })


}

$(document).ready(function () {
    table1 = $("#grid");
    table2 = $("#grid2");
    if (table1.length == 1) {
        current_table(table1);
    }
    if (table2.length == 1) {
        current_table(table2);
    }

    $.ajax({
        url: "/action/month",
        method: "GET",
        success: function (data) {
            $("#journal-date")[0].value = data
        },
    });

    // Формы //
    $.ajax({
        url: "/action/branch-array",
        method: "GET",
        success: function (data) {
            data.forEach((item) => {
                $('select[name="branch_id"]').append(
                    new Option(item.name, item.id)
                );
            });
        },
    });

    $.ajax({
        url: "/action/group-array",
        method: "GET",
        success: function (data) {
            $('select[name="group_id"]').prepend(
                new Option("Не выбрано", "", false, true)
            );
            data.forEach((item) => {
                $('select[name="group_id"]').append(
                    new Option(item.name, item.id)
                );
            });
        },
    });

    $.ajax({
        url: "/action/children",
        method: "GET",
        success: function (data) {
            $('select[name="child_id"]').prepend(
                new Option("Не выбрано", "", false, true)
            );
            data.records.forEach((item) => {
                $('select[name="child_id"]').append(
                    new Option(item.fio, item.id)
                );
            });
        },
    });

    $.ajax({
        url: "/action/staff",
        method: "GET",
        success: function (data) {
            $('select[name="staff_id"]').prepend(
                new Option("Не выбрано", "", false, true)
            );
            data.records.forEach((item) => {
                $('select[name="staff_id"]').append(
                    new Option(item.fio, item.id)
                );
            });
        },
    });

    $.ajax({
        url: "/action/institution",
        method: "GET",
        success: function (data) {
            data.forEach((item) => {
                $('select[name="institution_id"]').append(
                    new Option(item.name, item.id)
                );
            });
        },
    });

    $.ajax({
        url: "/action/position",
        method: "GET",
        success: function (data) {
            data.forEach((item) => {
                $('select[name="position_id"]').append(
                    new Option(item.name, item.id)
                );
            });
        },
    });

    function allHideIncome() {
        $("#income_child").hide();
        $("#income_staff").hide();
    }

    $("#type_income").change(function () {
        allHideIncome();
        switch ($(this)[0].value) {
            case "0":
                $("#income_bool").val(0);
                $("#income_staff").show();
                break;
            case "1":
                $("#income_bool").val(1);
                $("#income_child").show();
                break;
        }
    })

    if ($("#type_income").length == 1) {
        $("#type_income").val(0).change();
    }

    // $("#grid")[0].attributes.getNamedItem("tapath").value += "?date=08.08.2021";
    // console.log("set");
    // current_table($("#grid"));
});
