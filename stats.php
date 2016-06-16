<?php
## $Id$

require '.config.php';
require 'fx.inc.php';

ob_start('ob_tidyhandler');

// open the database connection
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
mysql_select_db(SQL_DATA);

$cvk = array();
$upk = $viewk = 0;
$sql = "select vkey, value from counts";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_row($res)) {
  if ($row[0] == 'update2') {
    $upk = $row[1];
  } else {
    $viewk += $row[1];
    $cvk[$row[0]] = $row[1];
  }
}
mysql_free_result($res);

mysql_close($conn);

$m=number_format($cvk["m"]);
$i=number_format($cvk["i"]);
$c=number_format($cvk["c"]);
$h=number_format($cvk["h"]);
$u=number_format($cvk["u"]);
$a=number_format($cvk["a"]);
$s=number_format($cvk["s"]);
$j=number_format($cvk["j"]);
$x=number_format($cvk["x"]);
$e=number_format($cvk["e"]);
$z=number_format($cvk["z"]);

$total = $cvk["m"] + $cvk["i"] + $cvk["c"] + $cvk["h"] + $cvk["u"] + $cvk["a"] + $cvk["s"] + $cvk["j"] + $cvk["x"] + $cvk["e"] + $cvk["z"];
$newtotal = number_format($total);

httpheader();
echo htmlheader('TravelRun: Stats', usercss());

echo '<br><br><br><br>';
echo '<div class="stitched"><center>WELCOME TO TRAVEL RUN STATISTICS PAGE!</center></div>';
echo '<hr>';
echo '<div class="stitched">';
echo '<table width="100%" height="25"><tr><th></th><th align="left">Hits</th></tr>';
echo '<tr><td>Mexico:</td><td>' . $m . '</td></tr>';
echo '<tr><td>Cayman Islands:</td><td>' . $i . '</td></tr>';
echo '<tr><td>Canada:</td><td>' . $c . '</td></tr>';
echo '<tr><td>Hawaii:</td><td>' . $h . '</td></tr>';
echo '<tr><td>United Kingdom:</td><td>' . $u . '</td></tr>';
echo '<tr><td>Argentina:</td><td>' . $a . '</td></tr>';
echo '<tr><td>Switzerland:</td><td>' . $s . '</td></tr>';
echo '<tr><td>Japan:</td><td>' . $j . '</td></tr>';
echo '<tr><td>China:</td><td>' . $x . '</td></tr>';
echo '<tr><td>UAE:</td><td>' . $e . '</td></tr>';
echo '<tr><td>South Africa:</td><td>' . $z . '</td></tr>';
echo '</table><center>TRAVELRUN HAS HAD A TOTAL OF <b>' . $newtotal .'</b> HITS!</center></div>';
echo htmlfooter();
?>