//cookies
function getCookie(cname, val) {
	var name = cname + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var ca = decodedCookie.split(';');
	for(var i = 0; i < ca.length; i++) {
		var c = ca[i];
		while (c.charAt(0) == ' ') {
		c = c.substring(1);
		}
		if (c.indexOf(name) == 0) {
			var rtn = c.split(',');
			if (rtn[0].charAt(3) == '=') {
				rtn[0] = rtn[0].substring(4);
			}
		return rtn[val];
		}
	}
	return "";
}

function setCookie() {
	var u_log = document.getElementById("log").value;
	var u_email = document.getElementById("email").value;
	var d = new Date();
	d.setTime(d.getTime() + (1*60*60*1000));
	var expires = d.toUTCString(); 
	document.cookie = "log=" + u_log + "," + u_email + ";expires=" + expires + ";path=/";
}

function unsetCookie() {
	document.cookie = "log=; expires=Thu, 01 Jan 1970 00:00:00 GMT; path=/";
}

function callFromCookie() {
	if(document.cookie) {
		console.log(document.cookie);
		document.getElementById("log").value = getCookie("log", 0);
		document.getElementById("email").value = getCookie("log", 1);
	}
}