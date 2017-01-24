function htmlSpecialChars(str) {
    if (typeof(str) !== 'string') {
        return '';
    }
	str = str.replace(/&/g, '&amp;');  
	str = str.replace(/</g, '&lt;');  
	str = str.replace(/>/g, '&gt;');  
	str = str.replace(/"/g, '&quot;');  
	str = str.replace(/'/g, '&#039;');  
	return str;  
}

function updateJax(eleId, callback) {
	MathJax.Hub.processSectionDelay = 0;
	if (typeof(MathJax) == "object") {
		MathJax.Hub.Typeset(eleId, function() {
			callback();
		});
	} else if (typeof(callback) === 'function') {
		callback();
	}
};

function md2html(text) {
	if (typeof(config) == 'object') {
		if (config.catalog == "code") {
			lines = content.split("\n");
			text = "";
			for (var i in lines) {
				text += "\t" + "\t" + lines[i] + "\n";
			}
			return text;
		} else if (config.catalog == 'comment') {
			text = htmlSpecialChars(content).replace(/\n/g, "<br/>");
			return text;
		} else if (config.noModify) {
			return text;
		}
	}
	var converter = new showdown.Converter();
	return converter.makeHtml(text);
};

function renderContent(contentId, config) {
	MathJax.Hub.Config({
		processSectionDelay: 0
	});
	var updateElement = function() {
		var ele;
		if (typeof(contentId) === 'string') {
			ele = $('#' + contentId);
		} else {
			ele = $(contentId);
		}
		var text = ele.html();
		ele.html(md2html(text));
	};
	var updated = false;
	MathJax.Callback.Queue([ 'Typeset', MathJax.Hub, contentId, function() {
		updateElement();
		updated = true;
	} ]);
	setTimeout(function() {
		if (!updated) {
			updateElement();
		}
	}, 2000);
};

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
		$("#quickjump").removeClass('hidden');
	} else {
		getPenConfig(penId, function(res) {
			if (res.error) {
				$("#quickjump").find(targetId).html("出错了");
				$("#quickjump").find(targetId).removeAttr("href");
			} else {
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
		} else {
			var cfg = res;
			var date = new Date();
			date.setTime(cfg.modifyTime * 1000);
			$("#pentitle").html(cfg.title);
			document.title = document.title.replace(cfg.penId, cfg.title);
			if (!cfg.noInfo) {
				createInfoDiv(cfg, function(ele) {
					$("#peninfo").html(ele.html());
					$("#peninfo").removeClass('hidden');
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
					} else {
						setQuickJump("#prev", penIdList[pos - 1]);
						setQuickJump("#succ", penIdList[pos + 1]);
					}
				} else {
					$.post("/pen/query/neighbor/" + penId, {}, function(res) {
						setQuickJump("#prev", res.prev);
						setQuickJump("#succ", res.succ);
					});
				}
			}
			$.post("/pen/query/content/" + penId, {}, function(res) {
				$("#pencontent").html(res.content);
				renderContent("pencontent", cfg);
				$("#pencontentloading").hide();
			});
		}
	});
}

