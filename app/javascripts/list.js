function getFilterByURL() {
	var ret = false;
	var req = window.location.pathname.split('/');
	if (req[1] == 'list') {
		if (req.length == 2) {
			ret = {};
		}
		else if (req[2] == 'catalog') {
			if (req[3]) {
				ret = { equal: { catalog: req[3] } };
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
			callback(res.catalog);
		});
	}
}

var cacheCatalog = false;
var cacheFilter = getFilterByURL();

function updateList() {
	var cata = cacheCatalog;
	$("#list").html("");
	if (cata === false) {
		$("#error").html("Catalog fetching error");
		$("#error").show();
	}
	else {
		$("#error").hide();
		for (var i = 0; i < cata.length; ++ i) {
			var date = new Date();
			date.setTime(cata[i].modifyTime * 1000);
			var ele = $("#samplelistitem").clone();
			ele.attr("id", "pen_" + cata[i].penId);
			ele.find("#title").html(cata[i].title);
			ele.find("#title").attr("href", "/view/" + cata[i].penId);
			ele.find("#modifyTime").html(date.toGMTString());
			$("#list").append(ele);
			ele.show();
		}
	}
}

$(document).ready(function() {
	fetchList(cacheFilter, function(cata) {
		cacheCatalog = cata;
		if (cacheCatalog) {
			cacheCatalog.sort(function(x, y) {
				return Number(y.priority) - Number(x.priority);
			});
			for (i in cacheCatalog) {
				if (cacheCatalog[i].penId == 'dbimport_00104') {
					console.log('smg');
				}
			}
		}
		updateList();
	});
});

