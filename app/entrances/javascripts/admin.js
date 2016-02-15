var PenList = function() {
	var self = this;
	this.init = function() {
		$.post("/pen/query/catalog", {}, function(res) {
			if (res.catalog) {
				catalog = res.catalog;
				catalog.sort(function(a, b) {
					return b.priority - a.priority;
				});
				self.render();
			}
			else {
				$("#ui_penlist").find("#error").html("Failed to load list");
				$("#ui_penlist").find("#error").show();
			}
		});
	};
	this.render = function() {
		$("#ui_penlist").find("#list").html("");
		for (var i in catalog) {
			var ele = $("#samplelistitem").clone();
			ele.attr("id", "listitem_" + catalog[i].penId);
			ele.find("#penId").html(catalog[i].penId);
			ele.find("#title").html(catalog[i].title);
			ele.show();
			$("#ui_penlist").find("#list").append(ele);
		}
		$(".actremovepen").click(function() {
			var penId = $(this).parent().find("#penId").html();
			var data = {
				requestURI: "/admin/pen/remove",
				penId: penId
			};
			var me = $(this);
			submitData(data, function(res) {
				if (res.error) {
					me.html(res.error);
					me.addClass("red");
				}
				else {
					self.init();
				}
			});
		});
	}
};
var penList;

var PenEdit = function() {
	var self = this;
	this.init = function() {
	}
};
var penEdit;

var navList;

$(document).ready(function() {
	$.post("/admin/query/access", function(res) {
		if (res.error) {
			$("#perror").html(res.error);
			$("#perror").show();
		}
		else {
			navList = res.accessList;
			for (var i in navList) {
				var id = navList[i];
				var ele = $("#sampleformnavitem").clone();
				var pageEle = $("#ui_" + id);
				ele.attr("id", "formnav_" + id);
				ele.find("#title").html(pageEle.find("#title").html());
				ele.find("#divid").html(id);
				ele.show();
				$("#formnavdiv").append(ele);
			}
			if (navList.indexOf("penlist") != -1) {
				penList = new PenList();
				penList.init();
			}
			if (navList.indexOf("penedit") != -1) {
				penEdit = new PenEdit();
				penEdit.init();
			}
			$(".actformnavitem").click(function() {
				var myId = $(this).find("#divid").html();
				for (var i in navList) {
					var navEle = $("#formnav_" + navList[i]).find("#title");
					navEle.removeClass("navitemon");
					navEle.removeClass("navitemoff");
					if (navList[i] == myId) {
						$("#ui_" + navList[i]).show();
						navEle.addClass("navitemon");
					}
					else {
						$("#ui_" + navList[i]).hide();
						navEle.addClass("navitemoff");
					}
				}
			});
		}
	});
});

