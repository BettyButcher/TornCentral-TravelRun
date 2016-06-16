<?php
## $Id$

define('DAYS', 86400); /* seconds in a day */

require '.config.php';
session_start();

function centeredtext($image, $text, $font, $x1, $y1, $x2, $y2, $textcolor, $bgcolor, $bordercolor) {
  imagerectangle($image, $x1, $y1, $x2, $y2, $bordercolor);
  imagerectangle($image, $x1 + 1, $y1 + 1, $x2 - 1, $y2 - 1, $bgcolor);
  $width = imagefontwidth($font) * strlen($text);
  $height = imagefontheight($font);
  $txtx = (($x2 - $x1) - $width) / 2 + $x1;
  $txty = (($y2 - $y1) - $height) / 2 + $y1;
  imagestring($image, $font, $txtx, $txty, $text, $textcolor);
}

if (!isset($_SESSION['timecheck'])) die('invalid access');
if (date('YmdHis') > $_SESSION['timecheck']) die('invalid access');

$ccode = isset($_GET['c']) ? $_GET['c'] : '*';
if (!in_array($ccode, array('m', 'i', 'c', 'h', 'u', 'a', 's', 'j', 'x', 'e', 'z'))) die('invalid parameter');
$filename = 'images/' . $ccode . gmdate('YmdH') . substr(gmdate('i'), 0, 1) . '0.png';

if (!is_file($filename)) {
  # delete files starting with $ccode
  $files = glob('images/' . $ccode . '*');
  foreach ($files as $file) {
    if (is_file($file)) unlink($file);
  }

  #connect to database
  $conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
  mysql_select_db(SQL_DATA);

  # create black image
  $im = imagecreatetruecolor(640, 480) or die('image fail');

  # prepare colours
  $black = imagecolorallocate($im, 0, 0, 0);
  $blue = imagecolorallocate($im, 0, 0, 255);
  $green = imagecolorallocate($im, 0, 255, 0);
  $lightgreen = imagecolorallocate($im, 153, 255, 153);
  $red = imagecolorallocate($im, 255, 0, 0);
  $gray = imagecolorallocate($im, 127, 127, 127);
  $white = imagecolorallocate($im, 255, 255, 255);

  #white background
  imagefilledrectangle($im, 0, 0, 639, 479, $white);

  #title
  $sql = "select country.countryname, item.itemname, country.countryid, country.flower from country, item where country.letter = '$ccode' and country.flower = item.itemid";
  $res = mysql_query($sql) or die(mysql_error());
  $title = mysql_result($res, 0, 0);
  $subtitle = mysql_result($res, 0, 1);
  $cid = mysql_result($res, 0, 2);
  $fid = mysql_result($res, 0, 3);
  mysql_free_result($res);
  centeredtext($im, $title, 3, 0, 0, 639, 18, $black, $white, $white);
  centeredtext($im, $subtitle, 2, 0, 18, 639, 30, $black, $white, $white);

  #legend
  centeredtext($im, ' ', 1, 570, 183, 638, 265, $black, $white, $black);
  centeredtext($im, ' 1 day     ', 1, 571, 184, 637, 200, $black, $white, $white);
  imagefilledarc($im, 576, 192, 9, 9, 0, 360, $red, IMG_ARC_PIE);
  centeredtext($im, ' 2 days    ', 1, 571, 200, 637, 216, $black, $white, $white);
  imagefilledarc($im, 576, 208, 7, 7, 0, 360, $blue, IMG_ARC_PIE);
  centeredtext($im, ' 3 days    ', 1, 571, 216, 637, 232, $black, $white, $white);
  imagefilledarc($im, 576, 224, 5, 5, 0, 360, $green, IMG_ARC_PIE);
  centeredtext($im, ' 4 days    ', 1, 571, 232, 637, 248, $black, $white, $white);
  imagefilledarc($im, 576, 240, 3, 3, 0, 360, $black, IMG_ARC_PIE);
  centeredtext($im, ' 5+ days   ', 1, 571, 248, 637, 264, $black, $white, $white);
  imagesetpixel($im, 576, 256, $black);

  #axis and grid
  centeredtext($im, 'GMT time', 2, 30, 469, 561, 479, $black, $white, $white);
  imagestringup($im, 2, 1, 290, 'quantity * 1000', $black);
  centeredtext($im, '0', 2, 6, 460, 30, 470, $black, $white, $white);
  imageline($im, 30, 460, 561, 460, $black);
  imageline($im, 561, 460, 561, 40, $black);
  imageline($im, 561, 40, 30, 40, $black);
  imageline($im, 30, 40, 30, 460, $black);
  for ($k = 1; $k <= 24; $k++) {
    $cx = $k/24*531 + 30;
    centeredtext($im, $k, 1, $cx - 4, 461, $cx + 4, 469, $black, $white, $white);
    if ($k != 24) imageline($im, $cx, 460, $cx, 40, $gray);
  }
  for ($k = 1; $k <= 10; $k++) {
    $cy = (10-$k)/10*420 + 40;
    centeredtext($im, $k, 1, 20, $cy - 4, 29, $cy + 4, $black, $white, $white);
    if ($k != 10) imageline($im, 30, $cy, 561, $cy, $gray);
  }

  # now
  $hinow = gmdate('H') * 60 + gmdate('i');
  $x1 = $hinow / 1440 * 531 + 30;
  $x2 = ($hinow + 10) / 1440 * 531 + 30;
  imagefilledrectangle($im, $x1, 41, $x2, 459, $lightgreen);
  imagestring($im, 3, $x2 + 2, 47, 'now', $lightgreen);

  #get data for flower $_GET['f']
  $sql = "select utctime, price, quantity from stock where country = $cid and item = $fid";
  $res = mysql_query($sql) or die(mysql_error());
  while ($row = mysql_fetch_row($res)) {
    $hour = date('H', strtotime($row[0]));
    $minute = date('i', strtotime($row[0]));
    $daytime = $hour * 60 + $minute;
    $realx = $daytime / 1440 * 531 + 30;
    $realy = (10000 - $row[2]) / 10000 * 420 + 40;

    $delta = time() - strtotime($row[0] . ' UTC');
         if ($delta >= 4*DAYS) imagesetpixel($im, $realx, $realy, $black);
    else if ($delta >= 3*DAYS) imagefilledarc($im, $realx, $realy, 3, 3, 0, 360, $black, IMG_ARC_PIE);
    else if ($delta >= 2*DAYS) imagefilledarc($im, $realx, $realy, 5, 5, 0, 360, $green, IMG_ARC_PIE);
    else if ($delta >= 1*DAYS) imagefilledarc($im, $realx, $realy, 7, 7, 0, 360, $blue, IMG_ARC_PIE);
    else                       imagefilledarc($im, $realx, $realy, 9, 9, 0, 360, $red, IMG_ARC_PIE);
  }

  #free resources
  mysql_free_result($res);

  imagepng($im, $filename);
  imagedestroy($im);

  #close database connection
  mysql_close($conn);
}

header('Content-Type: image/png');
readfile($filename);
?>
