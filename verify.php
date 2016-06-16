<?php
## $Id$

#require '.config.php';
require 'fx.inc.php';

ob_start('ob_tidyhandler');

// open the database connection
#$conn = mysql_connect(SQL_HOST, SQL_USER, SQL_PASS) or die(mysql_error());
#mysql_select_db(SQL_DATA);

#mysql_close($conn);
httpheader();
echo htmlheader('Travelrun: Verify Prize', usercss());
echo '<br><br>';
?>

<div class="updateform">
<form method="post" action="verify2.php">
  <i>Enter Code</i> 
	<br>
  <i></i><br>
  <textarea name="data" rows="1" cols="45"></textarea>
  <br><input type="submit" width="40" value="UPDATE"><br><i>Thank you.</i>
</form>
</div>

<?php
echo htmlfooter();
?>