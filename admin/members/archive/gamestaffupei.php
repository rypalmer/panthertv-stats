<?php
	include_once ("../auth.php");
	include_once ("../authconfig.php");
	include_once ("../check.php");

    if (($check['level'] < 101) || ($check['level'] > 108))
    {
        echo 'You are not allowed to access this page.';
		exit();
	}



    ?>

<?php

	// This is the business-end of the Interactive Listening Lounge for 
	// Panther Radio Game Staff

      // For information, contact Ryan Palmer (rypalmer@gmail.com)
      // Built July 2006 - by Ryan Palmer

// include the database configuration and
// open connection to database

include ("connect.php");


// Check all forms to see if anything has been submitted


include ("include.php");


if(isset($check['level']))
{

$team_editors = $check['level'] - 100;


// Specify the most recent game


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


	$query2   = "SELECT game_id FROM game WHERE team_id_home = '$team_editors' AND date < '$tenhourslater' ORDER BY game_id DESC LIMIT 1";

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


// Find the # of goals for each team

	//	Find the number of goals for the home team

	$query = "SELECT * FROM goal WHERE game_id = $game_id_current AND team_id = $team_id_home_current";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());

	$score_home = mysql_num_rows($result);

	//	Find the number of goals for the away team

	$query = "SELECT * FROM goal WHERE game_id = $game_id_current AND team_id = $team_id_away_current";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());

	$score_away = mysql_num_rows($result);



}

?>

<html>
<head>
<title>Panther Radio Listening Lounge 2.0 - Game Control</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css" media="all">@import "style.css";</style>

</head>
<body>

<div id="container">

<h1>Interactive Listening Lounge - Game Interface</h1>
<p align="right"><a onclick="MyWindow=window.open('http://stats.upeiism.org/index.php?display_home_team=<?=$team_editors;?>','MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=730,height=420'); return false;" href="#">Launch the Listener Window</a>
<br><a href="index.php">Return to the Team Admin page</a><br>
<a href="/admin/logout.php">Logout</a></p>

<table width="780" border="1" align="center">

<tr><td valign="top">Active Game: <strong>Game <?=$game_id_current;?> <br><?=$school_home_current;?> - <?=$score_home;?>
<br><?=$school_away_current;?> - <?=$score_away;?></strong>

<br><em><?=$game_date_current;?>, <?=$arena_name_home_current;?></em>
</td>
<td></td>
<td valign="top">

<center><a onclick="MyWindow=window.open('http://stats.upeiism.org/index.php?display_home_team=<?=$team_editors;?>','MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=730,height=420'); return false;" href="#">
<img border="0" src="http://stats.upeiism.org/rendersize.php?size=20&display_home_team=<?=$team_editors;?>"></a></center>



</td>
</tr>

<!--<tr><td width="48%"></td><td width="10"></td><td></td></tr>-->

<tr><td valign="top">

<?php

$query = "SELECT * FROM gameprogress WHERE game_id = $game_id_current ORDER BY gameprogress_id DESC LIMIT 1";
$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());

if(mysql_num_rows($result) == 0)
{
$period = "Pre-game";
$time = "";
$dashtime = "";
$selected1 = " SELECTED";
}
else
{
$row     = mysql_fetch_array($result, MYSQL_ASSOC);

$gameprogress_id = $row['gameprogress_id'];
$game_id = $row['game_id'];
$period = $row['period'];
$time = $row['time'];
$dashtime = " - " . $row['time'];
$penalty_light_home = $row['penalty_light_home'];
$penalty_light_away = $row['penalty_light_away'];


if ($period == '1')
{
$period = "Pre-game";
$time = "";
$dashtime = "";
$selected1 = " SELECTED";
}
if ($period == 2)
{
$period = "1st Period";
$selected2 = " SELECTED";
}
if ($period == 3)
{
$period = "1st Intermission";
$selected3 = " SELECTED";
}
if ($period == 4)
{
$period = "2nd Period";
$selected4 = " SELECTED";
}
if ($period == 5)
{
$period = "2nd Intermission";
$selected5 = " SELECTED";
}
if ($period == 6)
{
$period = "3rd Period";
$selected6 = " SELECTED";
}
if ($period == 7)
{
$period = "Overtime";
$selected7 = " SELECTED";
}
if ($period == 8)
{
$period = "Shoot-out";
$time = "";
$dashtime = "";
$selected8 = " SELECTED";
}
if ($period == 9)
{
$period = "Post-game";
$time = "";
$dashtime = "";
$selected9 = " SELECTED";
}


if($penalty_light_home == 1)
{
$penalty_position = "Home team: 1 current";
}

if($penalty_light_home == 2)
{
$penalty_position = "Home team: 2 current";
}

if($penalty_light_away == 1)
{
$penalty_position = $penalty_position . "  Away team: 1 current";
}

if($penalty_light_away == 2)
{
$penalty_position = $penalty_position . "  Away team: 2 current";
}

if($penalty_light_home == 0)
{
if($penalty_light_away == 0)
{
$penalty_position = "No penalties";
}
}


}


?>
<h2>Current Game Position</h2>
<?php

echo $period, $dashtime, "\n";
?>
<br><strong>Current Penalties: </strong><?=$penalty_position;?>

</td><td></td><td valign="top">


	<h2>Update Game Position</h2>
	
	<form method="post" name="gameposition">

	<input type="hidden" name="game_id" value="<?=$game_id_current;?>">

	<select name="period">
	<option value="1"<?=$selected1;?>>Pre-game</option>
	<option value="2"<?=$selected2;?>>1st Period</option>
	<option value="3"<?=$selected3;?>>1st Intermission</option>
	<option value="4"<?=$selected4;?>>2nd Period</option>
	<option value="5"<?=$selected5;?>>2nd Intermission</option>
	<option value="6"<?=$selected6;?>>3rd Period</option>
	<option value="7"<?=$selected7;?>>Overtime</option>
	<option value="8"<?=$selected8;?>>Shoot-out</option>
	<option value="9"<?=$selected9;?>>Post-game</option>
	</select>

	<select name="minutes">

<?php	$i = 0;
$timearray = explode(":", $time);

	while($i<20)
		{

		?><option value="<?=$i;?>"<?if($i == $timearray[0]){echo " SELECTED";}?>><?=$i;?></option><?
echo "\n";
		$i = $i + 1;

		}
		?>
	</select>
	<select name="seconds">
<?php	$i = 0;
	while($i<60)
		{

		?><option value="<?=$i;?>"<?if($i == $timearray[1]){echo " SELECTED";}?>><?=$i;?></option><?
echo "\n";
		$i = $i + 1;

		}
		?>
	</select>

<br />

Home Penalties:	<select name="penalty_light_home">
	<option value="0">No Penalties</option>
	<option value="1">1 Penalty</option>
	<option value="2">2 Penalties</option>
	</select>
<br />
Away Penalties:	<select name="penalty_light_away">
	<option value="0">No Penalties</option>
	<option value="1">1 Penalty</option>
	<option value="2">2 Penalties</option>
	</select>

<br />
	<input name="gameposition" type="submit" id="gameposition" value="Update the current game position">
    </form>

</td></tr>

<tr height="10"><td colspan="3"></td></tr>

<tr><td width="48%" valign="top">

<h2>Add <?=$school_home_current;?> Goal</h2>


	<form method="post" name="goal_home_insert">
 
Scoring player <select name="player_id"> 

 <?php
 $query = "SELECT * FROM player WHERE team_id = $team_id_home_current ORDER BY player_number ASC";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());
 	
	// if the team has no players set, show empty box
	if(mysql_num_rows($result) == 0)
	{
	?>
	<option value="">No players set for this team</option>
	<?php
	}
	else
	{

 		while ($row = mysql_fetch_array($result)) 
		{
		list($player_id, $team_id, $player_name, $player_number) = $row;
	
		?><option value="<?=$player_id;?>"> <?echo $player_number, " ", $player_name, "\n"; 
	
		}
	}


	?>
	</select><br>
Assisting player 1 <select name="player_id_assist1"> 

 <?php
 $query = "SELECT * FROM player WHERE team_id = $team_id_home_current ORDER BY player_number ASC";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());
 	
	// if the team has no players set, show empty box
	if(mysql_num_rows($result) == 0)
	{
	?>
	<option value="">No players set for this team</option>
	<?php
	}
	else
	{

 		while ($row = mysql_fetch_array($result)) 
		{
		list($player_id, $team_id, $player_name, $player_number) = $row;
	
		?><option value="<?=$player_id;?>"> <?echo $player_number, " ", $player_name, "\n"; 
	
		}
	}


	?>
	</select><br>
Assisting player 2<select name="player_id_assist2"> 

 <?php
 $query = "SELECT * FROM player WHERE team_id = $team_id_home_current ORDER BY player_number ASC";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());
 	
	// if the team has no players set, show empty box
	if(mysql_num_rows($result) == 0)
	{
	?>
	<option value="">No players set for this team</option>
	<?php
	}
	else
	{

 		while ($row = mysql_fetch_array($result)) 
		{
		list($player_id, $team_id, $player_name, $player_number) = $row;
	
		?><option value="<?=$player_id;?>"> <?echo $player_number, " ", $player_name, "\n"; 
	
		}
	}


	?>
	</select>
<br />	Type: <select name="goal_type">
	<option value="0">Normal</option>
	<option value="1">Short-handed</option>
	<option value="2">Double short-handed</option>
	<option value="3">Power-play</option>
	<option value="4">Shootout</option>
	</select>
 
	<input type="hidden" name="game_id" value="<?=$game_id_current;?>" >
	<input type="hidden" name="team_id" value="<?=$team_id_home_current;?>" ><br />
	Period: <select name="period">
	<option value="2"<?=$selected2;?>>1st Period</option>
	<option value="4"<?=$selected4;?>>2nd Period</option>
	<option value="6"<?=$selected6;?>>3rd Period</option>
	<option value="7"<?=$selected7;?>>Overtime</option>
	<option value="8"<?=$selected8;?>>Shootout</option>
	</select><br />
	Time of the goal: <input type="text" name="time" size="10" value="<?=$time;?>">


	<br />
	<input name="goal_home_insert" type="submit" id="goal_home_insert" value="Add the Home Goal">
    </form>

</td>

<td width="10"></td>

<td valign="top">

<h2>Add <?=$school_away_current;?> Goal</h2>

	<form method="post" name="goal_away_insert">
 
Scoring player <select name="player_id"> 

 <?php
 $query = "SELECT * FROM player WHERE team_id = $team_id_away_current ORDER BY player_number ASC";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());

	// if the team has no players set, show empty box
	if(mysql_num_rows($result) == 0)
	{
	?>
	<option value="">No players set for this team</option>
	<?php
	}
	else
	{

 		while ($row = mysql_fetch_array($result)) 
		{
		list($player_id, $team_id, $player_name, $player_number) = $row;
	
		?><option value="<?=$player_id;?>"> <?echo $player_number, " ", $player_name, "\n"; 
	
		}
	}
	?>
	</select><br>
 
Assisting player 1 <select name="player_id_assist1"> 

 <?php
 $query = "SELECT * FROM player WHERE team_id = $team_id_away_current ORDER BY player_number ASC";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());
 	
	// if the team has no players set, show empty box
	if(mysql_num_rows($result) == 0)
	{
	?>
	<option value="">No players set for this team</option>
	<?php
	}
	else
	{

 		while ($row = mysql_fetch_array($result)) 
		{
		list($player_id, $team_id, $player_name, $player_number) = $row;
	
		?><option value="<?=$player_id;?>"> <?echo $player_number, " ", $player_name, "\n"; 
	
		}
	}


	?>
	</select><br>
Assisting player 2<select name="player_id_assist2"> 

 <?php
 $query = "SELECT * FROM player WHERE team_id = $team_id_away_current ORDER BY player_number ASC";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());
 	
	// if the team has no players set, show empty box
	if(mysql_num_rows($result) == 0)
	{
	?>
	<option value="">No players set for this team</option>
	<?php
	}
	else
	{

 		while ($row = mysql_fetch_array($result)) 
		{
		list($player_id, $team_id, $player_name, $player_number) = $row;
	
		?><option value="<?=$player_id;?>"> <?echo $player_number, " ", $player_name, "\n"; 
	
		}
	}


	?>
	</select>
<br />
	Type: <select name="goal_type">
	<option value="0">Normal</option>
	<option value="1">Short-handed</option>
	<option value="2">Double short-handed</option>
	<option value="3">Power-play</option>
	<option value="4">Shootout</option>
	</select>

	<input type="hidden" name="game_id" value="<?=$game_id_current;?>" >
	<input type="hidden" name="team_id" value="<?=$team_id_away_current;?>" ><br />
	Period: <select name="period">
	<option value="2"<?=$selected2;?>>1st Period</option>
	<option value="4"<?=$selected4;?>>2nd Period</option>
	<option value="6"<?=$selected6;?>>3rd Period</option>
	<option value="7"<?=$selected7;?>>Overtime</option>
	<option value="8"<?=$selected8;?>>Shootout</option>
	</select><br />



	Time of the goal: <input type="text" name="time" size="10" value="<?=$time;?>">


	<br />
	<input name="goal_away_insert" type="submit" id="goal_away_insert" value="Add the Away Goal">
    </form>


</td></tr>
<tr height="10"><td colspan="3"></td></tr>
<tr>
<td valign="top" colspan="3">

<h2>Goals</h2>
 <?php $query = "SELECT * FROM goal WHERE game_id = $game_id_current ORDER BY goal_id ASC";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());
 	
	// if the team has no players set, show empty box
	if(mysql_num_rows($result) == 0)
	{
	?>
<strong>No goals have been scored.</strong>
	<?php
	}
	else
	{
?><table width="100%" border="1">
 	<?	while ($row = mysql_fetch_array($result)) 
		{
		list($goal_id, $game_id, $team_id, $player_id, $player_id_assist1, $player_id_assist2, $goal_time, $period, $goal_type) = $row;
if ($period == 2)
{
$period = "P1";
}
if ($period == 4)
{
$period = "P2";
}
if ($period == 6)
{
$period = "P3";
}
if ($period == 7)
{
$period = "OT";
}
if ($period == 8)
{
$period = "SO";
}
	$playerquery = "SELECT player_name, player_number FROM player WHERE player_id = $player_id";

	$playerresult = mysql_query($playerquery) or die('Error, query failed. ' . mysql_error());
	$playerrow     = mysql_fetch_array($playerresult, MYSQL_ASSOC);

	$player_name = $playerrow['player_name'];
	$player_number = $playerrow['player_number'];

	$playerquery2 = "SELECT player_name, player_number FROM player WHERE player_id = $player_id_assist1";

	$playerresult2 = mysql_query($playerquery2) or die('Error, query failed. ' . mysql_error());
	$playerrow2     = mysql_fetch_array($playerresult2, MYSQL_ASSOC);

	$player_name_assist1 = $playerrow2['player_name'];
	$player_number_assist1 = $playerrow2['player_number'];

	$playerquery3 = "SELECT player_name, player_number FROM player WHERE player_id = $player_id_assist2";

	$playerresult3 = mysql_query($playerquery3) or die('Error, query failed. ' . mysql_error());
	$playerrow3     = mysql_fetch_array($playerresult3, MYSQL_ASSOC);

	$player_name_assist2 = $playerrow3['player_name'];
	$player_number_assist2 = $playerrow3['player_number'];

	$goal_time_exploded = explode(":", $goal_time);

if ($goal_type == 0)
{
$goal_type = "";
}
if ($goal_type == 1)
{
$goal_type = ", short-handed";
}
if ($goal_type == 2)
{
$goal_type = ", double short-handed";
}
if ($goal_type == 3)
{
$goal_type = ", powerplay";
}
if ($goal_type == 4)
{
$goal_type = ", shootout";
}


	?><tr><td width="100"><? echo $period, " &nbsp;&nbsp;", $goal_time_exploded[0], ":", $goal_time_exploded[1];?>
</td><td width="170">
<? if($team_id == $team_id_home_current)
{

	$teamquery = "SELECT school FROM team WHERE team_id = $team_id_home_current";

	$teamresult = mysql_query($teamquery) or die('Error, query failed. ' . mysql_error());
	$teamrow     = mysql_fetch_array($teamresult, MYSQL_ASSOC);

	$goal_school = $teamrow['school'];

echo "$goal_school (Home)";
} 
else 
{
	$teamquery = "SELECT school FROM team WHERE team_id = $team_id_away_current";

	$teamresult = mysql_query($teamquery) or die('Error, query failed. ' . mysql_error());
	$teamrow     = mysql_fetch_array($teamresult, MYSQL_ASSOC);

	$goal_school = $teamrow['school'];

echo "$goal_school (Away)";
}
?>
</td><td>
<? echo $player_number, " ", $player_name, " assisted by ", $player_number_assist1, " and ", $player_number_assist1, $goal_type;
?></td></tr>
<? 
echo "\n"; 
	
		}
?></table><?
	}


	?>



<!--
<h2>Add <?=$school_home_current;?> Penalty</h2>
	<form method="post" name="penalty_home_insert">
Offending player <select name="player_id"> 

 <?php
 $query = "SELECT * FROM player WHERE team_id = $team_id_home_current ORDER BY player_number ASC";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());
 	
	// if the team has no players set, show empty box
	if(mysql_num_rows($result) == 0)
	{
	?>
	<option value="">No players set for this team</option>
	<?php
	}
	else
	{

 		while ($row = mysql_fetch_array($result)) 
		{
		list($player_id, $team_id, $player_name, $player_number) = $row;
	
		?><option value="<?=$player_id;?>"> <?echo $player_number, " ", $player_name, "\n"; 
	
		}
	}


	?>
	</select>

<br>Penalty type <select name="penalty_type">
<option value="1">Attempt to injure</option>
<option value="2">Boarding</option>
<option value="3">Butt-ending (or Stabbing)</option>
<option value="4">Charging</option>
<option value="5">Checking from behind</option>
<option value="6">Clipping</option>
<option value="7">Cross-checking</option>
<option value="8">Delaying the game</option>
<option value="9">Elbowing</option>
<option value="10">Fighting</option>
<option value="11">Goaltender Interference</option>
<option value="12">Head-butting</option>
<option value="13">High sticking</option>
<option value="14">Holding</option>
<option value="15">Hooking</option>
<option value="16">Illegal Equipment</option>
<option value="17">Interference</option>
<option value="18">Kneeing</option>
<option value="19">Roughing</option>
<option value="20">Slashing</option>
<option value="21">Spearing</option>
<option value="22">Too many men on the ice</option>
<option value="23">Tripping</option>
<option value="24">Unsportsmanlike conduct</option>
</select>

	<br>Period: <select name="period">
	<option value="2">1st Period</option>
	<option value="4">2nd Period</option>
	<option value="6">3rd Period</option>
	<option value="7">Overtime</option>
	</select><br />

	Time of the penalty: <input type="text" name="time" size="10" value="<?=$time;?>">

	<input type="hidden" name="game_id" value="<?=$game_id_current;?>" >
	<input type="hidden" name="team_id" value="<?=$team_id_home_current;?>" >
	<input name="penalty_home_insert" type="submit" id="penalty_home_insert" value="Add the Home Penalty">
    </form> 





</td><td></td>
<td valign="top">

<h2>Add <?=$school_away_current;?> Penalty</h2>
	<form method="post" name="penalty_away_insert">
Offending player <select name="player_id"> 

 <?php
 $query = "SELECT * FROM player WHERE team_id = $team_id_away_current ORDER BY player_number ASC";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());
 	
	// if the team has no players set, show empty box
	if(mysql_num_rows($result) == 0)
	{
	?>
	<option value="">No players set for this team</option>
	<?php
	}
	else
	{

 		while ($row = mysql_fetch_array($result)) 
		{
		list($player_id, $team_id, $player_name, $player_number) = $row;
	
		?><option value="<?=$player_id;?>"> <?echo $player_number, " ", $player_name, "\n"; 
	
		}
	}


	?>
	</select>

<br>Penalty type <select name="penalty_type">
<option value="1">Attempt to injure</option>
<option value="2">Boarding</option>
<option value="3">Butt-ending (or Stabbing)</option>
<option value="4">Charging</option>
<option value="5">Checking from behind</option>
<option value="6">Clipping</option>
<option value="7">Cross-checking</option>
<option value="8">Delaying the game</option>
<option value="9">Elbowing</option>
<option value="10">Fighting</option>
<option value="11">Goaltender Interference</option>
<option value="12">Head-butting</option>
<option value="13">High sticking</option>
<option value="14">Holding</option>
<option value="15">Hooking</option>
<option value="16">Illegal Equipment</option>
<option value="17">Interference</option>
<option value="18">Kneeing</option>
<option value="19">Roughing</option>
<option value="20">Slashing</option>
<option value="21">Spearing</option>
<option value="22">Too many men on the ice</option>
<option value="23">Tripping</option>
<option value="24">Unsportsmanlike conduct</option>
</select>

	<br>Period: <select name="period">
	<option value="2">1st Period</option>
	<option value="4">2nd Period</option>
	<option value="6">3rd Period</option>
	<option value="7">Overtime</option>
	</select><br />

	Time of the penalty: <input type="text" name="time" size="10" value="<?=$time;?>">

	<input type="hidden" name="game_id" value="<?=$game_id_current;?>" >
	<input type="hidden" name="team_id" value="<?=$team_id_away_current;?>" >
	<input name="penalty_away_insert" type="submit" id="penalty_away_insert" value="Add the Away Penalty">
    </form> 

-->
</td>




<tr height="10">
<td colspan="3">
</td></tr>
</table>

<h2>Recent fan comments</h2>

<table width="760" align="center" border="0">
<?php

// ================================
// Show comments made by fans
// ================================

// how many guestbook entries to show per page
$rowsPerPage = 10;

// by default we show first page
$pageNum = 1;

// if $_GET['page'] defined, use the value as page number
if(isset($_GET['page']))
{
    $pageNum = $_GET['page'];
}

// counting the offset ( where to start fetching the entries )
$offset = ($pageNum - 1) * $rowsPerPage;

// prepare the query string
$query = "SELECT * FROM comment WHERE game_id = $game_id_current ORDER BY comment_id DESC LIMIT $offset, $rowsPerPage";
$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());

// if the guestbook is empty show a message
if(mysql_num_rows($result) == 0)
{
?>
<tr><td colspan="3">
 No comments have been posted for this game. </td></tr>
<?php
}
else
{
    // get all guestbook entries
    while($row = mysql_fetch_array($result))
    {
        // list() is a convenient way of assign a list of variables
        // from an array values 
        list($comment_id, $game_id, $name, $email, $subject, $message, $date) = $row;

        // change all HTML special characters,
        // to prevent some nasty code injection
        $name    = htmlspecialchars($name);
        $subject = htmlspecialchars($subject);        
        $message = htmlspecialchars($message);        

        // convert newline characters ( \n OR \r OR both ) to HTML break tag ( <br> )
        $message = nl2br($message);
?>

 <tr height="10"><td colspan="3"></td></tr>
 <tr> 
  <td width="80" align="left" bgcolor="#EBED53"><p class="small">Name:</p></td>
  <td bgcolor="#EBED53"><a href="mailto:<?=$email;?>" class="email"> 
   <p><?=$name;?></p>
   </a> </td>
  <td align="right" bgcolor="#EBED53"> 
  <p class="small">Submitted:  <?=$date;?></p>
  </td>
 </tr>
 <tr> 
  <td bgcolor="#EBED53"> 
   <p class="small">Subject:</font> </td>
  <td colspan="3" bgcolor="#EBED53"> <p><?=$subject;?>&nbsp;</p></td>
 </tr>
 <tr> 
  <td bgcolor="#EBED53"> 
   <p class="small">Comment:</font> </td>
  <td colspan="3" bgcolor="#EBED53"> <p><?=$message;?>&nbsp;</p></td>
 </tr>

<?php
    } // end while

// below is the code needed to show page numbers

// count how many rows we have in database
$query   = "SELECT COUNT(comment_id) AS numrows FROM comment ";
$result  = mysql_query($query) or die('Error, query failed. ' . mysql_error());
$row     = mysql_fetch_array($result, MYSQL_ASSOC);
$numrows = $row['numrows'];

// how many pages we have when using paging?
$maxPage  = ceil($numrows/$rowsPerPage);
$nextLink = '';

// show the link to more pages ONLY IF there are 
// more than one page
if($maxPage > 1)
{
    // this page's path
    $self     = $_SERVER['PHP_SELF'];
    
    // we save each link in this array
    $nextLink = array();
    
    // create the link to browse from page 1 to page $maxPage
    for($page = 1; $page <= $maxPage; $page++)
    {
        $nextLink[] =  "<a href=?page=$page>$page</a>";
    }
    
    // join all the link using implode() 
    $nextLink = "Go to page : " . implode(' &raquo; ', $nextLink);
}

}
?>

</table>
<br>
<br>
<br>
<center>&copy; 2006 - <a href="http://upeiism.org">UPEI Independent Student Media</a></center>
</div>

</body>
</html>

