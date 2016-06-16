<?php
## $Id: $

require '.config.php';
require 'fx.inc.php';

ob_start('ob_tidyhandler');

httpheader();
echo htmlheader('Travelrun: All Items', usercss());

echo '<br><br>';
// open the database connection
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
mysql_select_db(SQL_DATA);

// get the data
$itemall = array();
$sql = <<<SQL_ITEMALL
select s.utctime, country.countryname, item.itemname, s.quantity, s.price

from stock s
   , (select max(utctime) as mt, country, item from stock where manual = 0 group by country, item) smax
   , country
   , item

where s.utctime = smax.mt
  and s.country = smax.country
  and s.item = smax.item
  and s.country = country.countryid
  and s.item = item.itemid
  and s.manual = 0
SQL_ITEMALL;

if (isset($_GET['f']) && (trim($_GET['f']) != '')) {
  $safefilter = mysql_real_escape_string($_GET['f']);
  $sql .= " and item.itemname like '%$safefilter%'";
}

$sql .= " order by 1 desc, 2, 3";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_row($res)) {
  $itemall[] = array($row[0], $row[1], $row[2], $row[3], $row[4]);
}
mysql_free_result($res);
mysql_close($conn);

echo '<div class="itemalldata">';
echo '<table width="100%" border="0" cellpadding="0" cellspacing="1">';
echo '<tr bgcolor="#151515" height="35"><th style="border-top-left-radius: 5px"><font color="#FFFFFF"><b>Date</b></font></th><th><font color="#FFFFFF"><b>Country</b></font></th><th><font color="#FFFFFF"><b>Item</b></font></th><th><font color="#FFFFFF"><b>Quantity</b></font></th><th style="border-top-right-radius: 5px"><font color="#FFFFFF"><b>Price</b></font></th></tr>';
foreach ($itemall as $d) {
  echo '<tr bgcolor="#E6E6E6">';
  echo '<td align="center">&nbsp;', $d[0], '&nbsp;</td>';
  echo '<td align="center">&nbsp;', $d[1], '&nbsp;</td>';
  echo '<td>&nbsp;', $d[2], '&nbsp;</td>';
  echo '<td align="center">&nbsp;', number_format($d[3],0, '', ','), '&nbsp;</td>';
  echo '<td align="center">&nbsp;$', number_format($d[4],0, '', ','), '&nbsp;</td>';
  echo '</tr>';
}
echo '</table>';
echo '</div>';

echo htmlfooter();
?>
