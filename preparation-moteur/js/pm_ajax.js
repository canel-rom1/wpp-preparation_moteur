function ajaxGet(url, callback) {
	var req = new XMLHttpRequest();
	req.open("GET", url);

	req.addEventListener("load", function () {
		if (req.status >= 200 && req.status < 400)  {
			callback(req.responseText);
		} else {
			console.error(req.status + " " + req.statusText + " " + url);
		}
	});

	req.addEventListener("error", function (){
		console.error("Erreur réseau avec l'URL " + url);
	});

	req.send(null);
}

function ajaxTest()
{
	/*
	var req = new XMLHttpRequest();
	
	req.open("GET", pm_wp_path.plugin+"sql/ajax-test.php");
	req.send(null);
	document.getElementById("pm_ui_test").innerHTML = req.responseText;
*/
		ajaxGet(pm_wp_path.plugin+"sql/ajax-test.php", retTest); 
}

function retTest(text)
{
	sortie = JSON.parse(text);
	console.log("rt"+sortie);
}


// vim: ft=javascript tw=120 ts=2 sw=2 sts=2 
