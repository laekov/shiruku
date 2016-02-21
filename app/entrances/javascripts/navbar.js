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

function updateLogin() {
	$.post("/login/query/whoami", {}, function(res) {
		if (res.userId) {
			$("#navitem_login").hide();
			$.post("/login/query/" + res.userId + "/nickname", {}, function(resNick) {
				$("#navitem_userinfo").find("#username").html(resNick.data);
			});
			$("#navitem_userinfo").show();
		}
		else {
			$("#navitem_userinfo").hide();
			$("#navitem_login").show();
		}
	});
	$("#loginactions").fadeOut(300);
}

function recordPrevious() {
	var reqURL = window.location.pathname.split('/');
	if (reqURL[1] != 'login') {
		$.cookie("prevPage", window.location.pathname);
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
	$("#navitem_userinfo").hover(function() {
		var pos = $(this).position();
		$("#loginactions").css("top", pos.top);
		$("#loginactions").css("left", pos.left);
		$("#loginactions").fadeIn(300);
	}, function() { });
	$("#loginactions").hover(function() { }, function() {
		$(this).fadeOut(300);
	});
	$("#logout").click(function() {
		$.post("/login/auth/logout", {}, function() {
			updateLogin();
		});
	});
	updateLogin();
	recordPrevious();
});

