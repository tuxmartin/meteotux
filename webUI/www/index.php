<?php require_once("config.php"); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="refresh" content="10" />
	<link href="hlavni.css" rel="stylesheet" type="text/css" media="all" />	
	<meta name="author" content="<?php echo(AUTOR); ?>" />
	<title>Počasí v Jičíně</title>   
	<meta name="description" content="" />
</head>
<body>
<div id="obal">
	<div id="hlavicka">
		<h1>Teplota v Jičíně</h1>
	</div>

		<div id="obsah">
		
		
		
			<?php /* ----------------------------------------------- */ ?>
			<div id="pravy">
			<?php 
			// aktualni udaje
			$dotaz=mysql_query(
				"SELECT teplota, vlhkost, casMereni FROM Hodnoty ORDER BY casMereni DESC LIMIT 1"
				) or die("CHYBA MySQL: " . mysql_error());		

				$zaznam=MySQL_Fetch_Array($dotaz);		

				/* ROSNY BOD */
				$LogEW = 0.66077 + 7.5*$zaznam["teplota"]/(237.3+$zaznam["teplota"]) + (log10($zaznam["vlhkost"])-2);
				$rosnyBod = ((0.66077 - $LogEW)*237.3) / ($LogEW - 8.16077) ;
				// http://list.hw.cz/pipermail/hw-list/2004-November/228770.html
				/* ROSNY BOD */
				
				?>
				<fieldset id="aktaulne">
					<legend>Aktuálně</legend>
					Teplota: <strong><?php echo $zaznam["teplota"];?> °C</strong><br />
					Vlhkost: <strong><?php echo $zaznam["vlhkost"];?> %</strong><br />
					Čas: <?php echo $zaznam["casMereni"];?><br />
					Rosný bod: <em><?php echo number_format($rosnyBod, 2)?> °C</em>

				
				</fieldset>

				
				
				
				
			<?php /* ----------------------------------------------- */ ?>
			<div id="celkovyPocetMereni">
			<?php 
			// celkovy pocet mereni
			$dotaz=mysql_query(
				"SELECT COUNT(teplota) AS pocet FROM Hodnoty"
				) or die("CHYBA MySQL: " . mysql_error());		

				$zaznam=MySQL_Fetch_Array($dotaz);		
				?>
				<p>
				Celkový počet měření: <strong><?php echo $zaznam["pocet"];?></strong>
				</p>
				
				<p>
					<h2>RSS</h2>
					Teplota a vlhkost: <a href="http://localhost/martin/teplota/www/rss.php">http://localhost/martin/teplota/www/rss.php</a> <br />
					Pouze teplota: <a href="http://localhost/martin/teplota/www/rss.php?p=t">http://localhost/martin/teplota/www/rss.php?p=t</a> <br />
					Pouze vlhkost: <a href="http://localhost/martin/teplota/www/rss.php?p=v">http://localhost/martin/teplota/www/rss.php?p=v</a> <br />
				</p>
				
			</div>	
			<?php /* ----------------------------------------------- */ ?>
			
			
			
			</div>	
			<?php /* ----------------------------------------------- */ ?>
		
		
		
			<?php /* ----------------------------------------------- */ ?>
			<div id="rekordy">
			<?php 
			// rekorkdy
			$dotazMAX=mysql_query(
				"SELECT  teplota, vlhkost, casMereni FROM Hodnoty WHERE teplota = (SELECT MAX(teplota) FROM Hodnoty) LIMIT 1"
				) or die("CHYBA MySQL: " . mysql_error());
			// FIXME chybny SQL dotaz: nekdy spatne hleda maximum (a mozna i minimum)
				

			$dotazMIN=mysql_query(
					"SELECT  teplota, vlhkost, casMereni FROM Hodnoty WHERE teplota = (SELECT MIN(teplota) FROM Hodnoty) LIMIT 1"
			) or die("CHYBA MySQL: " . mysql_error());			
			?>
			
			<table class="vysledky">
				<caption>Teplotní rekordy</caption>
				<tr>
					<th>Datum a čas měření</th>
					<th>Teplota</th>
					<th>Vlhkost</th>
				</tr>
				<?php
				while ($zaznam=MySQL_Fetch_Array($dotazMAX)) {
					echo "<tr class='nejteplejsi'>";
					echo "	<td>";
					echo		$zaznam["casMereni"];
					echo "	</td>";
					echo "	<td>";
					echo		$zaznam["teplota"] . " °C";
					echo "	</td>";
					echo "	<td>";
					echo		$zaznam["vlhkost"] . " %";
					echo "	</td>";
					echo "</tr>";
				}
				?>
				<?php
				while ($zaznam=MySQL_Fetch_Array($dotazMIN)) {
					echo "<tr class='nejstudenejsi'>";
					echo "	<td>";
					echo		$zaznam["casMereni"];
					echo "	</td>";
					echo "	<td>";
					echo		$zaznam["teplota"] . " °C";
					echo "	</td>";
					echo "	<td>";
					echo		$zaznam["vlhkost"] . " %";
					echo "	</td>";
					echo "</tr>";
				}
				?>
			</table>
			</div>
			<?php /* ----------------------------------------------- */ ?>
			
			
			<?php /* ----------------------------------------------- */ ?>
			<div id="poslednich10">
			<?php 			
			// poslednich 10 mereni
			$dotaz=mysql_query(
				"SELECT teplota, vlhkost, casMereni FROM Hodnoty ORDER BY casMereni DESC LIMIT 10"
				) or die("CHYBA MySQL: " . mysql_error());
			?>
			<table class="vysledky">
				<caption>Posledních 10 měření</caption>
				<tr>
					<th>Datum a čas měření</th>
					<th>Teplota</th>
					<th>Vlhkost</th>
				</tr>
				<?php
				while ($zaznam=MySQL_Fetch_Array($dotaz)) {
					echo "<tr>";
					echo "	<td>";
					echo		$zaznam["casMereni"];
					echo "	</td>";
					echo "	<td>";
					echo		$zaznam["teplota"] . " °C";
					echo "	</td>";
					echo "	<td>";
					echo		$zaznam["vlhkost"] . " %";
					echo "	</td>";
					echo "</tr>";
				}
				?>
			</table>
			</div>
			<?php /* ----------------------------------------------- */ ?>


		</div>

	</div>
</body>
</html>