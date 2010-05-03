<?php

      // This is the scoreboard frame for the Panther Radio Listening Lounge
      // This page is not meant to be loaded by itself

      // For information, contact Ryan Palmer (rypalmer@gmail.com)
      // Built July 2006 - by Ryan Palmer

      // include the database configuration and
      // open connection to database

include ("connect.php");

include ("include.php");
include ("functions.php");

// Set the refresh rate, in seconds
$refresh = 600;


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

$hours = $hours + 10;
// $months = $months + 2;
// $days = $days + 13;

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

$months = sprintf("%02d",$months);
$days = sprintf("%02d",$days);
$hours = sprintf("%02d",$hours);
$minutes = sprintf("%02d",$minutes);
$seconds = sprintf("%02d",$seconds);

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

$query3   = "SELECT * FROM game WHERE game_id=$game_id_current";
$result3  = mysql_query($query3) or die('Error, query failed. ' . mysql_error());
$row3     = mysql_fetch_array($result3, MYSQL_ASSOC);

$team_id_home_current = $row3['team_id_home'];
$team_id_away_current = $row3['team_id_away'];
$game_date_current = $row3['date'];

}




if(isset($_GET[display_game_id]))
{

$display_game_id = $_GET[display_game_id];

	$game_id_current = $_GET[display_game_id];

	$query3   = "SELECT * FROM game WHERE game_id=$game_id_current";
	$result3  = mysql_query($query3) or die('Error, query failed. ' . mysql_error());
	$row3     = mysql_fetch_array($result3, MYSQL_ASSOC);

	$team_id_home_current = $row3['team_id_home'];
	$team_id_away_current = $row3['team_id_away'];
	$game_date_current = $row3['date'];

}


?>
<html>
<head>
<title>Panther Radio Interactive Listening Lounge - Powered By Newradio.ca</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<meta http-equiv="Refresh" content="<?=$refresh;?>; URL=fangui-video.php<?=$display_refresh;?>">

</head>
<body bgcolor="#EDD175">

<center><img src="render.php?size=40&display_home_team=<?=$team_id_home_current;?>" name="refresh"></center>
<script language="JavaScript" type="text/javascript">
      <!--
      var t = 10 // interval in seconds
      image = "render.php?size=40&display_home_team=<?=$team_id_home_current;?>" //name of the image
      function Start() {
      tmp = new Date();
      tmp = "&garbage="+tmp.getTime()
      document.images["refresh"].src = image+tmp
      setTimeout("Start()", t*1000)
      }
      Start();
      // -->
</script> 

<center><strong><font color="#3E6C3B"><?=getteaminfo($team_id_home_current, school);?> vs. <?=getteaminfo($team_id_away_current, school);?></font></strong></center>

<center><a target="_blank" href="http://www.thebus.ca"><img border="none" width="317" src="/images/transitad-video.png" alt="Sponsored by Charlottetown Transit Services. Please see their online interactive bus schedule map for more information." width="400" /></a></center>

</body>
</html>