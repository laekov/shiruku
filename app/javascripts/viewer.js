function htmlSpecialChars(str) {
	str = str.replace(/&/g, '&amp;');  
	str = str.replace(/</g, '&lt;');  
	str = str.replace(/>/g, '&gt;');  
	str = str.replace(/"/g, '&quot;');  
	str = str.replace(/'/g, '&#039;');  
	return str;  
}

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
				var content = res.content;
				if (cfg.catalog == 'code') {
					content = '<pre>' + htmlSpecialChars(content) + '</pre>';
				}
				else {
					content = content.replace(/\r/g, '\n');
					content = content.replace(/\n\n/g, '<br/>');
				}
				$("#pencontent").html(content);
			});
		}
	});
}

$(document).ready(function() {
	updateContent();
});

