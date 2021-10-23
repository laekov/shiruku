function createInfoDiv(cfg, callback) { 
	var ele = $("#sampleinfodiv").clone();
	if (cfg.modifyTime > 0) {
		var date = new Date();
		date.setTime(cfg.modifyTime * 1000);
		ele.find("#modifyTime").html("at " + date.toLocaleString());
	}
	ele.attr("id", "infodiv_" + cfg.penId);
	ele.find("#visit").html(Number(cfg.visitCount));
	if (cfg.author) {
		ele.find("#owner").html(cfg.author);
	}
	else {
		ele.find("#owner").html("Unknown owner");
	}
	if (typeof(createLikeDiv) == 'function') {
		ele.find("#likediv").html(createLikeDiv("/" + cfg.penId));
	}
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

