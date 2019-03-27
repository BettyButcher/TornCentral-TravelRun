<?php
## $Id: $

require '.config.php';
require 'fx.inc.php';

//ob_start('ob_tidyhandler');

httpheader();
echo htmlheader('Travelrun: Plushies', usercss());

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
$plushies = [];
$sql = <<<SQL_PLUSHIES
select stock.item, item.itemname, stock.country, country.countryname, stock.utctime, stock.price, stock.quantity
from stock, lastplushies, item, country
where stock.item = lastplushies.item
  and stock.item = item.itemid
  and stock.country = country.countryid
  and stock.country = lastplushies.country
  and stock.utctime = lastplushies.lastutc
order by stock.utctime
SQL_PLUSHIES;
$res = mysqli_query($conn, $sql) or die($conn->error);
$rows = mysqli_fetch_all($res, MYSQLI_ASSOC);

foreach($rows as $row) {
  $plushies[] = [
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
echo '<table border="0" cellpadding="0" cellspacing="1" width="100%">';
echo '<tr height="35" bgcolor="#151515" style="font-family: Montserrat, sans-serif;letter-spacing: 2px"><th style="border-top-left-radius: 5px"><font color="#FFFFFF"><b>PLUSHIE</b></font></th><th><font color="#FFFFFF"><b>COUNTRY</b></font></th><th><font color="#FFFFFF"><b>LAST UPDATE</b></font></th><th><font color="#FFFFFF"><b>STOCK</b></font></th><th><font color="#FFFFFF"><b>COST</b></font></th><th style="border-top-right-radius: 5px"><font color="#FFFFFF"><b>AIRSTRIP</b></font></th></tr>';
$oddgroup = 0;
foreach ($plushies as $d) {
  $oddgroup = 1 - $oddgroup;

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
  $airstrip = '?????';
  if ($d[3] == 'Mexico') $airstrip = '00:18';
  if ($d[3] == 'Cayman Islands') $airstrip = '00:25';
  if ($d[3] == 'Canada') $airstrip = '00:29';
  if ($d[3] == 'Hawaii') $airstrip = '01:34';
  if ($d[3] == 'United Kingdom') $airstrip = '01:51';
  if ($d[3] == 'Argentina') $airstrip = '01:57';
  if ($d[3] == 'Switzerland') $airstrip = '02:03';
  if ($d[3] == 'Japan') $airstrip = '02:38';
  if ($d[3] == 'China') $airstrip = '02:49';
  if ($d[3] == 'UAE') $airstrip = '03:10';
  if ($d[3] == 'South Africa') $airstrip = '03:28';
  echo '<td align="center">&nbsp;', $airstrip, '&nbsp;</td>';
  echo '</tr>';
}
echo '</table>';
echo '</div>';

echo htmlfooter();
?>
