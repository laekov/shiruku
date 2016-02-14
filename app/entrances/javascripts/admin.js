$(document).ready(function() {
	$.post("/admin/query/access", function(res) {
		console.log(res);
		if (res.error) {
			$("#perror").html(res.error);
			$("#perror").show();
		}
		else {
			for (var i in res.accessList) {
				var id = res.accessList[i];
				var ele = $("#sampleformnavitem");
				var pageEle = $("#ui_" + id);
				ele.attr("id", "formnav_" + id);
				ele.find("#content").html(pageEle.find("#title").html());
				ele.show();
				$("#formnavdiv").append(ele);
			}
		}
	});
});
