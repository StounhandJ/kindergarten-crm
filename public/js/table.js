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
    const form_create = $(".form-create");
    form_create.css("display", "none");
    form_create.css("padding-right", "");
    form_create.removeClass("show");
    $(".form-create-dark").remove();
    if (clear) {
        form_create
            .find("input")
            .each(function (i, item) {
                if (item.id !== "income_bool" && item.id !== "input-date")
                    item.value = "";
            });

        form_create
            .find("select")
            .each(function (i, item) {
                item.value = "";
            });
    }

}

function current_table(table) {
    const tapath = table[0].attributes.getNamedItem("tapath").value;
    let grid;

    let isEditManager = true;
    let editManager = function (value, record, $cell, $displayEl, id, $grid) {
        let data = $grid.data(),
            $edit = $('<button role="edit" class="gj-button-md"><i class="gj-icon pencil"></i> Изменить</button>').attr('data-key', id),
            $delete = $('<button role="delete" class="gj-button-md"><i class="gj-icon delete"></i> Удалить</button>').attr('data-key', id),
            $update = $('<button role="update" class="gj-button-md"><i class="gj-icon check-circle"></i> Сохранить</button>').attr('data-key', id).hide(),
            $cancel = $('<button role="cancel" class="gj-button-md"><i class="gj-icon cancel"></i> Отмена</button>').attr('data-key', id).hide();
        $edit.on('click', function () {
            $grid.edit($(this).data('key'));
            $edit.hide();
            $delete.hide();
            $update.show();
            $cancel.show();
        });
        $delete.on('click', function () {
            $grid.removeRow($(this).data('key'));
        });
        $update.on('click', function () {
            $grid.update($(this).data('key'));
            $edit.show();
            $delete.show();
            $update.hide();
            $cancel.hide();
        });
        $cancel.on('click', function () {
            $grid.cancel($(this).data('key'));
            $edit.show();
            $delete.show();
            $update.hide();
            $cancel.hide();
        });
        $displayEl.empty().append($edit).append($delete).append($update).append($cancel);
    }

    var column = {
        dataSource: "/action/" + tapath,
        uiLibrary: "bootstrap4",
        primaryKey: "id",
        resizableColumns: true,
        notFoundText: "Записей нет",
        inlineEditing: {mode: "command", managementColumn: false},
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
                {
                    field: "document_url", renderer: (value) => {
                        return `<a target="_blank" href="${value}">Скачать</a>`
                    }, title: "Договор"
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
                {field: "vacation_total", title: "Отпуск всего", editor: true},
                {field: "vacation_off", title: "Отгуляно", editor: true},
                {field: "vacation_for_today", title: "Остаток на сегодня", editor: true},
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
                // {field: "advance_payment", title: "Аванс", editor: true},
                {field: "comment", title: "Комментарий", editor: true},
                {
                    field: "payment_list", renderer: (value) => {
                        return `<a target="_blank" href="${value}">Скачать</a>`
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
                {
                    field: "notification", renderer: (value, data) => {
                        var id = data["id"];
                        var month = data["month"];

                        var color = value === -1 ? "red" : (value === 0 ? "with" : "green")
                        var text = value === -1 ? "Ошибка" : (value === 0 ? "Отправить" : "Успешно")

                        var button_notification = $(`<button style="background-color: ${color};">${text}</>`)
                        button_notification.click(function () {
                            $(this).css("background-color", "blue")
                            $(this)[0].innerText = "Отправка..."
                            $.ajax({
                                url: "/action/notification/",
                                data: {"child_id": id, "date": month},
                                method: "POST"
                            });
                        })
                        return button_notification
                    }, title: "Отправить уведомление"
                },
            ];
            column["detailTemplate"] = '<div><b>Кол-во дней:</b> {days}' +
                '<br><b>Посещаемость:</b> {attendance}' +
                '<br><b>Больничных:</b> {sick_days}' +
                '<br><b>Отпуск:</b> {vacation_days}' +
                '<br><b>Пропущено:</b> {truancy_days}</div>';
            break;
        case "category-cost":
            editManager = function (value, record, $cell, $displayEl, id, $grid) {
                const data = $grid.data(),
                    $edit = $('<button role="edit" class="gj-button-md"><i class="gj-icon pencil"></i> Изменить</button>').attr('data-key', id),
                    $update = $('<button role="update" class="gj-button-md"><i class="gj-icon check-circle"></i> Сохранить</button>').attr('data-key', id).hide(),
                    $cancel = $('<button role="cancel" class="gj-button-md"><i class="gj-icon cancel"></i> Отмена</button>').attr('data-key', id).hide();
                $edit.on('click', function () {
                    $grid.edit($(this).data('key'));
                    $edit.hide();
                    $update.show();
                    $cancel.show();
                });
                $update.on('click', function () {
                    $grid.update($(this).data('key'));
                    $edit.show();
                    $update.hide();
                    $cancel.hide();
                });
                $cancel.on('click', function () {
                    $grid.cancel($(this).data('key'));
                    $edit.show();
                    $update.hide();
                    $cancel.hide();
                });
                $displayEl.empty().append($edit).append($update).append($cancel);
            }
            column["columns"] = [
                {field: "id", hidden: true},
                {field: "name", title: "Название", editor: true},
                {field: "is_profit", title: "Это доход", type: 'checkbox', editor: false, align: 'center'},
                {field: "is_set_child", title: "Указывать ребенка", type: 'checkbox', editor: true, align: 'center'},
                {field: "is_set_staff", title: "Указывать сотрудника", type: 'checkbox', editor: true, align: 'center'},
                {field: "is_active", title: "Активно", type: 'checkbox', editor: true, align: 'center'}
            ];
            break;
        case "cost":
            editManager = function (value, record, $cell, $displayEl, id, $grid) {
                var data = $grid.data(),
                    $delete = $('<button role="delete" class="gj-button-md"><i class="gj-icon delete"></i> Удалить</button>').attr('data-key', id);

                $delete.on('click', function () {
                    $grid.removeRow($(this).data('key'));
                });
                $displayEl.empty().append($delete);
            }
            column["columns"] = [
                {field: "id", hidden: true},
                {field: "amount", title: "Сумма"},
                {field: "category_name", title: "Категория"},
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
            break;
    }
    if (isEditManager)
        column["columns"].push({width: 300, align: 'center', renderer: editManager});
    grid = table.grid(column);
    grid.on("rowDataChanged", function (e, id, record) {
        var new_record = [];
        for (let [key, value] of entries(record)) {
            console.log(key, value);
            if (value !== "" || key === "date_exclusion" || key === "date_dismissal") new_record[key] = value;
        }
        const data = $.extend(true, {_method: "PUT"}, new_record);
        $.ajax({
            url: "/action/" + tapath + "/" + id,
            data: data,
            method: "POST",
        }).fail(function () {
            alert("Ошибка при сохранение");
        });
    });
    grid.on("rowRemoving", function (e, $row, id, record) {
        if (confirm("Вы уверены?")) {
            $.ajax({
                url: "/action/" + tapath.split('?')[0] + "/" + id,
                data: {_method: "DELETE"},
                method: "POST",
            })
                .done(function () {
                    grid.reload();
                })
                .fail(function () {
                    alert("Ошибка при удалении");
                });
        }
    });

    $(".btn-create-row").click(function () {
        const form_create = $(".form-create");
        form_create.css("display", "block");
        form_create.css("padding-right", "17px");
        form_create.addClass("show");
        $("body").append(
            '<div class="modal-backdrop fade show form-create-dark"></div>'
        );

        $(document).mousedown(function (event) {
            if ((event.target, $(event.target).is(".form-create"))) {
                closeForm();
            }
        });

        $(".modal-header>.close").click(function () {
            closeForm();
        });
    });

    $("#journal-date").change(function () {
        grid.reload({date: $(this)[0].value});
    })

    $("#income-date").change(function () {
        grid.reload({date: $(this)[0].value});
    })


}

$(document).ready(function () {
    let table1 = $("#grid");
    let table2 = $("#grid2");
    const journal_date = $("#journal-date");
    const income_date = $("#income-date");
    const input_date = $("#input-date");

    if (table1.length === 1) {
        current_table(table1);
    }
    if (table2.length === 1) {
        current_table(table2);
    }

    $(".custom-validation").submit(function () {
        const data = {};
        $(this)
            .serializeArray()
            .forEach((item) => {
                if (item.name === "is_set_child" || item.name === "is_set_staff")
                    data[item.name] = true;
                else if (item.name === "is_profit")
                    data["is_profit"] = $('input[name=is_profit]:checked', '.custom-validation')[0].value;
                else
                    data[item.name] = item.value;
            });
        var tapath = $(this)[0].attributes.getNamedItem("tapath").value;
        $.ajax({url: "/action/" + tapath, data: data, method: "POST"})
            .done(function () {
                closeForm(true);
                input_date[0] ? input_date[0].value = data : "";
            })
            .fail(function () {
                alert("Ошибка при создании");
            });
        return false;
    });

    if (journal_date[0] || income_date[0] || input_date[0]) {
        $.ajax({
            url: "/action/month",
            method: "GET",
            success: function (data) {
                journal_date[0] ? journal_date[0].value = data : "";
                income_date[0] ? income_date[0].value = data : "";
                input_date[0] ? input_date[0].value = data : "";
            },
        });
    }

    if ($("#cash")[0]) {
        $.ajax({
            url: "/action/cost-cash",
            method: "GET",
            success: function (data) {
                $("#cash")[0].innerText = data["amount"];
            },
        });
    }
    // Формы //
    if ($('select[name="branch_id"]')[0]) {
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
    }

    if ($('select[name="group_id"]')[0]) {
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
    }

    if ($('select[name="child_id"]')[0]) {
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
    }

    if ($('select[name="staff_id"]')[0]) {
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
    }

    if ($('select[name="institution_id"]')[0]) {
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
    }

    if ($('select[name="position_id"]')[0]) {
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
    }

    $("#category_id").on('change', function () {
        allHideIncome();
        const option = $(this).children(`option[value="${$(this)[0].value}"]`);
        if (option[0].attributes.show_child.value === "true")
            $("#income_child").show();
        if (option[0].attributes.show_staff.value === "true")
            $("#income_staff").show();
    })

    if ($('#category_id').length) {
        $.ajax({
            url: "/action/category-cost-array",
            method: "GET",
            success: function (data) {
                data.forEach((item) => {
                    $('#category_id').append(
                        $(`<option show_child="${item.is_set_child}" show_staff="${item.is_set_staff}" value="${item.id}">${item.name} - ${item.is_profit ? "Доход" : "Расход"}</option>`)
                    );
                });
                $('#category_id').val($('#category_id option:first')[0].value).change();

            },
        });
    }

    function allHideIncome() {
        $("#income_child").hide();
        $("#income_staff").hide();
    }

    $(".btn-download-vedomosty").click(function () {
        const url = new URL(window.location.origin + "/document/vedomosty");
        url.searchParams.set('date', $("#journal-date")[0].value);
        window.open(url, '_blank');
    });

});
