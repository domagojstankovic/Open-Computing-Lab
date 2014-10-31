<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
<xsl:output method="xml" indent="yes" doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd" doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"/>
<xsl:template match="/">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<meta name="description" content="Sve informacije o praksama u Americi vezano za IT struku" />
<meta name="keywords" content="Internship,USA,SAD,America,Amerika,Praksa,IT,ICT" />
<meta name="author" content="Domagoj Stanković" />
<meta name="language" content="Croatian" />
<link rel="stylesheet" type="text/css" href="dizajn.css" />
<link rel="shortcut icon" href="af.ico.png" />
<title>Internship u Americi</title>
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
	<div class="menu_details">
	<ul>
		<li><a href="index.html">Početna</a></li>
		<li><a href="obrazac.html">Pretraživanje</a></li>
		<li><a href="podaci.xml"><b>Podaci</b></a></li>
		<li><a href="http://www.fer.unizg.hr/predmet/or">Otvoreno računarstvo</a></li>
		<li><a href="http://www.fer.unizg.hr/" onclick="this.target='_blank'">FER</a></li>
		<li><a href="mailto:domagoj.stankovic@fer.hr">Kontakt</a></li>
	</ul>
	</div>
	
	<div class="content">
	<table id="data_table">
		<tr><th>Tvrtka</th><th>Web stranica</th><th>Lokacija</th><th>Poslovi</th></tr>
		<xsl:for-each select="podaci/tvrtka">
		<tr>
			<td><xsl:value-of select="naziv"/></td>
			<td><a class="co_link" onclick="this.target='_blank'"><xsl:attribute name="href"><xsl:value-of select="web"/></xsl:attribute><xsl:value-of select="web"/></a></td>
			<td><xsl:value-of select="adresa/mjesto"/>, <xsl:value-of select="adresa/drzava"/></td>
			<td class="jobs_list"><ul>
				<xsl:for-each select="posao">
				<li><xsl:value-of select="@kategorija"/>, <xsl:value-of select="trajanje"/>&#160;<xsl:value-of select="trajanje/@kvant"/>
				<xsl:if test="placeno"><img class="img_placeno" src="moneybag25x25.png" alt="(placeno)"/></xsl:if></li>
				</xsl:for-each>
			</ul></td>
		</tr>
		</xsl:for-each>
	</table>
	</div>
	</div>
	
	<div class="footer">
	<p>Autor: Domagoj Stanković</p><br />
	<p>Fakultet elektrotehnike i računarstva, Zagreb</p>
	</div>
</div>
</body>
</html>
</xsl:template>

</xsl:stylesheet>