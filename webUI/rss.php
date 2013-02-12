<?php
header('Expires: ' . gmdate('D, d M Y H:i:s') . '  GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . '  GMT');
header('Content-Type: text/xml; charset=utf-8');
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Pragma: no-cache");
?>
<rss version="0.91">
	<channel>
		<title>Teplota v Jicine</title>
		<link>http://example.net/jicin-teplota/</link>
		<description>Teplota v Jicine aktualizovana kazdych 10 minut. Je ziskavana z teplomeru na adrese http://teplomer.jicin.cz/</description>
		<language>cs</language>
		<image>
			<url>http://teplomer.jicin.cz/images/favicon.ico</url>
			<title>Teplota v Jicine</title>
			<link/>
		</image>
		<item>
			<title><?php echo( file_get_contents('./aktualni-teplota-v-jicine.txt') . " °C" ); ?></title>
			<link>http://teplomer.jicin.cz/</link>
			<description><?php echo( file_get_contents('./aktualni-teplota-v-jicine.txt') . " °C" ); ?></description>
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