<?php
## $Id$

require '.config.php';
require 'fx.inc.php';

//ob_start('ob_tidyhandler');

httpheader();
echo htmlheader('Travelrun: Drugs', usercss());

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
$drugs = array();
$sql = <<<SQL_DRUGS
select stock.item, item.itemname, stock.country, country.countryname, stock.utctime, stock.price, stock.quantity
from stock, lastdrugs, item, country
where stock.item = lastdrugs.item
  and stock.item = item.itemid
  and stock.country = country.countryid
  and stock.country = lastdrugs.country
  and stock.utctime = lastdrugs.lastutc
order by item.itemname, stock.price
SQL_DRUGS;
$res = mysqli_query($conn, $sql) or die($conn->error);
$rows = mysqli_fetch_all($res, MYSQLI_ASSOC);

foreach($rows as $row) {
  $drugs[] = [
      $row['item'],
      $row['itemname'],
      $row['country'],
      $row['countryname'],
      $row['utctime'],
      $row['price'],
      $row['quantity']
  ];
}
mysqli_free_result($res);
mysqli_close($conn);

echo '<div class="drugdata">';
echo '<table width="100%" border="0" cellpadding="0" cellspacing="1">';
echo '<tr style="font-family: Montserrat, sans-serif;letter-spacing: 1px" height="35" bgcolor="#151515"><th style="border-top-left-radius: 5px"><font color="#FFFFFF"><b>DRUG</b></font></th><th><font color="#FFFFFF"><b>COUNTRY</b></font></th><th><font color="#FFFFFF"><b>LAST UPDATE</b></font></th><th><font color="#FFFFFF"><b>STOCK</b></font></th><th style="border-top-right-radius: 5px"><font color="#FFFFFF"><b>COST</b></font></th></tr>';
$olddrug = '';
$oddgroup = 0;
foreach ($drugs as $d) {
  if ($d[1] != $olddrug) $oddgroup = 1 - $oddgroup;
  $olddrug = $d[1];

  $gmnow = gmdate('Y-m-d H:i:s');
  $unixlast = strtotime($d[4]);
  $unixnow = strtotime($gmnow);
  $delta = $unixnow - $unixlast;
  if ($delta < 60) {
    $deltaunits = 'second';
  } else {
    $delta /= 60;
    if ($delta < 60) {
      $deltaunits = 'minute';
    } else {
      $delta /= 60;
      if ($delta < 24) {
        $deltaunits = 'hour';
      } else {
        $delta /= 24;
        $deltaunits = 'day';
      }
    }
  }

  echo '<tr style="font-family: Muli, sans-serif" bgcolor="#A4A4A4" height="25">';
  echo '<td align="center">&nbsp;', $d[1], '&nbsp;</td>';
  echo '<td align="center">&nbsp;', $d[3], '&nbsp;</td>';
  echo '<td align="center">&nbsp;', number_format($delta, 0), ' ', $deltaunits, (($delta >= 1.5) ? 's' : ''), ' ago&nbsp;</td>';
  echo '<td align="center">&nbsp;', number_format($d[6], 0, '', ','), '&nbsp;</td>';
  echo '<td align="center">&nbsp;$', number_format($d[5],0, '', ','), '&nbsp;</td>';
  echo '</tr>';
}
echo '</table>';
echo '</div>';

echo htmlfooter();
?>
