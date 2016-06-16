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
echo htmlheader('Travelrun: Update Data', usercss());
echo '<br><br>';
?>

<div class="updateform">
<form method="post" action="update2.php">
  Copy all of the torn country item page <i>(<b>Ctrl+A</b>, <b>Ctrl+C</b> probably works)</i><br>
  paste in the text box below <i>(<b>Ctrl+V</b> perhaps)</i> 
  <!--font size="-2">(if you're paranoid, you can edit the amount you have to,
  for example, <b>$100</b>, but leave that line in with no other changes)</font--><br>
  and click the "UPDATE" button<br>
  <i>The pasted text has to contain the line with the country name and your money; you can safely edit the amount of money but leave that line otherwise unchanged</i><br>
  <textarea name="data" rows="20" cols="80"></textarea>
  <br><input type="submit" width="40" value="UPDATE"><br><i>Thank you.</i>
</form>
</div>

<?php
echo htmlfooter();
?>
