function submitLogin(data) {
	$("#psuccess").addClass('hidden');
	$("#perror").addClass('hidden');
	$("#ppending").fadeIn();
	submitData(data, function(res) {
		$("#ppending").addClass('hidden');
		if (res.res == 'successful') {
			var prevPage = $.cookie("prevPage");
			if (prevPage) {
				window.location.href = prevPage;
			}
			else {
				window.location.href = '/';
			}
			$("#psuccess").fadeIn();
		}
		else {
			if (!res.res) {
				res.res = 'Unknown error';
			}
			if (res.field) {
				$("#" + res.field).addClass("texterror");
			}
			$("#perror").html(res.res);
			$("#perror").fadeIn();
		}
	});
}

function login() {
	var dataList = [ 'userId', 'passwd' ];
	var data = getFormData(dataList);
	data.requestURI = '/login/auth';
	submitLogin(data);
}

function register() {
	var dataList = [ 'userId', 'passwd', 'repeatPasswd', 'email', 'nickname', 'invitecode' ];
	for (var i in dataList) {
		$("#" + dataList[i]).removeClass("texterror");
	}
	var data = getFormData(dataList);
	data.requestURI = '/login/auth/register';
	submitLogin(data);
}

function setReturnActions(cList, action) {
	var list = cList;
	if (typeof(list) == 'string') {
		list = [ cList ];
	}
	for (var i in list) {
		$("#" + list[i]).keyup(function(key) {
			if (key.which == 13) {
				action();
			}
		});
	}
}

$(document).ready(function() {
    var reg = false;
    $("#regid").addClass('hidden');
	$("#login").click(login);
	$("#register").click(function() {
		$("#loginid").addClass('hidden');
		$("#regid").removeClass('hidden');
		$("#login").addClass('hidden');
        $("#registerinfo").removeClass('hidden');
        if (reg) {
			register();
		}
        reg = true;
	});
	setReturnActions(["userId", "passwd"], login);
});

