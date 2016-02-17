/*
 * jquery-cookie plugin by laekov
 */
$.cookie = function(field, value) {
	if (value == undefined) {
		var cookieArr = document.cookie.split(';');
		var matchValue = field + '=';
		for (var i in cookieArr) {
			if (cookieArr[i].search(matchValue) > -1) {
				return cookieArr[i].substring(matchValue.length + 1, cookieArr[i].length);
			}
		}
		return false;
	}
	else {
		document.cookie = field + '=' + value + ';' + 'path=/';
	}
}
