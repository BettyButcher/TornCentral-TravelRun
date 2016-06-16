<?php
## $Id: lastupdate.php $

require '.config.php';
require 'fx.inc.php';

ob_start('ob_tidyhandler');

// open the database connection
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
mysql_select_db(SQL_DATA);

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

// close the database connection
mysql_close($conn);

httpheader();
echo htmlheader('travelrun', usercss());

echo '<br><br>Last update was made at ', $lastupdate, ' GMT for ', $lastcountry, '.';

echo htmlfooter();
?>
