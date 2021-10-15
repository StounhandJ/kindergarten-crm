$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function changeColor(select, value) {
    select.parent().parent().removeClass();
    switch (value) {
        case "1":
            select.parent().parent().addClass("full-day");
            break;
        case "2":
            select.parent().parent().addClass("half-day");
            break;
        case "3":
            select.parent().parent().addClass("medic");
            break;
        case "4":
            select.parent().parent().addClass("arroad");
            break;
        case "5":
            select.parent().parent().addClass("out");
            break;
        case "6":
            select.parent().parent().addClass("weekend");
            break;
        default:
            select.parent().parent().addClass("zero");
            break;
    }
}

function createJournal(table_head, table_body, uri, array_name) {
    table_head.children().detach()
    table_body.children().detach()
    $.ajax({
        type: "GET",
        url: "/action/" + uri,
        success: function (month) {
            tr_month = $(`<tr></tr>`);
            journal_date = $(`<input id="journal-date" class="form-control input-mask" type="month" value="${month.month}">`)
            journal_date.change(function () {
                createJournal(table_head, table_body, uri.split("?")[0] + "?date=" + $(this)[0].value, array_name);
            })

            tr_month.append($(`<th scope="col"></th>`).append(journal_date));
            month.days.forEach((month_day) => tr_month.append(`<th scope="col">${month_day["name"]} ${month_day["num"]} </th>`))
            table_head.append(tr_month);

            month[array_name].forEach((child) => {
                tr = $(`<tr></tr>`);
                tr.append($(`<th scope="row">${child.fio}</th>`));
                child.days.forEach((day) => {
                    td = $(`<td>
                                <div class="input-group">
                                  <select class="custom-select_main">
                                     <option value="0" class="zero">Не выбрано</option>
                                     <option value="1" class="full-day">Целый день</option>
                                     <option value="2" class="half-day">Пол дня</option>
                                     <option value="3" class="medic">Больничный</option>
                                     <option value="4" class="arroad">Отпуск</option>
                                     <option value="5" class="out">Пропущено</option>
                                     <option value="6" class="weekend">Выходной</option>
                                  </select>
                                </div>
                             </td>`);
                    select = td.children().children();
                    select.attr({"id": day.id});
                    select.change(function () {
                        changeColor($(this), $(this)[0].value);
                    });
                    select.val(day.visit).change();
                    select.change(function () {
                        $.ajax({
                            type: "POST",
                            url:
                                "/action/" + uri + "/" + $(this)[0].id,
                            data: {
                                visit_id: $(this)[0].value,
                                _method: "PUT",
                            },
                        });
                        changeColor($(this), $(this)[0].value);
                    });
                    tr.append(td);
                });
                table_body.append(tr);
            });
        },
    });
}

$(document).ready(function () {
    $("select").each(function () {
        changeColor($(this), $(this)[0].value);
    });
    $("select").change(function () {
        changeColor($(this), $(this)[0].value);
    });
    if ($(".j_children_table").length != 0) {
        createJournal($("#j_children_table_head"), $("#j_children_table_body"), "journal-children", "children");
    }

    if ($(".j_staffs_table").length != 0) {
        createJournal($("#j_staffs_table_head"), $("#j_staffs_table_body"), "journal-staffs", "staff");
    }
});
