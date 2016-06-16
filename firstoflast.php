<?php
## $Id$

require '.config.php';
require 'fx.inc.php';

ob_start('ob_tidyhandler');

// open the database connection
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
mysql_select_db(SQL_DATA);

$sql = "select valint from config where configkey = 'LAST_FLOWER_PAGE'";
$res = mysql_query($sql) or die(mysql_error());
$last1st = mysql_result($res, 0, 0);
mysql_free_result($res);

mysql_close($conn);
httpheader();
echo htmlheader('TravelRun: Last Forum Page', usercss());

echo '<br><br><br><br>';
echo '<div class="updateform">';
echo '<form method="post" action="firstoflast2.php">';
echo '<label>Last page in the flower thread: <input type="text" value="', $last1st, '" name="last1st" size="4"><br></label>';
echo '<input type="submit" value="UPDATE"><br>';
echo '</form>';
echo '<br>For the example below, you\'d use 860 for the last page.<br>';
echo '<img src="860.jpg" alt="page navigation on torn">';
echo '</div>';

echo htmlfooter();
?>
