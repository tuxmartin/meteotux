<?php require_once("config.php"); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link href="hlavni.css" rel="stylesheet" type="text/css" media="all" />
<meta name="author" content="<?php echo(AUTOR); ?>" />
<title>RSS pro mobily</title>
<meta name="description" content="" />
</head>
<body>
	<div id="obal">
		<div id="hlavicka">
			<h1>RSS pro mobily</h1>
		</div>

		<div id="obsah">
			<p>
				Teplota a vlhkost: <a
					href="http://localhost/martin/teplota/www/rss.php">http://localhost/martin/teplota/www/rss.php</a>
				<br /> Pouze teplota: <a
					href="http://localhost/martin/teplota/www/rss.php?p=t">http://localhost/martin/teplota/www/rss.php?p=t</a>
				<br /> Pouze vlhkost: <a
					href="http://localhost/martin/teplota/www/rss.php?p=v">http://localhost/martin/teplota/www/rss.php?p=v</a>
				<br />
			</p>

			<h2>Návod na nastavení Android mobilu:</h2>
			<p>			
			<ol>
				<li>Nainstalujeme aplikaci <em><a
						href="https://play.google.com/store/apps/details?id=de.j4velin.rssWidget">Simple
							RSS Widget</a> </em>
				</li>
				<li>Postupujeme podle videa</li>
			</ol>
			<img src="android-ukazka.png" width="390" height="397" alt="Ukázka widgetu na Androidu" />
			</p>

			<p>
				<strong>RSS výstup je použitelný i na mobilech s jiným opearčním
					systémem a počítačích, pouze je potřeba použít RSS čtečku pro daný
					systém.</strong>
			</p>
		</div>

	</div>
</body>
</html>
