var pageConf = {
	total: 0,
	cur: 0,
	size: 32
};

function redirectPage() {
	pageConf.cur = Number($(this).attr("id").substr(3));
	$.cookie('curPageId', pageConf.cur);
	updatePage();
}

function createPageHref(text, target) {
	var ele = $("#sampleindicatorref").clone();
	ele.attr("id", "to_" + target);
	ele.find("#content").html(text);
	ele.show();
	return ele;
}

function createIndicator(callback) {
	var ele = $("#sampleindicator").clone();
	ele.attr("id", "indicatordiv");
	ele.append(createPageHref("首页", 0));
	ele.append(createPageHref("上一页", Math.max(0, pageConf.cur - 1)));
	for (var i = 0; i < pageConf.total; ++ i) {
		var gele = createPageHref(String(i), String(i));
		if (i == pageConf.cur) {
			gele.addClass("indicatoritemcur");
		}
		ele.append(gele);
	}
	ele.append(createPageHref("下一页", Math.min(pageConf.total - 1, pageConf.cur + 1)));
	ele.append(createPageHref("末页", pageConf.total - 1));
	ele.show();
	callback(ele);
	$(".indicatoritem").click(redirectPage);
}

