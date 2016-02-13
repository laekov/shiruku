function getFormData(list) {
	var ret = {};
	for (i in list) {
		ret[list[i]] = $("#" + list[i]).val();
	}
	return ret;
}

function submitData(data, callback) {
	$.post("/entrances/redirectpost.php", data, callback);
}

