<?php

	// This form lets listeners interact with Panther Radio Game Staff

      // For information, contact Ryan Palmer (rypalmer@gmail.com)
      // Built July 2006 - by Ryan Palmer

// include the database configuration and
// open connection to database


include ("connect.php");
date_default_timezone_set('America/Halifax');

include ("include.php");

// Specify the most recent game

if(isset($_GET[display_home_team]))
{

$display_home_team = $_GET[display_home_team];

$years = date("Y");
$months = date("m");
$days = date("d");
$hours = date("G");
$minutes = date("i");
$seconds = date("s");
$daysthismonth = date("t");

// $hours = $hours + 10;
$months = $months + 2;
$days = $days + 13;

if($hours >= 13)
{
$hours = $hours - 24;
$days = $days + 1;
}

if($days > $daysthismonth)
{
$days = $days - $daysthismonth;
$months = $months + 1;
}

if($months > 12)
{
$months = $months - 12;
$years = $years + 1;
}

$tenhourslater = $years . "-" . $months . "-" . $days . " " . $hours . ":" . $minutes . ":" . $seconds;


	$query2   = "SELECT game_id FROM game WHERE team_id_home = '$display_home_team' OR team_id_away = '$display_home_team' AND date < '$tenhourslater' ORDER BY game_id DESC LIMIT 1";

	$result2  = mysql_query($query2) or die('Error, query failed. ' . mysql_error());

if(mysql_num_rows($result2) == 0)
{
?>
<h2>Sorry, no games are available for your team at this time. Check back closer to game time.</h2>
<p><a href="/admin/logout.php">Logout</a></p>
<?php
exit();
}
	$row2     = mysql_fetch_array($result2, MYSQL_ASSOC);
      $game_id_current = $row2['game_id'];
}
else
{
	// Specify the most recent game
	// If its set as "game" in the address bar, use that instead

	$query2   = "SELECT MAX(game_id) AS game_id_current FROM game";
	$result2  = mysql_query($query2) or die('Error, query failed. ' . mysql_error());
	$row2     = mysql_fetch_array($result2, MYSQL_ASSOC);

	$game_id_current = $row2['game_id_current'];
}

if(isset($_GET[display_game_id]))
{

$display_game_id = $_GET[display_game_id];
$display_refresh = "?display_game_id=" . $display_game_id;
//echo "display game id: ", $display_game_id;


	$game_id_current = $_GET[display_game_id];
}

?>
<html>
<head>
<title>Panther Radio Listening Lounge - Add a comment</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css">

.table		{
		background-color:#AC9B7D; 
		border: 1;
		width: 800px;
		}
.small		{
		font: 0.7em "MS Verdana" sans-serif;
		font-color: white;
		text-decoration: none;
		}
p		{
		font: 0.9em "MS Verdana" sans-serif;
		font-color: white;
		text-decoration: none;		
		}

.lcol		{
		position: relative;
		left: 0px;
		width: 600px;
		}

.rcol		{
		position: relative;
		left: 150px;
		right: 100px;
		}
.fcol		{

		float: right;
		width: 20%;
		}

</style>

</head>
<body bgcolor="#EDD175">
<center><h2>Send a message to the Panther Radio Broadcast Team!</h2>
<form method="post" name="guestform">
<input type="hidden" name="game_id" value="<?=$game_id_current;?>">
<div align="center"> <table align="center" width="100%" border="0" cellpadding="2" cellspacing="1">
  <tr> 
   <td width="100">Name</td> <td> 
    <input name="txtName" type="text" id="txtName" size="30" maxlength="50"></td>
 </tr>
  <tr> 
   <td width="100">Email</td>
   <td> 
    <input name="txtEmail" type="text" id="txtEmail" size="30" maxlength="100"></td>
 </tr>
  <tr> 
   <td width="100">Subject</td> <td> 
    <input name="txtTitle" type="text" id="txtTitle" size="30" maxlength="50"></td>
 </tr>
  <tr> 
   <td width="100">Message</td> <td> 
    <textarea name="mtxMessage" cols="23" rows="5" id="mtxMessage"></textarea></td>
 </tr>
  <tr> 
   <td width="100">&nbsp;</td>
   <td> 
    <input name="btnSign" type="submit" id="btnSign" value="Send the Comment"></td>
 </tr>
</table></div>
</form></center>
</body>
</html>