var navSlidingLock = false;

function getSearchDefaultText() {
    var reqURL = window.location.pathname.split('/');
    if (reqURL[1] == 'list' && reqURL[2] == 'search') {
        return reqURL[3];
    }
    else {
        return "Search";
    }
}

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
    $("#searchinput").val(getSearchDefaultText());
    $("#searchinput").focusin(function() {
        if ($(this).val() == getSearchDefaultText()) {
            $(this).val("");
        }
    });
    $("#searchinput").focusout(function() {
        if ($(this).val().length == 0) {
            $(this).val(getSearchDefaultText());
        }
    });
    $("#searchinput").keyup(function(key) {
        if (key.which == 13) {
            window.location.href = '/list/search/' + $(this).val();
        }
    });
});

