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

function updateLogin() {
	$.post("/login/query/whoami", {}, function(res) {
		if (res.userId) {
			$("#navitem_login").addClass('hidden');
			$.post("/login/query/" + res.userId + "/nickname", {}, function(resNick) {
				$("#navitem_userinfo").find("#username").html(resNick.data);
			});
            $("#navitem_userinfo").find("#username").html(res.userId);
            $("#navitem_userinfo").removeClass('hidden');
			$("#navitem_logout").removeClass('hidden');
		} else {
			$("#navitem_userinfo").addClass('hidden');
			$("#navitem_login").removeClass('hidden');
			$("#navitem_logout").addClass('hidden');
		}
	});
    $("#navitem_userinfo").addClass('hidden');
    $("#navitem_login").addClass('hidden');
    $("#navitem_logout").addClass('hidden');
    $("#loginactions").fadeOut(300);
}

function recordPrevious() {
	var reqURL = window.location.pathname.split('/');
	if (reqURL[1] != 'login') {
		$.cookie("prevPage", window.location.pathname);
	}
}

$(document).ready(function() {
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
	$("#logout").click(function() {
		$.post("/login/auth/logout", {}, function() {
			updateLogin();
		});
	});
	updateLogin();
	recordPrevious();
});

