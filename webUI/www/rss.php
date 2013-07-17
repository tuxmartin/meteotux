<?php require_once("config.php"); ?>
<?php
header('Expires: ' . gmdate('D, d M Y H:i:s') . '  GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . '  GMT');
header('Content-Type: application/rss+xml; charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");

$dotaz=mysql_query(
		"SELECT teplota, vlhkost FROM tme ORDER BY id DESC LIMIT 1"
		) or die("CHYBA MySQL: " . mysql_error());

$zaznam=MySQL_Fetch_Array($dotaz);

if ($_GET["p"] == "t") {
	$vypsat = $zaznam["teplota"] . "°C";
}
elseif ($_GET["p"] == "v") {
	$vypsat = $zaznam["vlhkost"] . "%";
}
else {
	$vypsat = $zaznam["teplota"] . "°C " . "\n" . $zaznam["vlhkost"] . "%" . "\n" . date("H:i");
}
	
?>
<rss version="2.0">
  <channel>
    <title></title>
    <link></link>
    <description></description>
    <pubDate><?php echo gmdate("D, d M Y H:i:s")." GMT";  ?></pubDate>
    <item>
       <title><?php echo $vypsat?></title>
    </item>
  </channel>
</rss>

<?php
/*
specifikace povinnych RSS elementu: http://feed2.w3.org/docs/rss2.html

Android widget:
https://play.google.com/store/apps/details?id=de.j4velin.rssWidget
https://dl.dropbox.com/u/6943408/teplomerRSS.png
*/
?>
