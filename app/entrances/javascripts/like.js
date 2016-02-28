function getLikeEleId(postId) {
	return "#likediv_" + postId.replace(/\//g, '_slash_');
}

function likeDivShowError(postId, error) {
	var ele = $(getLikeEleId(postId));
	if (ele.length) {
		if (typeof(error) == 'string') {
			ele.find("#perror").html(error);
		}
		else {
			ele.find("#perror").html("");
		}
	}
}

function updateLikeDiv(postId) {
	var ele = $(getLikeEleId(postId));
	if (ele.length) {
		if (ele.find("#perror").html().length) {
			ele.find("#perror").show();
			if (ele.find("#perror").html() == 'login') {
				var loginEle = $("#sampleloginnotify").clone();
				loginEle.attr("id", "errormsg");
				loginEle.show();
				ele.find("#perror").html(loginEle);
			}
		}
		else {
			ele.find("#perror").hide();
			$.post("/pen/like/query" + postId, {}, function(res) {
				var ele = $(getLikeEleId(postId));
				if (ele.length) {
					if (res.error) {
						ele.find("#valuediv").hide();
						ele.find("#perror").html(res.error);
						ele.find("#perror").show();
					}
					else {
						ele.find("#valuelike").html(String(res.like));
						ele.find("#valuedislike").html(String(res.dislike));
						ele.find("#valuediv").show();
					}
				}
			});
		}
	}
}

function initLikeDiv(postId) {
	var ele = $(getLikeEleId(postId));
	ele.find("#actlike").click(function() {
		$.post("/pen/like/for" + postId, {}, function(res) {
			likeDivShowError(postId, res.error);
			updateLikeDiv(postId);
		});
	});
	ele.find("#actdislike").click(function() {
		$.post("/pen/like/against" + postId, {}, function(res) {
			likeDivShowError(postId, res.error);
			updateLikeDiv(postId);
		});
	});
	updateLikeDiv(postId);
}

function createLikeDiv(postId) {
	var ele = $("#samplelikediv").clone();
	ele.attr("id", getLikeEleId(postId).substr(1));
	ele.show();
	return ele;
}

