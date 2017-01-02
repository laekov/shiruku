function updatePostDiv() {
	$.post('/login/query/whoami', function(res) {
		var resDiv;
		if (res.userId) {
			resDiv = $("#samplecommentedit").clone();
		}
		else {
			resDiv = $("#samplecommentlogin").clone();
		}
		resDiv.attr("id", "commentedit");
		resDiv.removeClass('hidden');
		$("#commenteditdiv").html(resDiv);
		if (res.userId) {
			commentDivInit("#commentedit");
		}
	});
}

$(document).ready(function() {
	updateContent();
	showComment('/pen/' + getCurrentPenId(), "#commentdiv");
	updatePostDiv();
});

