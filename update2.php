<?php
## $Id$

require '.config.php';
require 'fx.inc.php';
require './jsonAPI/json-service.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] != 'POST') die('No!');

$cch = 'm';
$prize = 0;

// open the database connection
$conn = mysqli_connect(SQL_HOST, SQL_USER, SQL_PASS, SQL_DATA);

if (!$conn) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

// save raw $_POST['data'] in the database
$utc = gmdate('Y-m-d H:i:s');
$pd = mysqli_real_escape_string($conn, $_POST['data']);
$s = $_SERVER['REMOTE_ADDR'];
$ua = mysqli_real_escape_string($conn, $_SERVER['HTTP_USER_AGENT']);
$r = mysqli_real_escape_string($conn, $_SERVER['HTTP_REFERER']);
$sql = "insert into post (postid, postUTC, postdata, user_agent, referer, sender) values (NULL, '$utc', '$pd', '$ua', '$r', '$s')";
mysqli_query($conn, $sql) or die($conn->error);

// check for NaN and abort
if (preg_match('/\s+NaN\s+/', $_POST['data'])) {
  echo 'NaN detected. Cannot update. Go back, reload, copy and paste again.<br>';
  echo '<br>';
  exit('<a href="update.php">Update again</a><br>');
}

// process $_POST['data'] and save info to the database
$n = preg_match('/are in ([A-Z a-z]+) and have/', $_POST['data'], $matches);
if ($n == 1) {
  $country = $matches[1];
  $safe_country = mysqli_real_escape_string($conn, $country);

  $sql2 = "select countryid, flower, letter, itemname from country, item where country.flower = item.itemid and countryname = '$safe_country'";
  $res2 = mysqli_query($conn, $sql2) or die($conn->error);
  $cid = $fid = 0;
  if (mysqli_num_rows($res2) == 1) {
        $row = mysqli_fetch_assoc($res2);
        $cid = $row['countryid'];
        $fid = $row['flower'];
        $cch = $row['letter'];
        $fin = $row['itemname'];
  }
  mysqli_free_result($res2);
  if ($cid != 0) {
    $_SESSION['recent_update'] = array();
    $_SESSION['recent_update']['country'] = $country;
    $_SESSION['recent_update']['flower'] = $fin;
    $_SESSION['recent_update']['plushie'] = '';
    $gotflower = 0;
    $gotplushie = 0;
    $items = array();
    $sql_items = "select itemname, itemid from item";
    $res_items = mysqli_query($conn, $sql_items) or die($conn->error);
    $rows = mysqli_fetch_all($res_items, MYSQLI_ASSOC);
    foreach ($rows as $row) {
        $items[$row['itemname']] = $row['itemid'];
    }
    mysqli_free_result($res_items);

    $t = array('Alcohol', 'Defensive', 'Drug', 'Enhancer', 'Flower', 'Medical', 'Melee', 'Other', 'Plushie', 'Primary', 'Secondary', 'Temporary');
    $rxt = implode('|', $t);
    #$rx = '@(?:' . $rxt . ')(?:\s+x[0-9,]+)?\s+([0-9A-Z &a-z-]+)\s+\$([0-9,]+)\s+([0-9,]+)@';
    $rx = '@Type:\s+(?:' . $rxt . ')\s+(?:x[0-9,]+\s+)?([0-9A-Z &a-z-]+)\s+Cost:\s+\$([0-9,]+)\s+In\s+stock:\s*([0-9,]+)@';
    if (preg_match_all($rx, $_POST['data'], $matches, PREG_SET_ORDER)) {
      foreach ($matches as $info) {
        $itemname = trim($info[1]);
        $itemcost = 1 * str_replace(',', '', $info[2]);
        $itemleft = 1 * str_replace(',', '', $info[3]);
        $itemid = 0;
        if (isset($items[$itemname])) $itemid = $items[$itemname];
        if ($itemid != 0) {
			setNewRecord($cid, $itemid, $itemcost, $itemleft);
		  $sql4 = "insert into stock (stockid, utctime, country, item, price, quantity, manual, sender) values (NULL, utc_timestamp(), $cid, $itemid, $itemcost, $itemleft, 0, '$s')";
          mysqli_query($conn, $sql4) or die($conn->error);
          if ($itemid == $fid) {
            $gotflower = 1;
            $_SESSION['recent_update']['qtd'] = $itemleft;
          }
        }
        if (preg_match('/ Plushie/', $itemname)) {
          $gotplushie = 1;
          $_SESSION['recent_update']['plushie'] .= $itemleft . ' ' . $itemname . '<br>';
        }
      }
    }
    if (!$gotflower) {
      $_SESSION['recent_update']['qtd'] = 0;
      $prices = array(0, 300, 4000, 600, 700, 5000, 500, 900, 500, 5000, 6000, 2000);
      $price = 0;
      if (isset($prices[$cid])) $price = $prices[$cid];
		setNewRecord($cid, $fid, $price, 0);
      $sql5 = "insert into stock (stockid, utctime, country, item, price, quantity, manual, sender) values (NULL, utc_timestamp(), $cid, $fid, $price, 0, 0, '$s')";
      mysqli_query($conn, $sql5) or die($conn->error);
    }
    if (!$gotplushie) {
      $_SESSION['recent_update']['plushie'] .= 'No plushies<br>';
    }
  // Prize Code

  }

  // update count
  $sql = "update counts set value = value + 1 where vkey = 'update2'";
  mysqli_query($conn, $sql) or die($conn->error);

  # delete files starting with $cch
  $files = glob('images/' . $cch . '*');
  foreach ($files as $file) {
    if (is_file($file)) unlink($file);
  }
}

// close the database connection
mysqli_close($conn);

usleep(100000); // sleep 0.1 seconds: it's hardly noticeable and it, hopefully, gives time for image to be created

header('Location: index.php?c=' . $cch);
exit('Redirected to <a href="index.php?c=' . $cch . '">the start page</a>.');
?>