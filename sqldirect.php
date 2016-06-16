<?php
## $Id$

require '.config.php';

usleep(SQLDIRECT_DELAY * 1000);
$sql = '';
$pwd = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $pwd = $_POST['pwd'];
  if ($pwd == SQLDIRECT_PASSWORD) {
    // open the database connection
    $conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
    mysql_select_db(SQL_DATA);

    $sql = trim($_POST['sql']);
    $res = mysql_query($sql) or die(mysql_error());
    if (mysql_num_rows($res) > 0) {
      echo '<table border="1">';
      echo '<tr>';
      for ($k = 0; $k < mysql_num_fields($res); $k++) {
        echo '<th>';
        echo htmlentities(mysql_field_name($res, $k));
        echo '</th>';
      }
      echo '</tr>';
      while ($row = mysql_fetch_row($res)) {
        echo '<tr>';
        foreach ($row as $value) {
          echo '<td>';
          echo htmlentities($value);
          echo '</td>';
        }
        echo '</tr>';
      }
      echo '</table>';
      mysql_free_result($res);
    }
    // close the database connection
    mysql_close($conn);
    echo '<br>~~~~~~~~<br>';
  }
}

echo '<form method="post" action="">';
echo 'Enter SQL below<br><textarea name="sql" rows="12" cols="78">';
echo $sql;
echo '</textarea><br>';
echo 'Enter password: <input type="password" name="pwd" value="', $pwd, '">';
echo ' <input type="submit" value="Execute">';
echo '</form>';

?>
