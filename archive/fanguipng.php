<?php

      // This is the scoreboard frame for the Panther Radio Listening Lounge
      // This page is not meant to be loaded by itself

      // For information, contact Ryan Palmer (rypalmer@gmail.com)
      // Built July 2006 - by Ryan Palmer

      // include the database configuration and
      // open connection to database

include ("connect.php");

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


	$query2   = "SELECT game_id FROM game WHERE team_id_home = '$display_home_team' AND date < '$tenhourslater' ORDER BY game_id DESC LIMIT 1";

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

	$query4   = "SELECT * FROM team WHERE team_id = $team_id_home_current LIMIT 1";
	$result4  = mysql_query($query4) or die('Error, query failed. ' . mysql_error());
	$row4     = mysql_fetch_array($result4, MYSQL_ASSOC);

	$school_home_current = $row4['school'];
	$arena_name_home_current = $row4['arena_name'];
	$team_img_home_current = $row4['team_img'];

	$query5   = "SELECT * FROM team WHERE team_id = $team_id_away_current LIMIT 1";
	$result5  = mysql_query($query5) or die('Error, query failed. ' . mysql_error());
	$row5     = mysql_fetch_array($result5, MYSQL_ASSOC);

	$school_away_current = $row5['school'];
	$arena_name_away_current = $row5['arena_name'];
	$team_img_away_current = $row5['team_img'];

$display_refresh = "?display_game_id=" . $game_id_current;

}












if(isset($_GET[display_game_id]))
{

$display_game_id = $_GET[display_game_id];
$display_refresh = "?display_game_id=" . $display_game_id;
//echo "display game id: ", $display_game_id;


	$game_id_current = $_GET[display_game_id];

	$query3   = "SELECT * FROM game WHERE game_id=$game_id_current";
	$result3  = mysql_query($query3) or die('Error, query failed. ' . mysql_error());
	$row3     = mysql_fetch_array($result3, MYSQL_ASSOC);

	$team_id_home_current = $row3['team_id_home'];
	$team_id_away_current = $row3['team_id_away'];
	$game_date_current = $row3['date'];

	$query4   = "SELECT * FROM team WHERE team_id = $team_id_home_current LIMIT 1";
	$result4  = mysql_query($query4) or die('Error, query failed. ' . mysql_error());
	$row4     = mysql_fetch_array($result4, MYSQL_ASSOC);

	$school_home_current = $row4['school'];
	$arena_name_home_current = $row4['arena_name'];
	$team_img_home_current = $row4['team_img'];

	$query5   = "SELECT * FROM team WHERE team_id = $team_id_away_current LIMIT 1";
	$result5  = mysql_query($query5) or die('Error, query failed. ' . mysql_error());
	$row5     = mysql_fetch_array($result5, MYSQL_ASSOC);

	$school_away_current = $row5['school'];
	$arena_name_away_current = $row5['arena_name'];
	$team_img_away_current = $row5['team_img'];

}

      // Set the refresh rate, in seconds
$refresh = 600;

	// Specify the most recent game
	// If its set as "game" in the address bar, use that instead



// Find the # of goals for each team

	//	Find the number of goals for the home team

	$query = "SELECT * FROM goal WHERE game_id = $game_id_current AND team_id = $team_id_home_current";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());

	$score_home = mysql_num_rows($result);

	//	Find the number of goals for the away team

	$query = "SELECT * FROM goal WHERE game_id = $game_id_current AND team_id = $team_id_away_current";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());

	$score_away = mysql_num_rows($result);


// Find the current game position

$query = "SELECT * FROM gameprogress WHERE game_id = $game_id_current ORDER BY gameprogress_id DESC LIMIT 1";
$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());

if(mysql_num_rows($result) == 0)
{
$period = "1";
}
else
{
$row     = mysql_fetch_array($result, MYSQL_ASSOC);


$gameprogress_id = $row['gameprogress_id'];
$game_id = $row['game_id'];
$period = $row['period'];
$time = $row['time'];

}

$periodheader = "PERIOD";

if ($period == 1)
{
$period = "";
$time = "20:00";
$periodheader = "PREGAME";
}
if ($period == 2)
{
$period = "1";
}
if ($period == 3)
{
$periodheader = "1ST INTERMISSION";
$time = "20:00";
$period = "";
}
if ($period == 4)
{
$period = "2";
}
if ($period == 5)
{
$periodheader = "2ND INTERMISSION";
$time = "20:00";
$period = "";
}
if ($period == 6)
{
$period = "3";
}
if ($period == 7)
{
$period = "";
$periodheader = "OVERTIME";
}
if ($period == 8)
{
$period = "";
$time = "00:00";
$periodheader = "SHOOTOUT";
}
if ($period == 9)
{
$period = "";
$time = "00:00";
$periodheader = "FINAL";
}


	// get team info for home and away teams

	$query4   = "SELECT * FROM team WHERE team_id = $team_id_home_current LIMIT 1";
	$result4  = mysql_query($query4) or die('Error, query failed. ' . mysql_error());
	$row4     = mysql_fetch_array($result4, MYSQL_ASSOC);

	$school_home_current = $row4['school'];
	$arena_name_home_current = $row4['arena_name'];
	$team_img_home_current = $row4['team_img'];

	$query5   = "SELECT * FROM team WHERE team_id = $team_id_away_current LIMIT 1";
	$result5  = mysql_query($query5) or die('Error, query failed. ' . mysql_error());
	$row5     = mysql_fetch_array($result5, MYSQL_ASSOC);

	$school_away_current = $row5['school'];
	$arena_name_away_current = $row5['arena_name'];
	$team_img_away_current = $row5['team_img'];

?>

<html>
<head>
<title>Panther Radio Interactive Listening Lounge - Powered By Newradio.ca</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<meta http-equiv="Refresh" content="<?=$refresh;?>; URL=fanguipng.php<?=$display_refresh;?>">

</head>
<body bgcolor="#EDD175">



<!--
<h2>Team Rosters</h2>

<h2>Scoreboard</h2>
- score
- estimated time
- period
- penalties listing


-->

<!--

Time: <font size="11" color="#FFE400" face="helvetica, georgia, courier, arial"><center><?=$time;?></center></font>
Score Home: <font size="9" color="#FFE400" face="helvetica, georgia, courier, arial"><center><?=$score_home;?></center></font>
Score Away: <font size="9" color="#FFE400" face="helvetica, georgia, courier, arial"><center><?=$score_away;?></center></font>
Period header: <font size="2" color="#FFFFFF" face="helvetica, georgia, courier, arial"><center><?=$periodheader;?></center></font>
Period number: <font size="6" color="#00BE00" face="helvetica, georgia, courier, arial"><center><?=$period;?></center></font>

-->


<center><img src="rendersize.php?size=50&display_home_team=<?=$team_id_home_current;?>" name="refresh"></center>
<script language="JavaScript" type="text/javascript">
      <!--
      var t = 12 // interval in seconds
      image = "rendersize.php?size=50&display_home_team=<?=$team_id_home_current;?>" //name of the image
      function Start() {
      tmp = new Date();
      tmp = "?"+tmp.getTime()
      document.images["refresh"].src = image+tmp
      setTimeout("Start()", t*1000)
      }
      Start();
      // -->
</script> 








<center><strong><font color="#3E6C3B"><?=$school_home_current;?> vs. <?=$school_away_current;?></font></strong></center>

<?

if(isset($_GET[ad_id_current]))
{
$restrict_team = "AND ad_id != $GET_[ad_id_current]";
}

$query = "select * from ad WHERE status = 1 AND team_id = $team_id_home_current OR team_id = $team_id_away_current $restrict_team ORDER BY rand() limit 1";
// echo $query;
$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());

if(mysql_num_rows($result) == 0)
{
?>No ads are available.<?
}
else
{
$row     = mysql_fetch_array($result, MYSQL_ASSOC);

$ad_id = $row['ad_id'];
$sponsor = $row['sponsor'];
$img_src = $row['img_src'];

?><center><img src="<?=$img_src;?>" alt="Sponsored by <?=$sponsor;?>" width="399" /></center><?

}




	// Close the database connection

	mysql_close();

	?>

</body>
</html>