mounth = {
    name_mounth: "Сентябрь",
    days: 20,
    children: [
        { fio: "Абрамов", days: [1, 2, 1, 4, 1, 2, 0] },
        { fio: "Глак", days: [1, 5, 2, 1, 0, 0] },
    ],
};

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
    // $.ajax({
    //     type: "POST",
    //     cache: false,
    //     processData: false,
    //     contentType: false,
    //     url: "",
    //     success: function (mounth) {
    mounth.children.forEach((child) => {
        tr = $(`<tr></tr>`);
        tr.append($(`<th scope="row">${child.fio}</th>`));
        child.days.forEach((day) => {
            td = $(`<td>
            <div class="input-group">        
            <select class="custom-select">            
            <option value="0">Не выбрано</option>            
            <option value="1">Целый день</option>            
            <option value="2">Пол дня</option>            
                                <option value="3">Больничный</option>            
                                <option value="4">Отпуск</option>            
                                <option value="5">Пропущено</option>        
                                </select>    
                                </div>
                                </td>`);
            changeColor(
                td.children().children().val(day).change(),
                day.toString()
            );
            tr.append(td);
        });
        $("#j_children_table_body").append(tr);
    });
    //     },
    // });
});
