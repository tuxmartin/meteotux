<?php require_once("config.php"); ?>

<?php
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="cs" lang="cs">
<head>
	<meta http-equiv="content-language" content="cs" />
	<meta name="language" content="cs" />
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<link href="hlavni.css" rel="stylesheet" type="text/css" media="all" />	
	<meta name="author" content="<?php echo(AUTOR); ?>" />
	<title><?php echo(HTML_TITLE); ?></title>   
	<meta name="description" content="" />
</head>
<body>
<div id="obal">
	<div id="hlavicka">
		<h1>Teplota v Jičíně</h1>
	</div>

		<div id="obsah">
		
		

			

			<?php /* ----------------------------------------------- */ ?>
			<?php 
			$dotazMAX=mysql_query(
				"SELECT MAX(teplota) AS teplota, vlhkost, casMereni FROM Hodnoty"
				) or die("CHYBA MySQL: " . mysql_error());

			$dotazMIN=mysql_query(
					"SELECT MIN(teplota) AS teplota, vlhkost, casMereni FROM Hodnoty"
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
			<?php /* ----------------------------------------------- */ ?>
			
			
			<?php /* ----------------------------------------------- */ ?>
			<?php 
			//	mysql_query("INSERT INTO Hodnoty (teplota, vlhkost, casMereni)			VALUES (

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
			<?php /* ----------------------------------------------- */ ?>


		</div>

	</div>
</body>
</html>