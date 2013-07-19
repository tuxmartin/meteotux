	<!-- ### TEPLOMER ### -->
<style type="text/css">
/* CSS prevzato z https://github.com/MultiTricker/TMEP/blob/master/app/css/css.css */

/* aktualne */
.aktualne { width: 220px; margin: 0px 0px 3px 0px; border: 2px solid rgb(70,68,28); height: 74px; color: white; font-weight: bold; line-height: 26px; -webkit-border-radius: 0.8em; -moz-border-radius: 0.8em; border-radius: 0.8em; }
.aktualnejen { width: 220px; margin: 0px 0px 3px 0px; border: 2px solid rgb(70,68,28); height: 114px; color: white; font-weight: bold; line-height: 42px; -webkit-border-radius: 0.8em; -moz-border-radius: 0.8em; border-radius: 0.8em; }
.aktua { color: white; font-size: 24px; font-weight: bold; }
.aktualnemensi { font-size: 11px; margin: 1px 4px 0px 0px; float: left; width: 106px; border: 2px solid rgb(70,68,28); background: url("../images/prechod3.gif") repeat-x center center #2E2D0E; height: 44px; color: white; font-weight: bold; line-height: 21px; -webkit-border-radius: 0.8em; -moz-border-radius: 0.8em; border-radius: 0.8em; }
.aktuamens { color: white; font-size: 16px; font-weight: bold; }

/* teplota */
.teplejsi { background: url("../images/teplejsi.jpg") repeat-x center center #3C3A14; }
.studenejsi { background: url("../images/studenejsi.jpg") repeat-x center center #3C3A14; }
.stejne { background: url("../images/stejne.jpg") repeat-x center center #3C3A14; }

/* vlhkost */
.teplejsim { background: url("../images/teplejsi-min.jpg") repeat-x center center #2E2D0E; }
.studenejsim { background: url("../images/studenejsi-min.jpg") repeat-x center center #2E2D0E; }
.stejnem { background: url("../images/stejne-min.jpg") repeat-x center center #2E2D0E; }

#teplomer {color: rgb(60,58,23); font-family: Verdana, Arial, Times, serif; font-size: 13px; margin: 15px 0px; padding: 0px; text-align: center;}
</style>

<div id="teplomer">
<?php 
function getter($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

echo getter('http://pocasi.vancl.eu/scripts/ajax/teplota.php');
?>
</div>
	<!-- ### TEPLOMER ### -->
	