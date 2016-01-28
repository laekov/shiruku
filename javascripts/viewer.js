function getCurrentPenId() {
	var path = window.location.pathname.split('/');
	if (path.length == 3 && path[1] == 'view') {
		return path[2];
	}
	else {
		return "empty";
	}
}

function updateContent() {
	var penId = getCurrentPenId();
	$.post("/pen/query/config/" + penId, {}, function(res) {
		if (res.error) {
			$("#pentitle").html("Viewer error");
			$("#pencontentloading").html(res.error);
		}
		else {
			var cfg = checkPenConfig(penId, res);
			var date = new Date();
			date.setTime(cfg.modifyTime * 1000);
			$("#pentitle").html(cfg.title);
			$("#peninfo").find("#posttime").html(date.toGMTString());
			$("#peninfo").find("#visitcount").html(cfg.visitCount);
			$("#peninfo").show();
			$.post("/pen/query/content/" + penId, {}, function(res) {
				$("#pencontentloading").hide();
				$("#pencontent").html(res.content);
			});
		}
	});
}

$(document).ready(function() {
	updateContent();
});

