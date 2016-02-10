function updatePage() {
	updateList("#list");
	createIndicator(function(ele) {
		$("#pageindicator").html(ele);
	});
}

$(document).ready(function() {
	var filter = getFilterByURL();
	var lastFetch = $.cookie("lastCatalogFetch");
	pageConf.size = 32;
	fetchList(filter, function(cata) {
		catalog = cata;
		if (catalog) {
			var penIdList = Array();
			for (var i in catalog) {
				penIdList.push(catalog[i].penId);
			}
			$.cookie("penIdList", JSON.stringify(penIdList));
		}
		updatePage();
	});
});

