<?php require_once("config.php"); ?>
<?php
header('Expires: ' . gmdate('D, d M Y H:i:s') . '  GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . '  GMT');
header('Content-Type: text/xml; charset=utf-8');
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
<rss version="0.91">
	<channel>
		<title>Počasí v Jičíně</title>
		<link>http://localhost/martin/teplota/www/</link>
		<description>Počasí v Jičíně</description>
		<language>cs</language>
		<image>
			<url></url>
			<title>Počasí v Jičíně</title>
			<link/>
		</image>
		<item><?php echo $vypsat?>
			<title><?php echo $vypsat?></title>
			<link>http://teplomer.jicin.cz/</link>
			<description>http://localhost/martin/teplota/www/</description>
			<pubDate><?php echo gmdate("D, d M Y H:i:s")." GMT";  ?></pubDate>
		</item>
	</channel>
</rss>

<?php
/*
Na Androidu:
https://play.google.com/store/apps/details?id=de.j4velin.rssWidget
https://dl.dropbox.com/u/6943408/teplomerRSS.png
*/
?>