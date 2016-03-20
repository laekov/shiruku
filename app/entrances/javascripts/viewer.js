function htmlSpecialChars(str) {
	str = str.replace(/&/g, '&amp;');  
	str = str.replace(/</g, '&lt;');  
	str = str.replace(/>/g, '&gt;');  
	str = str.replace(/"/g, '&quot;');  
	str = str.replace(/'/g, '&#039;');  
	return str;  
}

function renderContent(content, config) {
	var text = content;
	if (typeof(config) == 'object') {
		if (config.catalog == "code") {
			lines = content.split("\n");
			text = "";
			for (var i in lines) {
				text += "\t" + "\t" + lines[i] + "\n";
			}
		}
		else if (config.catalog == 'comment') {
			text = htmlSpecialChars(content).replace(/\n/g, "<br/>");
			return text;
		}
	}
	var converter = new Showdown.converter;
	return converter.makeHtml(text);
}

function getCurrentPenId() {
	var path = window.location.pathname.split('/');
	if (path.length == 3 && path[1] == 'view') {
		return path[2];
	}
	else if (path[1] == 'admin') {
		return $("#editpenid").val();
	}
	else {
		return "empty";
	}
}

function getPenConfig(penId, callback) {
	$.post("/pen/query/config/" + penId, {}, function(res) {
		callback(res);
	});
}

function setQuickJump(targetId, penId) {
	if (typeof(penId) != 'string') {
		$("#quickjump").find(targetId).html("没有了");
		$("#quickjump").find(targetId).removeAttr("href");
		$("#quickjump").show();
	}
	else {
		getPenConfig(penId, function(res) {
			if (res.error) {
				$("#quickjump").find(targetId).html("出错了");
				$("#quickjump").find(targetId).removeAttr("href");
			}
			else {
				$("#quickjump").find(targetId).html(res.title);
				$("#quickjump").find(targetId).attr("href", "/view/" + penId);
			}
			$("#quickjump").show();
		});
	}
}

function updateContent() {
	var penId = getCurrentPenId();
	getPenConfig(penId, function(res) {
		if (res.error) {
			$("#pentitle").html("Viewer error");
			$("#pencontentloading").html(res.error);
		}
		else {
			var cfg = res;
			var date = new Date();
			date.setTime(cfg.modifyTime * 1000);
			$("#pentitle").html(cfg.title);
			document.title = document.title.replace(cfg.penId, cfg.title);
			if (!cfg.noInfo) {
				createInfoDiv(cfg, function(ele) {
					$("#peninfo").html(ele.html());
					$("#peninfo").show();
					if (typeof(initLikeDiv) == 'function') {
						initLikeDiv("/" + cfg.penId);
					}
				});
				if ($.cookie("penIdList")) {
					var penIdList = JSON.parse($.cookie("penIdList"));
					var pos = penIdList.indexOf(cfg.penId);
					if (pos == -1) {
						$.post("/pen/query/neighbor/" + penId, {}, function(res) {
							setQuickJump("#prev", res.prev);
							setQuickJump("#succ", res.succ);
						});
					}
					else {
						setQuickJump("#prev", penIdList[pos - 1]);
						setQuickJump("#succ", penIdList[pos + 1]);
					}
				}
				else {
					$.post("/pen/query/neighbor/" + penId, {}, function(res) {
						setQuickJump("#prev", res.prev);
						setQuickJump("#succ", res.succ);
					});
				}
			}
			$.post("/pen/query/content/" + penId, {}, function(res) {
				$("#pencontentloading").hide();
				var content = renderContent(res.content, cfg);
				$("#pencontent").html(content);
				if (typeof(MathJax) == 'object') {
					MathJax.Hub.Typeset();
				}
			});
		}
	});
}

