<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="description" content="Sve informacije o praksama u Americi vezano za IT struku" />
<meta name="keywords" content="Internship,USA,SAD,America,Amerika,Praksa,IT,ICT" />
<meta name="author" content="Domagoj Stanković" />
<meta name="language" content="Croatian" />
<link rel="stylesheet" type="text/css" href="dizajn.css" />
<link rel="shortcut icon" href="af.ico.png" />
<title>Internship u Americi</title>
<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet-0.7.2/leaflet.js"></script>
<script type="text/javascript" src="detalji.js"></script>
</head>
<body>
<div class="container">
	<div class="header">
	<a href="index.html">
	<img src="Eagle-round.png" alt="American Eagle" />
	</a>
	<h1>Internship u Americi</h1>
	</div>
	
	<div class="wrapper">
	<div id="menu_details" class="menu_details">
	<div id="menu" class="menu">
	<ul>
		<li><a href="index.html">Početna</a></li>
		<li><a href="obrazac.html">Pretraživanje</a></li>
		<li><a href="podaci.xml"><b>Podaci</b></a></li>
		<li><a href="http://www.fer.unizg.hr/predmet/or">Otvoreno računarstvo</a></li>
		<li><a href="http://www.fer.unizg.hr/" onclick="this.target='_blank'">FER</a></li>
		<li><a href="mailto:domagoj.stankovic@fer.hr">Kontakt</a></li>
	</ul>
	<br/>
	</div>
	<div id="details">
	</div>
	</div>
	
	<div class="content" id="content">
	<table id="data_table">
		<tr><th>Tvrtka</th><th>Web stranica</th><th>Lokacija</th><th>Poslovi</th><th>Akcija</th></tr>
		<h2>Rezultati pretrage</h2>
		<?php include_once "funkcije.php"; ?>
	</table>
	<div id="map"></div>
	</div>
	</div>
	
	<div class="footer">
	<p>Autor: Domagoj Stanković</p><br />
	<p>Fakultet elektrotehnike i računarstva, Zagreb</p>
	</div>
</div>
</body>
</html>