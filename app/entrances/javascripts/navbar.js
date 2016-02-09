var navSlidingLock = false;
function onWindowChange() {
    if (navSlidingLock) {
        setTimeout(500, onWindowChange);
        return;
    }
    navSlidingLock = true;
    var hei = $(window).scrollTop();
    var ele = $("#navbar");
    $("#topspace").height($("#navbar").height());
    if (hei > 0) {
        $("#toppic").slideUp();
        $("#topspace").slideDown(function() {
            ele.removeClass("navontop");
            ele.addClass("navnotop");
            navSlidingLock = false;
        });
    }
    else {
        ele.removeClass("navnotop");
        ele.addClass("navontop");
        $("#toppic").slideDown();
        $("#topspace").slideUp(function() {
            navSlidingLock = false;
        });
    }
    $("#bottomspace").height(Math.max(0, window.innerHeight - $("#navbar").height()));
}

$(document).ready(function() {
    $(window).scroll(onWindowChange);
    $(window).resize(onWindowChange);
    onWindowChange();
});

