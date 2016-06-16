<?php
## $Id: $

require '.config.php';
require 'fx.inc.php';

ob_start('ob_tidyhandler');

session_start();
$_SESSION['timecheck'] = date('YmdHis', time() + 1);

$it = 0;
if (isset($_GET['it'])) $it = 1 * $_GET['it'];
if ($it < 1) $it = 1;
if ($it > 695) $it = 1;
$cc = 'm';
if (isset($_GET['c'])) $cc = substr(trim($_GET['c']), 0, 1);
if (!in_array($cc, array('m', 'i', 'c', 'h', 'u', 'a', 's', 'j', 'x', 'e', 'z'))) $cc = 'm';
$scale = 1;
if (isset($_GET['scale'])) $scale = 1 * $_GET['scale'];
if ($scale < 1) $scale = 1;
if ($scale > 1000) $scale = 1000;

#connect to database
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
mysql_select_db(SQL_DATA);

httpheader();
echo htmlheader('travelrun', usercss());

echo '<div class="mannav">';
echo 'Return to the <a href="index.php">start page</a>.';
echo '</div>';

echo '<div>';
echo '<form>';

echo '<label>Country: <select name=c>';
$sql = "select letter, countryname from country order by countryid";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_row($res)) {
  echo '<option value="', $row[0], '"';
  if ($row[0] == $cc) echo ' selected';
  echo '>', $row[1];
}
mysql_free_result($res);
echo '</select></label>';

echo '&nbsp;&nbsp;';

echo '<label>Item: <select name=it>';
$sql = "select itemid, itemname from item order by itemname";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_row($res)) {
  echo '<option value="', $row[0], '"';
  if ($row[0] == $it) echo ' selected';
  echo '>', $row[1];
}
mysql_free_result($res);
echo '</select></label>';

echo '&nbsp;&nbsp;';

echo '<label>Scale: <input type="text" name="scale" value="', $scale, '"></label>';

echo '<br>';
echo '<input type="submit" value="Show Graph">';
echo '<br><br>';

echo '</form>';
echo '</div>';

echo '<div class="flowerchart">';
echo '<i><span class="info">If the graph does not appear, refresh the page</span></i><br>';
echo '<img alt="flower graph" src="cigraph.php?c=', $cc, '&it=', $it, '&scale=', $scale, '">';
echo '</div>';

echo htmlfooter();
?>
