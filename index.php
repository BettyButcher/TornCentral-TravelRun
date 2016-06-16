<?php
## $Id$

require '.config.php';
require 'fx.inc.php';

ob_start('ob_tidyhandler');

session_start();
$_SESSION['timecheck'] = date('YmdHis', time() + 1);

$cc = 'm';
if (isset($_GET['c'])) $cc = substr(trim($_GET['c']), 0, 1);
if (!in_array($cc, array('m', 'i', 'c', 'h', 'u', 'a', 's', 'j', 'x', 'e', 'z'))) $cc = 'm';

// open the database connection
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
mysql_select_db(SQL_DATA);

// update count
$sql = "update counts set value = value + 1 where vkey = '$cc'";
mysql_query($sql) or die(mysql_error());

// delete old data
$sql = "delete from stock where utctime < now() - interval 32 day";
mysql_query($sql) or die(mysql_error());
$sql = "delete from post where postUTC < now() - interval 3 day";
mysql_query($sql) or die(mysql_error());

// get last update date/time from the database
$sql = <<<SQL_LAST
select country.countryname, max(stock.utctime)
from country, stock
where stock.country = country.countryid
  and stock.manual = 0
group by country.countryname
order by max(stock.utctime) desc
limit 1
SQL_LAST;
$res = mysql_query($sql) or die(mysql_error());
$lastcountry = mysql_result($res, 0, 0);
$lastupdate = mysql_result($res, 0, 1);
mysql_free_result($res);

$sql = "select max(stock.utctime) from stock, country where stock.country = country.countryid and country.letter = '$cc' and stock.manual = 0";
$res = mysql_query($sql) or die(mysql_error());
$lastlocalupdate = mysql_result($res, 0, 0);
mysql_free_result($res);

$sql = "select countryname, countryid from country where letter = '$cc'";
$res = mysql_query($sql) or die(mysql_error());
$cname = mysql_result($res, 0, 0);
$ccode = mysql_result($res, 0, 1);
mysql_free_result($res);

$extradata = array();
$sql =<<<SQL_EXTRADATA
select itemtype.itemtypename, item.itemname, stock.price, stock.quantity, itemtype.cssclass
from stock, item, itemtype
where stock.item = item.itemid
  and item.itemtype = itemtype.itemtypeid
  and stock.utctime = '$lastlocalupdate'
  and stock.country = $ccode
order by itemtype.itemtypename, item.itemname
SQL_EXTRADATA;
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_row($res)) {
  $extradata[] = array($row[0], $row[1], $row[2], $row[3], $row[4]);
}
mysql_free_result($res);

// get update frequency
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

// get first post of last page of flower thread
$sql = "select valint from config where configkey = 'LAST_FLOWER_PAGE'";
$res = mysql_query($sql) or die(mysql_error());
$lastflower = 20 * (mysql_result($res, 0, 0) - 1);
mysql_free_result($res);

// close the database connection
mysql_close($conn);

httpheader();
echo htmlheader('Travelrun: Home', usercss());

echo '<br><table height="8" width="100%" cellspacing="1" cellpadding="2"><tr bgcolor="#303030"><td style="padding-top: 10px;border-bottom-left-radius: 5px" align="center"><a href="index.php?c=m"><img src="images/48/Mexico.png" title="', $cvk['m'], ' views" alt="', $cvk['m'], ' views"></a></td><td style="padding-top: 10px" align="center"><a href="index.php?c=i"><img src="images/48/Cayman-Islands.png" title="', $cvk['i'], ' views" alt="', $cvk['i'], ' views"></a></td><td style="padding-top: 10px" align="center"><a href="index.php?c=c"><img src="images/48/Canada.png" title="', $cvk['c'], ' views" alt="', $cvk['c'], ' views"></a></td><td style="padding-top: 10px" align="center"><a href="index.php?c=h"><img src="images/48/Hawaii-Flag.png" title="', $cvk['h'], ' views" alt="', $cvk['h'], ' views"></a></td><td style="padding-top: 10px" align="center"><a href="index.php?c=u"><img src="images/48/United-Kingdom.png" title="', $cvk['u'], ' views" alt="', $cvk['u'], ' views"></a></td><td style="padding-top: 10px" align="center"><a href="index.php?c=a"><img src="images/48/Argentina.png" title="', $cvk['a'], ' views" alt="', $cvk['a'], ' views"></a></td><td style="padding-top: 10px" align="center"><a href="index.php?c=s"><img src="images/48/Switzerland.png" title="', $cvk['s'], ' views" alt="', $cvk['s'], ' views"></a></td><td style="padding-top: 10px" align="center"><a href="index.php?c=j"><img src="images/48/Japan.png" title="', $cvk['j'], ' views" alt="', $cvk['j'], ' views"</a></td><td style="padding-top: 10px" align="center"><a href="index.php?c=x"><img src="images/48/China.png" title="', $cvk['x'], ' views" alt="', $cvk['x'], ' views"></a></td><td style="padding-top: 10px" align="center"><a href="index.php?c=e"><img src="images/48/United-Arab-Emirates.png" title="', $cvk['e'], ' views" alt="', $cvk['e'], ' views"></a></td><td style="padding-top: 10px" align="center"><a href="index.php?c=z"><img src="images/48/South-Africa.png" title="', $cvk['z'], ' views" alt="', $cvk['z'], ' views"></a></td><td align="center" style="padding-top: 10px;border-bottom-right-radius: 5px"><a href="itemall.php"><img src="images/48/item.png"></a></td></tr></table>';
echo '<html><head><script type="text/javascript"> var var1 = "728";var var2 = "90";var var3 = "728x90";var var4 = "17328";var var5 = "259f6be2870132cc7f00ee95bec44681"; </script></head><body><center></center></body></html>';
echo '<div class="timeinfo">';
echo 'Current time is ', gmdate('Y-m-d H:i:s'), ' GMT.<br>';
echo 'Last update was made at ', $lastupdate, ' GMT for <b>', $lastcountry, '</b>.';
echo '</div>';

echo '<hr>';
echo '<table width="100%" height="35" cellspacing="0" cellpadding="0" border="0"><tr bgcolor="#151515"><td style="border-radius: 5px"><center><a href="update.php" style="font-family: Montserrat, sans-serif;text-decoration: none;text-shadow: 1px 1px 1px #000;font-size: 35px;color: #FFFFFF"> &#62; UPDATE DATA HERE &#60; </a></center></td></tr></table>';
echo '<hr>';
echo '<h1 style="font-family: Montserrat, sans-serif;font-size: 35px"><center>', $cname, '</center></h1>';
if (isset($_SESSION['recent_update'])) {
  echo '<div class="pub"><br><i>';
  echo '<hr><center>If you want to ';
    echo '<a href="http://www.torn.com/forums.php#!p=threads&f=10&t=15907728&b=0&a=0&start=999999">';
    echo 'make a post in the ';
    echo 'flower thread and advertise travelrun</a>, you can use the ';
    echo 'code between the following lines:</i><br>';
    echo '================================================<br>';
    echo "{$_SESSION['recent_update']['qtd']} ";
    echo "{$_SESSION['recent_update']['flower']} in ";
    echo "{$_SESSION['recent_update']['country']}<br>\n";
    echo $_SESSION['recent_update']['plushie'];
    echo '<a href="http://travelrun.torncentral.com/">Travelrun</a> updated.<br>';
    echo '================================================</center><hr>';
  echo '</div>';
  unset($_SESSION['recent_update']);
}

echo '<div class="itemdata">';
$gmnow = gmdate('Y-m-d H:i:s');
$unixlast = strtotime($lastlocalupdate);
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
echo 'Items last updated - ';
      echo '<b>(', number_format($delta, 0), ' ', $deltaunits, (($delta >= 1.5) ? 's' : ''), ' ago)</b><br>';
echo '<table border="0" cellpadding="0" cellspacing="1" width="100%">';
echo '<tr style="font-family: Montserrat, sans-serif;letter-spacing: 2px" height="35" bgcolor="#151515"><th style="border-top-left-radius: 5px"><font color="#FFFFFF"><b>TYPE</b></font></th><th><font color="#FFFFFF"><b>ITEM</b></font></th><th><font color="#FFFFFF"><b>COST</b></font></th><th style="border-top-right-radius: 5px"><font color="#FFFFFF"><b>STOCK</b></font></th></tr>';
foreach ($extradata as $extra) {
  echo '<tr style="font-family: Montserrat, sans-serif" height="25" class="', $extra[4], '">';
  echo '<td>&nbsp;', $extra[0], '&nbsp;</td>';
  echo '<td>&nbsp;', $extra[1], '&nbsp;</td>';
  echo '<td class="valuedata"><center>&nbsp;$', number_format($extra[2], 0, '', ','), '&nbsp;</center></td>';
  echo '<td class="valuedata"><center>&nbsp;', number_format($extra[3], 0, '', ','), '&nbsp;</center></td>';
  echo '</tr>';
}
echo '</table>';
echo '</div>';

echo '<div class="flowerchart">';
echo '<i><span class="info"><center>If the graph does not appear, refresh the page</center></span></i><br>';
echo '<center><img alt="flower graph" src="fgraph.php?c=', $cc ,'"></center>';
echo '</div>';

echo '<hr>';
echo '<div style="font-size:12px", style="font-family: Montserrat, sans-serif" class="footer">';
echo '<i>Travelrun maintained by <a href="http://www.torn.com/profiles.php?XID=1275358" target="new">Betty_Buther</a>.<br>';
echo '<i>Source code available on a <a href="https://github.com/komrof/tc-travelrun/">git repository</a>.</i><br>';
echo '<i>Travelrun supports <a href="irc://irc.torn.com/drugden">IRC channel #drugden</a>.</i><br>';
echo '</div>';


echo htmlfooter();
?>
	