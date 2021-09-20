window.onload = function () {
    var scr = $("table").parent();
    scr.mousedown(function (event) {
        var startX = this.scrollLeft + event.pageX;
        var startY = this.scrollTop + event.pageY;
        scr.mousemove(function (event) {
            this.scrollLeft = startX - event.pageX;
            this.scrollTop = startY - event.pageY;
            return false;
        });
    });

    var scr_gj = $(".gj-grid-wrapper");
    // console.log(scr_gj);
    if (scr_gj[0]) {scr_gj[0].style.overflow = 'auto';}
    scr_gj.mousedown(function (event) {
        var startX = this.scrollLeft + event.pageX;
        var startY = this.scrollTop + event.pageY;
        scr_gj.mousemove(function (event) {
            this.scrollLeft = startX - event.pageX;
            this.scrollTop = startY - event.pageY;
            return false;
        });
    });


    $(window).mouseup(function () {
        scr.off("mousemove");
        scr_gj.off("mousemove");
    });
}