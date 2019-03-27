<?php
## $Id: $

require '.config.php';
require 'fx.inc.php';

//ob_start('ob_tidyhandler');

httpheader();
echo htmlheader('Travelrun: All Items', usercss());

echo '<br><br>';
// open the database connection
$conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PASS, SQL_DATA);

if (!$conn) {
  echo "Error: Unable to connect to MySQL." . PHP_EOL;
  echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
  echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
  exit;
}

// get the data
$itemall = [];
$sql = "
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
";

if (isset($_GET['f']) && (trim($_GET['f']) != '')) {
  $safefilter = mysqli_real_escape_string($_GET['f']);
  $sql .= " and item.itemname like '%$safefilter%'";
}

$sql .= " order by 1 desc, 2, 3";
$res = mysqli_query($conn, $sql) or die($conn->error);
$rows = mysqli_fetch_all($res, MYSQLI_ASSOC);

foreach($rows as $row) {
  $itemall[] = [
      $row['utctime'],
      $row['countryname'],
      $row['itemname'],
      $row['quantity'],
      $row['price'],
  ];
}
mysqli_free_result($res);
mysqli_close($conn);

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
