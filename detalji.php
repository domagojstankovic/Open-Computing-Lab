<?php
error_reporting(E_ALL);

function generate() {
	$filter = "/podaci/tvrtka";
	
	if (!empty($_GET['id'])) {
		$temp = "[@id='". $_GET['id'] ."']";
		$filter = $filter . $temp;
	}
	
	return $filter;
}

sleep(2);

$dom = new DOMDocument();
$dom->load("podaci.xml");
$xp = new DOMXPath($dom);

$q = generate();
//print($q);
$result = $xp->query($q);

foreach($result as $node) {
	try {
		$name = $node->getElementsByTagName('naziv')->item(0)->nodeValue;
		echo "<b>Naziv:</b><br/>";
		echo $name;
		echo "<br/><br/>";
	} catch(Exception $e) {
	}
	
	try {
		$web = $node->getElementsByTagName('web')->item(0)->nodeValue;
		echo "<b>Web:</b><br/>";
		echo '<a href="' . $web . '">' . $web . "</a>";
		echo "<br/><br/>";
	} catch(Exception $e) {
	}
	
	echo "<b>Adresa:</b><br/>";
	
	try {
		$mjesto = $node->getElementsByTagName('mjesto')->item(0)->nodeValue;
		echo $mjesto;
		echo "<br/>";
	} catch(Exception $e) {
	}
	
	try {
		$drzava = $node->getElementsByTagName('drzava')->item(0)->nodeValue;
		echo $drzava;
		echo "<br/>";
	} catch(Exception $e) {
	}
	
	$ulica = $node->getElementsByTagName('ulica')->item(0);
	if (!empty($ulica)) {
		echo $ulica->nodeValue;
		echo "<br/>";
	}
	
	$kbr = $node->getElementsByTagName('kbr')->item(0);
	if (!empty($kbr)) {
		echo $kbr->nodeValue;
		echo "<br/>";
	}
	
	try {
		$opis = $node->getElementsByTagName('opis')->item(0)->nodeValue;
		echo "<br/><b>Opis:</b><br/>";
		echo $opis;
		echo "<br/>";
	} catch(Exception $e) {
	}
}
?>