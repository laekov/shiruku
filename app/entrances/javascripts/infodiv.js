function createInfoDiv(cfg, callback) { 
	var ele = $("#sampleinfodiv").clone();
	var date = new Date();
	date.setTime(cfg.modifyTime * 1000);
	ele.attr("id", "infodiv_" + cfg.penId);
	ele.find("#modifyTime").html(date.toGMTString());
	ele.find("#visit").html(Number(cfg.visitCount));
	for (var i in cfg.tag) {
		var tagref = $("#sampletag").clone();
		tagref.attr("id", "infodiv_" + cfg.penId + "tag" + cfg.tag[i]);
		tagref.attr("href", "/list/tag/" + cfg.tag[i]);
		tagref.html(cfg.tag[i] + "&nbsp;");
		ele.find("#tags").append(tagref);
	}
	if (!cfg.tag || !cfg.tag.length) {
		ele.find("#ptags").hide();
	}
	callback(ele);
}

