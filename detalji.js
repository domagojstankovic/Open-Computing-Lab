function promijeniBoju() {
    this.style.backgroundColor = "rgb(199,233,239)";
}

function vratiBoju() {
    this.style.backgroundColor = null;
}

function initColorChangeEvents() {
    table = document.getElementById("data_table");
    rows = table.getElementsByTagName("tr");
	length = rows.length;
    for (var i = 1; i < length; i++) {
		element = rows[i];
        element.onmouseover = promijeniBoju;
        element.onmouseout = vratiBoju;
    }
}

function init() {
	initColorChangeEvents();
	initButtonActions();
}

window.onload = init;

var req;
function loadXMLDoc(url) {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else if (window.ActiveXObject) {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	if (req) {
		req.onreadystatechange = reqReturned;
		req.open("GET", url, true);
		req.send(null);
	}
}

function reqReturned() {
	if (req.readyState == 4) {
		if (req.status == 200) {
			//uspjeh
			var text = req.responseText;
			var element = document.getElementById("details");
			element.innerHTML = text;
		} else {
			//neuspjeh
			alert("Greška! Nije moguće prikazati detaljnije podatke!");
		}
	}
}

function initButtonActions() {
	table = document.getElementById("data_table");
    buttons = table.getElementsByTagName("button");
	length = buttons.length;
    for (var i = 0; i < length; i++) {
		element = buttons[i];
        element.onclick = sendReq;
    }
}

function sendReq() {
	var element = document.getElementById("details");
	element.style.display = "block";
	element.innerHTML = '<img class="center" src="wheel.gif" alt="Tražim..." />';
	var id = this.id;
	var url = "detalji.php?id=" + id;
	loadXMLDoc(url);
	
	var mapElem = document.getElementById("map");
	mapElem.style.display = "block";
	var naziv = this.getAttribute("x-naziv");
	var adresa = this.getAttribute("x-adresa");
	var lat = this.getAttribute("x-lat");
	var lon = this.getAttribute("x-lon");
	var web = this.getAttribute("x-web");
	setMap(naziv, adresa, lat, lon, web);
}

var map;
var marker;

function setMap(naziv, adresa, lat, lon, web) {
	if (!document.getElementById("map").innerHTML) {
		map = L.map("map");
	}
	map.setView([lat, lon], 13);
	L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a>contributors,<a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'}).addTo(map);
	marker = L.marker([lat, lon]).addTo(map);
	marker.bindPopup(naziv + "<br/>Adresa:<br/>" + adresa +  "<br/>Širina=" + lat + "<br/>Dužina=" + lon + '<br/><a href="' + web + '">Web</a>').openPopup();
}