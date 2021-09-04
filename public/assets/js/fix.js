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
        default:
            select.parent().parent().addClass("zero");
            break;
    }
}

$(document).ready(function () {
    $("select").each(function () {
        changeColor($(this), $(this)[0].value);
    });
    $("select").change(function () {
        changeColor($(this), $(this)[0].value);
    });
    $.ajax({
        type: "GET",
        url: "/action/journal-children",
        success: function (month) {
            tr_month = $(`<tr></tr>`);
            tr_month.append(`<th scope="col">${month.name_month}</th>`);
            for (let month_day = 1; month_day <= month.days; month_day++) {
                tr_month.append(`<th scope="col">${month_day}</th>`);
            }
            $("#j_children_table_head").append(tr_month);

            month.children.forEach((child) => {
                tr = $(`<tr></tr>`);
                tr.append($(`<th scope="row">${child.fio}</th>`));
                child.days.forEach((day) => {
                    td = $(`<td>
                <div class="input-group">
                <select class="custom-select_main">
                <option value="0">Не выбрано</option>
                <option value="1">Целый день</option>
                <option value="2">Пол дня</option>
                                    <option value="3">Больничный</option>
                                    <option value="4">Отпуск</option>
                                    <option value="5">Пропущено</option>
                                    </select>
                                    </div>
                                    </td>`);
                    select = td.children().children();
                    select.attr({"id": day.id, "child_id": child.id});
                    select.change(function () {
                        changeColor($(this), $(this)[0].value);
                    });
                    select.val(day.visit).change();
                    select.change(function () {
                        $.ajax({
                            type: "POST",
                            url:
                                "/action/journal-children/" + $(this)[0].id,
                            data: {
                                visit_id: $(this)[0].value,
                                _method: "PUT",
                            },
                        });
                        changeColor($(this), $(this)[0].value);
                    });
                    tr.append(td);
                });
                $("#j_children_table_body").append(tr);
            });
        },
    });
});
