function clearStatus() {
	$("#perror").addClass('hidden');
	$("#ppending").addClass('hidden');
	$("#psuccess").addClass('hidden');
	$("#pres").addClass('hidden');
}
function showStatus(id, word) {
	clearStatus();
	if (word != null) {
		$("#p" + id).html(word);
	}
	$("#p" + id).removeClass('hidden');
}

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
				$("#ui_penlist").find("#error").removeClass('hidden');
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
			ele.removeClass('hidden');
			$("#ui_penlist").find("#list").append(ele);
		}
		$(".actviewpen").click(function() {
			var penId = $(this).parent().find("#penId").html();
			penEdit.load(penId);
			$("#formnav_penedit").find("#content").click();
		});
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
	this.genPreview = function() {
		$("#previewdiv").html($("#editcontenttext").val());
		renderContent("previewdiv", {});
		var maxWidth = $("#pagecontentdiv").width() - $("#editcontenttext").width() - 32;
		$("#previewdiv").width(maxWidth);
	}
	this.load = function(penId) {
		if ($("#ui_penedit").css("display") != "none") {
			showStatus("pending", null);
		}
		$("#editpenid").val(penId);
		$.post("/admin/pen/content/" + penId, {}, function(res) {
			$("#editcontenttext").val(res.content);
			$("#editconfigtext").val(res.config);
			self.genPreview();
			if ($("#ui_penedit").css("display") != "none") {
				showStatus("res", "loaded");
			}
		});
	}
	this.upload = function(btnId) {
		showStatus("pending", null);
		var data = {
			requestURI: '/admin/pen/update',
			penId: $("#editpenid").val()
		};
		if (['actsubmitcontent', 'actsubmitboth'].indexOf(btnId) != -1) {
			data.content = $("#editcontenttext").val();
		}
		if (['actsubmitconfig', 'actsubmitboth'].indexOf(btnId) != -1) {
			data.config = $("#editconfigtext").val()
		}
		submitData(data, function(res) {
			if (res.error) {
				showStatus("error", res.error);
			}
			else {
				showStatus("res", res.res);
			}
		});
	}
	this.init = function() {
		$("#actgenerateid").click(function() {
			$.post('/admin/pen/genid', {}, function(res) {
				var penId = res.id ? res.id : 'Untitled';
				self.load(penId);
			});
		});
		$("#actgenerateid").click();
		$("#actreloadpen").click(function() {
			self.load($("#editpenid").val());
		});
		$("#actgeneratepreview").click(function() {
			self.genPreview();
		});
		$("#actsubmitcontent").click(function() {
			self.upload($(this).attr("id"));
		});
		$("#actsubmitconfig").click(function() {
			self.upload($(this).attr("id"));
		});
		$("#actsubmitboth").click(function() {
			self.upload($(this).attr("id"));
		});
	}
};
var penEdit;

var Invite = function() {
	var self = this;
	this.loadList = function() {
		$("#invitelist").html("");
		$.post("/admin/invite/query", {}, function(res) {
			for (var i in res.list) {
				var ele = $("#sampleinvitecode").clone();
				ele.find("#value").html(res.list[i].value);
				ele.find("#used").html(res.list[i].used ? res.list[i].owner : "----");
				ele.removeClass('hidden');
				$("#invitelist").append(ele);
			}
		});
	}
	this.init = function() {
		self.loadList();
		$("#actgenerateinvitecode").click(function() {
			var num = Number($("#invitecodegeneratecount").val());
			if (isFinite(num) && num > 0 && num < 100) {
				$.post("/admin/invite/generate/" + num, {}, function() {
					self.loadList();
				});
			}
		});
		$("#invitecodegeneratecount").keyup(function(key) {
			if (key.which == 13) {
				$("#actgenerateinvitecode").click();
			}
		});
	}
};
var invite;

var navList;

function onWindowResize() {
	var cWidth = $("#pagecontentdiv").width();
	var textWidth = (cWidth - 16) / 2;
	$("#editcontenttext").width(textWidth);
	$("#editconfigtext").width(textWidth);
}

function initList() {
	$.post("/admin/query/access", function(res) {
		if (res.error) {
			$("#perror").html(res.error);
			$("#perror").removeClass('hidden');
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
				ele.removeClass('hidden');
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
			if (navList.indexOf("invite") != -1) {
				invite = new Invite;
				invite.init();
			}
			$(".actformnavitem").click(function() {
				var myId = $(this).find("#divid").html();
				for (var i in navList) {
					var navEle = $("#formnav_" + navList[i]);
					if (navList[i] == myId) {
						$("#ui_" + navList[i]).removeClass('hidden');
						navEle.addClass("active");
					} else {
						$("#ui_" + navList[i]).addClass('hidden');
						navEle.removeClass("active");
					}
				}
			});
		}
	});
}

$(window).resize(onWindowResize);
$(document).ready(function() {
	onWindowResize();
    initList();
});

