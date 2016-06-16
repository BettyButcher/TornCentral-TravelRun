<?php
## $Id$

require '.config.php';

$cch = 'm';
$pid = 1 * $_GET['p'];
if ($pid < 0) die('invalid access');
if ($pid > 1000000) die('invalid access');

// open the database connection
$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
mysql_select_db(SQL_DATA);

if ($pid == 0) {
  $sql = "select min(postid), max(postid) from post";
  $res = mysql_query($sql) or die(mysql_error());
  $little = mysql_result($res, 0, 0);
  $big = mysql_result($res, 0, 1);
  mysql_free_result($res);
  echo 'use p between ', $little, ' and ', $big;
  exit(0);
}

$sql = "select valtext from config where configkey = 'FLOWER_PASS'";
$res = mysql_query($sql) or die(mysql_error());
if (mysql_num_rows($res) != 1) die('Database is mis-configured');
$flowerkey = mysql_result($res, 0, 0);
mysql_free_result($res);

if ($_GET['k'] != $flowerkey) die('Bad k parameter');

// get raw $_POST['data'] from the database
$sql = "select postUTC, postdata from post where postid = $pid";
$res = mysql_query($sql) or die(mysql_error());
if (mysql_num_rows($res) != 1) die('wrong parameter');
$utc = mysql_result($res, 0, 0);
$dat = mysql_result($res, 0, 1);
mysql_free_result($res);
// close the database connection
mysql_close($conn);
echo 'data from ', $utc, ' is <pre>', $dat, '</pre><br>~~~~~~~~<br>';

// check for NaN and abort
if (preg_match('/\s+NaN\s+/', $dat)) {
  echo 'NaN detected. Cannot update. Go back, reload, copy and paste again.<br>';
  echo '<br>';
  echo '<a href="update.php">Update again</a><br>';
  exit('');
}

// process $dat and display info
$n = preg_match('/are in ([A-Z a-z]+) and have/', $dat, $matches);
echo 'First match returned: ', $n, '<br>';
if ($n == 1) {
  $country = $matches[1];
  echo 'Country is: ', $country, '<br>';

  $t = array('Alcohol', 'Defensive', 'Drug', 'Enhancer', 'Flower', 'Medical', 'Melee', 'Other', 'Plushie', 'Primary', 'Secondary', 'Temporary');
  $rxt = implode('|', $t);
  #$rx = '@(?:' . $rxt . ')\s+([0-9A-Z &a-z-]+)\s+\$([0-9,]+)\s+([0-9,]+)@';
  $rx = '@Type:\s+(?:' . $rxt . ')\s+(?:x[0-9,]+\s+)?([0-9A-Z &a-z-]+)\s+Cost:\s+\$([0-9,]+)\s+In\s+stock:\s+([0-9,]+)@';
  if (preg_match_all($rx, $dat, $matches, PREG_SET_ORDER)) {
    echo '2nd match all worked<br>';
    foreach ($matches as $info) {
      $itemname = trim($info[1]);
      $itemcost = 1 * str_replace(',', '', $info[2]);
      $itemleft = 1 * str_replace(',', '', $info[3]);
      echo "got ", htmlentities($itemname), ", $itemcost, $itemleft<br>";
    }
  } else {
    echo '2nd match all failed<br>';
  }
  echo '<br>';
}
?>
