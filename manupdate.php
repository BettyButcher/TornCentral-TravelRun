<?php
## $Id$

require '.config.php';
require 'fx.inc.php';

ob_start('ob_tidyhandler');

#connect to database
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
mysql_select_db(SQL_DATA);

$sql = <<<SQL_FLOWERS
select item.itemid, item.itemname, country.countryname
from country, item
where country.flower = item.itemid
order by item.itemname
SQL_FLOWERS;

$data = array();
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_row($res)) {
  $data[] = array($row[0], $row[1], $row[2]);
}
mysql_free_result($res);

mysql_close($conn);

httpheader();
echo htmlheader('Travelrun: Manual Update', usercss());

echo '<div class="mantitle">';
echo '<h3>Manual Update</h3>';
echo '</div>';

echo '<div class="manform">';
echo '<i>Data from this update is only shown in the graph.</i>';

echo '<form method="post" action="manupdate2.php">';
echo 'You can copy all of the date/time forum line or part of it as long as it includes the highlighted underscored portion: [Posted on Sun <b><u>Sep 29, 2013 15:23</u></b>:55]<br>';
echo '<label>Time: <input type="text" name="time" size="24" title="Copy/Paste the time from the flower thread"></label>';
echo ' ';
echo '<label>GMT Offset: <input type="text" name="gmt" value="0" size="2"></label> (leave offset at 0 unless TC Time changes -- DST??)<br>';
echo 'Flower: <select name="flower"><option value="0">(select flower)';
      foreach ($data as $flower) {
        echo '<option value="', $flower[0], '">', $flower[1], ' (', $flower[2], ')';
      }
      echo '</select><br>';
echo '<label>Quantity in stock: <input type="text" name="qtd" size="4"></label><br>';
echo '<br>';
echo '<input type="submit" value="update flower">';
echo '</form>';
echo '</div>';

echo htmlfooter();
?>
