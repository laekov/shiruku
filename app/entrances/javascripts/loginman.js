var userId; 
function getMyInfo(field, callback) {
	$.post('/login/query/' + userId + '/' + field, function(res) {
		callback(res.data);
	});
}
function updateData(field) {
	getMyInfo(field, function(res) {
		$("#" + field).val(res);
	});
}

var getDataList = ['email', 'nickname'];
var postDataList = ['prevPasswd', 'passwd', 'repeatPasswd', 'email', 'nickname'];

function updateProfile() {
	var dataList = postDataList;
	for (var i in dataList) {
		$("#" + dataList[i]).removeClass("texterror");
	}
	var data = getFormData(postDataList);
	data.requestURI = "/login/auth/edit";
	$("#perror").hide();
	$("#psuccess").hide();
	$("#ppending").show();
	submitData(data, function(res) {
		$("#ppending").hide();
		if (res.res != 'success') {
			$("#perror").html(res.res);
			$("#perror").show();
			if (res.field) {
				$("#" + res.field).addClass("texterror");
			}
		}
		else {
			$("#psuccess").show();
		}
	});
}

$(document).ready(function() {
	$.post('/login/query/whoami', {}, function(res) {
		if (!res.userId) {
			$("#perror").html("Please log in first");
			$("#perror").show();
		}
		else {
			userId = res.userId;
			getMyInfo('source', function(source) {
				if (source != 'local') {
					$("#perror").html("You are not a local user");
				}
				else {
					$("#userId").html(userId);
					for (var i in getDataList) {
						updateData(getDataList[i]);
					}
					$("#localedit").show();
				}
			});
		}
	});
	$("#actupdate").click(updateProfile);
});

