<?php
## $Id$

require '.config.php';
require 'fx.inc.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') die('No!');

// open the database connection
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
mysql_select_db(SQL_DATA);

// save $_POST['last1st'] in the database
if (preg_match('/[^0-9]/', $_POST['last1st'])) die('No!');
$last1st = 1 * $_POST['last1st'];
if ($last1st < 1) die('No!');
if ($last1st > 999999) die('No!');
$sql = "update config set valint = $last1st where configkey = 'LAST_FLOWER_PAGE'";
mysql_query($sql) or die(mysql_error());

// close the database connection
mysql_close($conn);

header('Location: index.php');
exit('Redirected to <a href="index.php">the start page</a>.');
?>
