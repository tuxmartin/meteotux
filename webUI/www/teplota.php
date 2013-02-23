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
	
	mysql_query("INSERT INTO Hodnoty (teplota, vlhkost, casMereni)
			VALUES (
			'".mysql_real_escape_string($teplota)."',
			'".mysql_real_escape_string($vlhkost)."',
			'".mysql_real_escape_string($datum)."')
			") or die("CHYBA MySQL: " . mysql_error());

}

?>

