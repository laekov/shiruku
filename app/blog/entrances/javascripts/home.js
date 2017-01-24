var pageConf;

$(document).ready(function() {
	showComment('/recent', "#recentcommentdiv");
	fetchList({}, function(cata) {
		var cataCnt = Array();
		for (var i in cata) {
			if (!cataCnt[cata[i].catalog] || cataCnt[cata[i].catalog] < 8) {
				if (!cataCnt[cata[i].catalog]) {
					cataCnt[cata[i].catalog] = 1;
				}
				else {
					++ cataCnt[cata[i].catalog];
				}
				var div = $("#list_" + cata[i].catalog);
				if (div) {
					div.find("#loading").hide();
					var ele = $("#samplepenlink").clone();
					ele.attr("id", "penlink_" + cata[i].penId);
					ele.attr("href", "/view/" + cata[i].penId);
					ele.html(cata[i].title);
					div.append(ele);
				}
			}
		}
	});
});
