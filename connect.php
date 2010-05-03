<?php
// For information, contact Ryan Palmer (rypalmer@gmail.com)

// include the database configuration and
// open connection to database

$dbh = mysql_connect ("mysql_host", "mysql_user", "mysql_password") or die ('I cannot connect to the database because: '. mysql_error());
mysql_select_db ("mysql_db_name");

?>
