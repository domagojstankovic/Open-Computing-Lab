<?php
error_reporting( E_ALL );

class Res {
	public $query;
	public $jobs;
}

function generate() {
	$filter = "/podaci/tvrtka";
	$filters = array();
	
	$res = new Res();
	
	if (!empty($_REQUEST['naziv'])) {
		$temp = "contains(" . translate("naziv") . ", '" . mb_strtolower($_REQUEST['naziv'], "UTF-8") . "')";
		array_push($filters, $temp);
	}
	
	if (!empty($_REQUEST['web'])) {
		$temp = "contains(" . translate("web") . ", '" . mb_strtolower($_REQUEST['web'], "UTF-8") . "')";
		array_push($filters, $temp);
	}
	
	if (!empty($_REQUEST['drzava'])) {
		$drzava = $_REQUEST['drzava'];
		$ta = array();
		foreach($drzava as $d) {
			$temp = "contains(" . translate("substring(drzava,1,2)") . ", '" . mb_strtolower($d, "UTF-8") . "')";
			array_push($ta, $temp);
		}
		$temp = "adresa[" . implode(" or ", $ta) . "]";
		array_push($filters, $temp);
	}
	
	if (!empty($_REQUEST['mjesto'])) {
		$temp = "contains(" . translate("mjesto") . ", '" . mb_strtolower($_REQUEST['mjesto'], "UTF-8") . "')";
		$temp = "adresa[" . $temp . "]";
		array_push($filters, $temp);
	}
	
	if (!empty($_REQUEST['pbr'])) {
		$temp = "contains(" . translate("@pbr") . ", '" . mb_strtolower($_REQUEST['pbr'], "UTF-8") . "')";
		$temp = "adresa[mjesto[" . $temp . "]]";
		array_push($filters, $temp);
	}
	
	if (!empty($_REQUEST['ulica'])) {
		$temp = "contains(" . translate("ulica") . ", '" . mb_strtolower($_REQUEST['ulica'], "UTF-8") . "')";
		$temp = "adresa[" . $temp . "]";
		array_push($filters, $temp);
	}
	
	if (!empty($_REQUEST['kbr'])) {
		$temp = "contains(" . translate("kbr") . ", '" . mb_strtolower($_REQUEST['kbr'], "UTF-8") . "')";
		$temp = "adresa[" . $temp . "]";
		array_push($filters, $temp);
	}
	
	$pa = array();
	if (!empty($_REQUEST['kategorija'])) {
		$kategorija = $_REQUEST['kategorija'];
		foreach($kategorija as &$kat) {
			$kat = "@kategorija='" . $kat . "'";
		}
		$poslovi = implode(" or ", $kategorija);
		$poslovi = "(" . $poslovi . ")";
		array_push($pa, $poslovi);
	}
	
	if (!empty($_REQUEST['placeno'])) {
		if (strcmp($_REQUEST['placeno'], 'da') == 0) {
			$temp = "placeno";
			array_push($pa, $temp);
		} else if (strcmp($_REQUEST['placeno'], 'ne') == 0) {
			$temp = "not(placeno)";
			array_push($pa, $temp);
		}
	}
	
	if (!empty($_REQUEST['trajanje'])) {
		$trajanje = $_REQUEST['trajanje'];
		$kvant = $_REQUEST['kvant'];
		$temp = "(trajanje='" . $trajanje . "' and trajanje[@kvant='" . $kvant . "'])";
		array_push($pa, $temp);
	}
	
	if (!empty($_REQUEST['titula'])) {
		$titula = $_REQUEST['titula'];
		foreach($titula as &$tit) {
			$tit = "@titula='" . $tit . "'";
		}
		$poslovi = implode(" or ", $titula);
		$poslovi = "(obrazovanje[" . $poslovi . "])";
		array_push($pa, $poslovi);
	}
	
	if (!empty($pa)) {
		$temp = implode(" and ", $pa);
		$res->jobs = "posao[" . $temp . "]";
		array_push($filters, $res->jobs);
	}
	//var_dump($filters);
	
	if (count($filters) > 0) {
		$tmp = implode(" and ", $filters);
		$filter = $filter . "[" . $tmp . "]";
	}
	$res->query = $filter;
	return $res;
}

function translate($str) {
	$temp = "translate(" . $str . ", 'QWERTZUIOPŠĐASDFGHJKLČĆŽYXCVBNM', 'qwertzuiopšđasdfghjklčćžyxcvbnm')";
	return $temp;
}

function generate_job($id, $jobs) {
	$query = "/podaci/tvrtka[@id='" . $id . "']/" . $jobs;
	return $query;
}

?>

<?php

$dom = new DOMDocument();
$dom->load("podaci.xml");
$xp = new DOMXPath($dom);

$res = generate();
$q = $res->query;
$result = $xp->query($q);

$f2 = $res->jobs;

$graph_prefix = "https://graph.facebook.com/";
$graph_postfix = "?fields=picture,location,website";

$nominatim_prefix = "http://open.mapquestapi.com/nominatim/v1/search";

foreach($result as $node) {
	echo "<tr><td>";
	$name = $node->getElementsByTagName('naziv')->item(0)->nodeValue;
	$fb_id = $node->getElementsByTagName('fb_id')->item(0)->nodeValue;
	$link = $graph_prefix . $fb_id . $graph_postfix;
	$page = file_get_contents($link);
	$json = json_decode($page, true);
	$pic_url = $json['picture']['data']['url'];
	if (!array_key_exists('error', $json)) {
	$street = NULL;
	$city = NULL;
	$state = NULL;
	$country = NULL;
	$location = array();
	if (array_key_exists('location', $json)) {
		$location_arr = $json['location'];
		if (array_key_exists('street', $location_arr)) {
			$street = $json['location']['street'];
			array_push($location, $street);
		}
		if (array_key_exists('city', $location_arr)) {
			$city = $json['location']['city'];
			array_push($location, $city);
		}
		if (array_key_exists('state', $location_arr)) {
			$state = $json['location']['state'];
			array_push($location, $state);
		}
		if (array_key_exists('country', $location_arr)) {
			$country = $json['location']['country'];
			array_push($location, $country);
		}
	}
	echo "<img title=\"$name\" src=\"$pic_url\" alt=\"company_pic\" />";
	} else {
		$code = $json['error']['code'];
		echo "Greška pri dohvaćanju podataka sa Facebook-a. code=$code";
	}
	$web = $node->getElementsByTagName('web')->item(0)->nodeValue;
	echo "</td>\n<td><a class=\"co_link\" href=\"" . $web . "\" onclick=\"this.target='_blank'\">";
	$website = $json['website'];
	print($web);
	echo "</a>";
	echo "</td>\n<td>";
	
	if (!array_key_exists('error', $json)) {
	$l = implode(', ', $location);
	$l_url = rawurlencode($l);
	// rawurlencode('foo @+%/')  -->  foo%20%40%2B%25%2F   [razmak kao %20]
	
	$nominatim_postfix = "?q=" . $l_url . "&format=xml";
	$nominatim_url = $nominatim_prefix . $nominatim_postfix;
	$nominatim = file_get_contents($nominatim_url);
	
	$xml = simplexml_load_string($nominatim);
	
	if (property_exists($xml, 'place')) {
	
	$lat = $xml->place->attributes()->lat;
	$lon = $xml->place->attributes()->lon;
	//$address = urlencode($l);    // trebalo je za google maps
	// urlencode(" ")  -->  "+"  [razmak kao plus]
	
	$l_br = implode('<br/>', $location);
	$geo = "<span title=\"Geografska širina\" id=\"lat\">$lat</span>, <span title=\"Geografska dužina\" id=\"lon\">$lon</span>";
	echo "$l_br<br/><br/>$geo";
	echo "<br/><br/>";
	} else {
		echo "Error";
	}
	} else {
		$code = $json['error']['code'];
		echo "Greška pri dohvaćanju podataka sa Facebook-a. code=$code";
	}
	
	echo "</td>\n<td class=\"jobs_list\"><ul>";
	$r = $node->getElementsByTagName('posao');
	$id = $node->getAttribute('id');
	if (!empty($f2)) {
		$q2 = generate_job($id, $f2);
		$r = $xp->query($q2);
	}
	
	foreach ($r as $item) {
		echo "<li>";
		$kategorija = $item->getAttribute('kategorija');
		print($kategorija);
		$trajanje = $item->getElementsByTagName('trajanje');
		$num = $trajanje->item(0)->nodeValue;
		$kvant = $trajanje->item(0)->getAttribute('kvant');
		echo ", " . $num . " " . $kvant;
		if ($item->getElementsByTagName('placeno')->length > 0) {
			echo "<img class=\"img_placeno\" src=\"moneybag25x25.png\" alt=\"(placeno)\"/>";
		}
		echo "</li>";
	}
	echo "</ul></td>\n";
	echo "<td><button id=\"$id\" x-naziv=\"$name\" x-adresa=\"$l_br\" x-lat=\"$lat\" x-lon=\"$lon\" x-web=\"$web\" type=\"button\">Detalji</button></td>";
	echo "</tr>\n";
}
?>