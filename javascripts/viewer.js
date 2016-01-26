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
			$("#pentitle").html(res.error);
		}
		else {
			var cfg = checkPenConfig(penId, res);
			$("#pentitle").html(cfg.title);
			$.post("/pen/query/content/" + penId, {}, function(res) {
				$("#pencontent").html(res.content);
			});
		}
	});
}

$(document).ready(function() {
	updateContent();
});

