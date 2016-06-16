<?php
## $Id$

require '.config.php';
require 'fx.inc.php';

ob_start('ob_tidyhandler');

#connect to database
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
mysql_select_db(SQL_DATA);

$prizes = array();
$sql = "select pdate, puser, pnote, pcountry from prize order by pdate desc limit 10";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_row($res)) {
  $prizes[] = array($row[0], $row[1], $row[2], $row[3]);
}
mysql_free_result($res);

httpheader();
echo htmlheader('travelrun -- prizes', usercss());

echo '<div class="prizenav">';
echo 'Go back to the <a href="index.php">start page</a>.';
echo '</div>';

echo '<div class="prizemain">';

echo 'Recent prizes:<br>';
echo '<table border="1">';
echo '<tr><th>date</th><th>claimed</th><th>note</th><th>country</th></tr>';
foreach ($prizes as $p) {
  echo '<tr>';
  echo '<td>', $p[0], '</td>';
  echo '<td align="center">';
        echo $p[1] ? $p[1] : '--';
        echo '</td>';
  echo '<td>', (trim($p[2]) != '') ? $p[2] : '&nbsp;', '</td>';
  echo '<td>', $p[3], '</td>';
  echo '</tr>';
}
echo '</table>';

echo '</div>';

echo htmlfooter();
?>
