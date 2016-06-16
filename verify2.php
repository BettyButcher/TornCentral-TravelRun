<?php
## $Id$

require '.config.php';
require 'fx.inc.php';
session_start();


#mysql_close($conn);
httpheader();
echo htmlheader('Travelrun: Verify Prize', usercss());
echo '<br><br>';


if ($_SERVER['REQUEST_METHOD'] != 'POST') die('No!');


// open the database connection
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
mysql_select_db(SQL_DATA);

// save raw $_POST['data'] in the database
	$datachk = $_POST["data"];

$result = mysql_query("SELECT prizeid, pdate, pcode, verified FROM prize WHERE pcode = '$datachk'");
while ($row = mysql_fetch_object($result)) {
    echo ' MD5 ', $row->pcode, ' is valid<br>';
	echo 'ID:', $row->prizeid;
	echo '<br>Created on :', $row->pdate;
	echo '<br>Verified :', $row->verified;
}
mysql_free_result($result);

		  $sql2 = ("Update prize set verified = 'Y' where pcode = '$datachk'");
		  mysql_query($sql2) or die(mysql_error());


mysql_close($conn);

echo htmlfooter();
?>