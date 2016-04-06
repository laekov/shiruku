function updateNickname(commentId, owner) {
	$.post('/login/query/' + owner + '/nickname', {}, function(res) {
		$("#comment_" + commentId).find("#ownerinfo").find("#nickname").html(res.data);
	});
}

function updateAvatar(commentId, owner) {
	$.post("/login/query/" + owner + "/avatarurl", {}, function(res) {
		$("#comment_" + commentId).find("#ownerinfo").find("#avatar").attr('src', res.url);
	});
}

function showComment(queryStr, targetId) {
	$.post("/comment/query/" + queryStr, {}, function(res) {
		var listDiv = $(targetId);
		var confList = res.list;
		confList.sort(function(a, b) {
            return b.modifyTime - a.modifyTime;
		});
		listDiv.html("");
		for (var i in confList) {
			var ele = $("#samplecomment").clone();
			ele.attr("id", "comment_" + confList[i].commentId);
			if (confList[i].owner) {
				ele.find("#ownerinfo").find("#nickname").html(confList[i].owner);
				updateNickname(confList[i].commentId, confList[i].owner);
				updateAvatar(confList[i].commentId, confList[i].owner);
			}
			else if (confList[i].ownerNick) {
				ele.find("#ownerinfo").find("#nickname").html(confList[i].ownerNick);
			}
			else {
				ele.find("#ownerinfo").html("Unknown owner");
			}
			ele.find("#viewref").attr("href", "/view/" + confList[i].penId);
			if (typeof(createLikeDiv) == 'function') {
				var postId = "/" + confList[i].penId + "/" + confList[i].commentId;
				ele.find("#likediv").html(createLikeDiv(postId));
			}
			var date = new Date();
			date.setTime(confList[i].modifyTime * 1000);
			ele.find("#modifytime").html(date.toLocaleString());
			ele.show();
			listDiv.append(ele);
			if (typeof(initLikeDiv) == 'function') {
				var postId = "/" + confList[i].penId + "/" + confList[i].commentId;
				initLikeDiv(postId);
			}
			$.post("/comment/query/content/" + confList[i].penId + "/" + confList[i].commentId, {}, function(res) {
				if (res.content) {
					var text = renderContent(res.content, {catalog: "comment"});
					listDiv.find("#comment_" + res.commentId).find("#content").html(text);
					updateJax("comment_" + res.commentId);
				}
			});
		}
	});
}

function commentDivInit(eleId) {
	var divEle = $(eleId);
	divEle.find("#content").width($("#pagecontentdiv").width());
	divEle.find("#commentpost").click(function() {
		divEle.find("#perror").hide();
		divEle.find("#psuccess").hide();
		divEle.find("#ppending").show();
		var data = {
			requestURI: "/comment/post",
			penId: getCurrentPenId(),
			content: $(this).parent().find("#content").val()
		};
		submitData(data, function(res) {
			divEle.find("#ppending").hide();
			if (res.error) {
				divEle.find("#perror").html(res.error);
				divEle.find("#perror").show();
			}
			else {
				divEle.find("#psuccess").show();
				showComment('/pen/' + getCurrentPenId(), "#commentdiv");
			}
		});
	});
}

