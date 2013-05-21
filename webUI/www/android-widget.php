<?php require_once("config.php"); ?>
<?php
header('Expires: ' . gmdate('D, d M Y H:i:s') . '  GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . '  GMT');
header('Content-Type: text/plain; charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");

$dotaz=mysql_query(
	"SELECT teplota, vlhkost FROM Hodnoty ORDER BY casMereni DESC LIMIT 1"
	) or die("CHYBA MySQL: " . mysql_error());

$zaznam=MySQL_Fetch_Array($dotaz);

if ($_GET["p"] == "t") {
	$vypsat = $zaznam["teplota"] . "°C";
}
elseif ($_GET["p"] == "v") {
	$vypsat = $zaznam["vlhkost"] . "%";
}
else {
	$vypsat = $zaznam["teplota"] . "°C " . $zaznam["vlhkost"] . "%";	
}
	
?>
<?php echo $vypsat?>