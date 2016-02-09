function showComment(penId, targetId) {
	$.post("/comment/query/pen/" + penId, {}, function(res) {
		var listDiv = $(targetId);
		var confList = res.list;
		confList.sort(function(a, b) {
            return b.priority - a.priority;
		});
		listDiv.html("");
		for (var i in confList) {
			$.post("/comment/query/content/" + penId + "/" + confList[i].commentId, {}, function(res) {
				var ele = $("#samplecomment").clone();
                var date = new Date();
				if (res.content) {
					ele.attr("id", res.content.commentId);
                    date.setTime(res.content.modifyTime * 1000);
					ele.find("#ownerinfo").html("Imported" + "At" + date.toGMTString());
					var content = res.content.content.replace(/\<br\/\>/g, '\n\n');
					content = htmlSpecialChars(content);
					content = content.replace(/\n\n/g, "<br/>");
					ele.find("#content").html(content);
					ele.show();
					listDiv.append(ele);
				}
			});
		}
	});
}

$(document).ready(function() {
	showComment(getCurrentPenId(), "#commentdiv");
});
