<?php
## $Id$

require '.config.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') die('No!');

$country = array(260=>1, 617=>2, 263=>3, 264=>4, 267=>5, 271=>6, 272=>7, 277=>8, 276=>9, 385=>10, 282=>11);

$flower = 1 * $_POST['flower'];

if ($flower && isset($country[$flower]) && (trim($_POST['gmt']) != '') && (trim($_POST['qtd']) != '')) {
  if (preg_match('@(Jan|Feb|Mar|Apr|May|Jun|Jul|Aug|Sep|Oct|Nov|Dec) \d\d, \d\d\d\d \d\d:\d\d@', $_POST['time'], $matches) == 1) {
    // open the database connection
    $conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
    mysql_select_db(SQL_DATA);

    $flowertime = strtotime($matches[0]);
    $gmtoffset = 1 * $_POST['gmt'];
    $unixtime = date('Y-m-d H:i:s', $flowertime - 60*60*$gmtoffset);
    $quantity = 1 * $_POST['qtd'];
    $sender = $_SERVER['REMOTE_ADDR'];

    $sql = "insert into stock (utctime, country, item, price, quantity, manual, sender) values ('$unixtime', $country[$flower], $flower, 0, $quantity, 1, '$sender')";
    mysql_query($sql) or die(mysql_error());

    // close the database connection
    mysql_close($conn);

    # delete image files
    $files = glob('images/*');
    if ($files) {
      foreach ($files as $file) {
        if (is_file($file)) unlink($file);
      }
    }

    echo '<b>Flower updated. The data will only be used to draw dots on the graph.</b><br>';
    echo '<br>';
    echo '<a href="manupdate.php">Update another</a> or return to the <a href="index.php">start page</a>.';
  } else {
    echo '<b>Update failed.</b><br>';
    echo '<br>';
    echo '<a href="manupdate.php">Try updating again</a> or return to the <a href="index.php">start page</a>.';
  }
} else {
  echo '<b>Unable to extract time.</b><br>';
  echo '<br>';
  echo '<a href="manupdate.php">Try updating again</a> or return to the <a href="index.php">start page</a>.';
}
?>
