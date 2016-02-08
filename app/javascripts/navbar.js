function onWindowScroll() {
    var hei = $(window).scrollTop();
    var ele = $("#navbar");
    if (hei > 0) {
        ele.removeClass("navontop");
        ele.addClass("navnotop");
    }
    else {
        ele.removeClass("navnotop");
        ele.addClass("navontop");
    }
}

$(document).ready(function() {
    $(window).scroll(onWindowScroll);
});
