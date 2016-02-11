function showComment(queryStr, targetId) {
	$.post("/comment/query/" + queryStr, {}, function(res) {
		var listDiv = $(targetId);
		var confList = res.list;
		confList.sort(function(a, b) {
            return b.priority - a.priority;
		});
		listDiv.html("");
		for (var i in confList) {
			$.post("/comment/query/content/" + confList[i].penId + "/" + confList[i].commentId, {}, function(res) {
				var ele = $("#samplecomment").clone();
                var date = new Date();
				if (res.content) {
					ele.attr("id", res.content.commentId);
                    date.setTime(res.content.modifyTime * 1000);
					if (res.owner) {
						ele.find("#ownerinfo").html(res.owner);
					}
					else {
						ele.find("#ownerinfo").html("Unknown owner");
					}
					ele.find("#modifytime").html(date.toLocaleString());
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

