<?php require_once("config.php"); ?>

<?php

// URL: http://localhost/martin/teplota/teplota.php?h=sbTmdp12wS&t=20.90&v=50.50&d=23.02.2013_00.00.24


if ($_GET["h"] == HESLO) {
	echo "HESLO_OK<br />";

	$teplota = $_GET["t"];
	$vlhkost = $_GET["v"];
	$datum   = $_GET["d"];
	echo "Teplota = ". $teplota . "<br />";
	echo "Vlhkost = ". $vlhkost . "<br />";
	echo "Datum = "  . $datum   . "<br />";

	/*
	echo "<pre>";
	print_r ( date_parse($datum) );
	echo "</pre>";
	*/
	

}

/* --------- TMEP --------- */

// http://localhost/martin/TMEP-6.1/app/index.php?tempV=+21.2&humV=50.1
$tempV = $teplota;
$humV = $vlhkost;

$userAgent = '"User-Agent", "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.70 Safari/537.17"';
$url = "http://localhost/martin/TMEP-6.1/app/index.php?tempV=$tempV&humV=$humV";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);

// add useragent
curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
//curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");

// make it a http HEAD request
curl_setopt($ch, CURLOPT_NOBODY, false);

//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

//Tell curl to write the response to a variable
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result= curl_exec ($ch);
curl_close ($ch);

/* --------- TMEP --------- */
?>

