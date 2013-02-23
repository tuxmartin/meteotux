<?php
session_start();

define("SQL_HOST","localhost");
define("SQL_DBNAME","meteotux");
define("SQL_USERNAME","meteotux");
define("SQL_PASSWORD","meteotux");
define("SQL_CHARSET","utf8");

define("HESLO","sbTmdp12wS");  // !!! ZMENIT !!!

define("AUTOR", "tuxmartin");

mysql_connect(SQL_HOST, SQL_USERNAME, SQL_PASSWORD) or die("Nelze se pripojit k MySQL: " . mysql_error());
mysql_select_db(SQL_DBNAME) or die("Nelze vybrat databazi: ". mysql_error());   
mysql_set_charset(SQL_CHARSET);

header('X-Powered-By: meteotux');


//	zakazani cache
	header('Last-Modified: Sat, 01 Jan 2000 00:00:00 GMT');
	header('Expires: Sat, 01 Jan 2000 00:00:00 GMT');
	header('Cache-control: no-cache,no-store,max-age=0,must-revalidate,private');
	header('Pragma: no-cache');
//	zakazani cache



//session_register("promenna");
//$_SESSION["promenna"]="hodnota";

?>