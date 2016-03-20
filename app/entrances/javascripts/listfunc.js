var catalogUpdateInterval = 1;
var catalog = false;

function getFilterByURL() {
	var ret = false;
	var req = window.location.pathname.split('/');
	while (req.length && req[req.length - 1] == '') {
		req.pop();
	}
	if (req[1] == 'list') {
		if (req.length == 2) {
			ret = {};
		}
		else if (req[2] == 'catalog') {
			if (req[3]) {
				ret = { equal: { catalog: req[3] } };
			}
		}
		else if (req[2] == 'tag') {
			if (req[3]) {
				ret = { inArray: { tag: req[3] } };
			}
		}
        else if (req[2] == 'search') {
            if (req[3]) {
                ret = { vague: [ req[3] ] };
            }
        }
    }
	return ret;
}

function fetchList(filter, callback) {
	if (filter === false) {
		callback(false);
	}
	else {
		$.post("/entrances/redirectpost.php", {
			requestURI: "/pen/query/catalog",
			filter: JSON.stringify(filter)
		},
		function(res) {
			if (res.catalog) {
				res.catalog.sort(function(x, y) {
					return Number(y.priority) - Number(x.priority);
				});
				if (pageConf) {
					pageConf.total = Math.ceil(res.catalog.length / pageConf.size);
				}
			}
			callback(res.catalog);
		});
	}
}

function updateList(listId) {
	$(listId).html("");
	if (!catalog) {
		$("#error").html("Catalog fetching error");
		$("#error").show();
	}
	else {
		var cata = catalog;
		$("#error").hide();
		var iLeft = 0, iRight = cata.length;
		if (pageConf) {
			iLeft = Math.max(0, pageConf.cur * pageConf.size);
			iRight = Math.min(cata.length, iLeft + pageConf.size);
		}
		for (var i = iLeft; i < iRight; ++ i) {
			var date = new Date();
			date.setTime(cata[i].modifyTime * 1000);
			var ele = $("#samplelistitem").clone();
			ele.attr("id", "pen_" + cata[i].penId);
			ele.find("#title").html(cata[i].title + "&nbsp;");
			ele.find("#title").attr("href", "/view/" + cata[i].penId);
			ele.find("#modifyTime").html(date.toGMTString());
			++ loadTriggerCount;
			$.post("/pen/query/preview/" + cata[i].penId, {}, function(res) {
				$("#pen_" + res.penId).find("#preview").html(renderContent(res.content, {}));
				finishLoadTrigger();
			});
			createInfoDiv(cata[i], function(gele) {
				ele.find("#infodiv").html(gele.html());
				ele.show();
				$(listId).append(ele);
			});
		}
	}
}

