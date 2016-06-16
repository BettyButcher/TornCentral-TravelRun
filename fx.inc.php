<?php
function httpheader() {
  header('Content-Type: text/html; charset=utf-8');
  header('Cache-Control: private');
}

function htmlheader($title, $css) {
  $css = preg_replace('/[^a-zA-Z0-9]/', '', $css);
  if (($css == '') || (!is_file('css/' . $css . '.css'))) $css = 'travelrun';
  $retval = '';
  $retval .= '<!DOCTYPE html>';
  $retval .= '<html lang="en">';
  $retval .= '<head>';
  $retval .= '<meta http-equiv="Content-Type" content="text/html;charset=utf-8">';
  $retval .= '<link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">';
  $retval .= '<link href="http://fonts.googleapis.com/css?family=Muli" rel="stylesheet" type="text/css">';
  $retval .= '<link href="src/jquery.counter-analog.css" media="screen" rel="stylesheet" type="text/css" />';
  $retval .= '<link href="src/jquery.counter-analog2.css" media="screen" rel="stylesheet" type="text/css" />';
  $retval .= '<link href="src/jquery.counter-analog3.css" media="screen" rel="stylesheet" type="text/css" />';
  $retval .= '<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">';
  $retval .= '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js" type="text/javascript"></script>';
  $retval .= '<script src="src/jquery.counter.js" type="text/javascript"></script>';
  $retval .= '<title>' . $title . '</title>';
  $retval .= '<link rel="stylesheet" href="css/travelrun.css">';
  $retval .= '<script> $("#custom").addClass("counter-analog").counter({ initial: "0:00.0", direction: "up", interval: "1", format: "9999", stop: "9999" }); </script>';
  $retval .= '</head>';
  $retval .= '<body>';
  $retval .= '<div id="page">';
  $retval .= '<div id="header">';
  $retval .= '<div>';
  $retval .= '<a href="index.php" id="logo"><img src="images/logo.png"></a>';
  $retval .= '<ul id="navigation" style="font-family: Montserrat, sans-serif">';
  $retval .= '<li>';
  $retval .= '<a href="index.php">Home</a>';
  $retval .= '</li>';
  $retval .= '<li>';
  $retval .= '<a href="flowers.php">Flowers</a>';
  $retval .= '</li>';
  $retval .= '<li>';
  $retval .= '<a href="plushies.php">Plushies</a>';
  $retval .= '</li>';
  $retval .= '<li>';
  $retval .= '<a href="drugs.php">Drugs</a>';
  $retval .= '</li>';
  $retval .= '<li>';
  $retval .= '<a href="firstoflast.php">Last Forum Page</a>';
  $retval .= '</li>';
  $retval .= '<li>';
  $retval .= '<a href="stats.php"><font color="orange">Stats</font></a>';
  $retval .= '</li>';
  $retval .= '</ul>';
  $retval .= '</div>';
  $retval .= '<span class="shadow"></span>';
  $retval .= '</div>';
  return $retval;
}

function htmlfooter() {

  $retval = '';
  $retval .= '</body></html>';
}

function usercss() {
  $retval = 'travelrun';
  if (isset($_GET['css'])) {
    $retval = $_GET['css'];
  } else {
    if (isset($_COOKIE['css'])) {
      $retval = $_COOKIE['css'];
    } else {
      $ipbasedname = 'IP' . md5($_SERVER['REMOTE_ADDR']);
      if (is_file('css/' . $ipbasedname . '.css')) {
        $retval = $ipbasedname;
      }
    }
  }
  $retval = preg_replace('/[^a-zA-Z0-9]/', '', $retval);
  return $retval;
}
?>