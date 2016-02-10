var navSlidingLock = false;

function updateSpaceHeight() {
    $("#bottomspace").height(Math.max(0, window.innerHeight - $("#navbardiv").height() - $("#pagecontentdiv").height()));
}

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
			updateSpaceHeight();
        });
    }
    else {
        ele.removeClass("navnotop");
        ele.addClass("navontop");
        $("#toppic").slideDown();
        $("#topspace").slideUp(function() {
			updateSpaceHeight();
            navSlidingLock = false;
        });
    }
}

$(document).ready(function() {
    $(window).scroll(onWindowChange);
    $(window).resize(onWindowChange);
    onWindowChange();
});

