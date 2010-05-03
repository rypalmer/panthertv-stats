<?php

	// This includes file checks to see if the various input forms for
	// the Panther Radio Listening Lounge have been submitted.

      // For information, contact Ryan Palmer (rypalmer@gmail.com)
      // Built July 2006 - by Ryan Palmer

	date_default_timezone_set('America/Halifax');

// check if the form is submitted
if(isset($_POST['gameinsert']))
	{
    	$team_id_home    = $_POST['team_id_home'];
    	$team_id_away    = $_POST['team_id_away'];
    	$date   = $_POST['date'];
    	$game_type   = $_POST['game_type'];
    
    	$query = "INSERT INTO game (team_id_home, team_id_away, date, game_type) " .
             "VALUES ('$team_id_home', '$team_id_away', '$date', '$game_type')";
    	mysql_query($query) or die('Error, query failed. ' . mysql_error());

	$gamequery = "SELECT game_id FROM game ORDER BY game_id DESC LIMIT 1";
	$gameresult = mysql_query($gamequery) or die('Error, query failed. ' . mysql_error());
	$gamerow     = mysql_fetch_array($gameresult, MYSQL_ASSOC);

	$game_id = $gamerow['game_id'];

	$type = "1";
	$datetime = date("Y-m-d G:i:s");
	$message = "Added game_id $game_id";

    	$eventquery = "INSERT INTO event (type, game_id, team_id, datetime, message) " .
             "VALUES ('$type', '$game_id', '$team_id', '$datetime', '$message')";
    	mysql_query($eventquery) or die('Error, query failed. ' . mysql_error());
    
    	header('Location: ' . $_SERVER['REQUEST_URI']);
    
    	exit;
	}



// check if the form is submitted
if(isset($_POST['teaminsert']))
	{
    	$school    = $_POST['school'];
    	$arena_name    = $_POST['arena_name'];
    	$team_img   = $_POST['team_img'];
    
    	$query = "INSERT INTO team (school, arena_name, team_img) " .
             "VALUES ('$school', '$arena_name', '$team_img')";
    	mysql_query($query) or die('Error, query failed. ' . mysql_error());

	$teamquery = "SELECT team_id, school FROM team ORDER BY team_id DESC LIMIT 1";

	$teamresult = mysql_query($teamquery) or die('Error, query failed. ' . mysql_error());
	$teamrow     = mysql_fetch_array($teamresult, MYSQL_ASSOC);

	$school = $teamrow['school'];
	$team_id = $teamrow['team_id'];

	$type = "2";
	$datetime = date("Y-m-d G:i:s");
	$message = "Added team $school";

    	$eventquery = "INSERT INTO event (type, game_id, team_id, datetime, message) " .
             "VALUES ('$type', '$game_id', '$team_id', '$datetime', '$message')";

    	mysql_query($eventquery) or die('Error, query failed. ' . mysql_error());

    
    	header('Location: ' . $_SERVER['REQUEST_URI']);
    
    	exit;
	}


// check if the form is submitted
if(isset($_POST['playerinsert']))
	{
    	$team_id    = $_POST['team_id'];
    	$player_name    = $_POST['player_name'];
    	$player_number   =  sprintf("%02d",$_POST['player_number']);
    
   	$query = "INSERT INTO player (team_id, player_name, player_number) " .
             "VALUES ('$team_id', '$player_name', '$player_number')";

    	mysql_query($query) or die('Error, query failed. ' . mysql_error());
    

	$type = "3";
	$datetime = date("Y-m-d G:i:s");
	$message = "Added player $player_number $player_name";

    	$eventquery = "INSERT INTO event (type, game_id, team_id, datetime, message) " .
             "VALUES ('$type', '$game_id', '$team_id', '$datetime', '$message')";

    	mysql_query($eventquery) or die('Error, query failed. ' . mysql_error());


    	header('Location: ' . $_SERVER['REQUEST_URI']);
    
    	exit;
	}


// check if the form is submitted
if(isset($_POST['goal_home_insert']))
	{
    	$game_id    = $_POST['game_id'];
    	$team_id    = $_POST['team_id'];
    	$player_id   = $_POST['player_id'];
    	$player_id_assist1   = $_POST['player_id_assist1'];
    	$player_id_assist2   = $_POST['player_id_assist2'];
	$time = $_POST['time'];
	$period = $_POST['period'];
	$goal_type = $_POST['goal_type'];
    
    	$query = "INSERT INTO goal (game_id, team_id, player_id, player_id_assist1, player_id_assist2, time, period, goal_type) " .
             "VALUES ('$game_id', '$team_id', '$player_id', '$player_id_assist1', '$player_id_assist2', '$time', '$period', '$goal_type')";

    	mysql_query($query) or die('Error, query failed. ' . mysql_error());

	$playerquery = "SELECT player_name, player_number FROM player WHERE player_id = $player_id";

	$playerresult = mysql_query($playerquery) or die('Error, query failed. ' . mysql_error());
	$playerrow     = mysql_fetch_array($playerresult, MYSQL_ASSOC);

	$player_name = $playerrow['player_name'];
	$player_number = $playerrow['player_number'];

	$type = "4";
	$datetime = date("Y-m-d G:i:s");

if ($goal_type == 0)
{
$goal_type = "";
}
if ($goal_type == 1)
{
$goal_type = "short-handed";
}
if ($goal_type == 2)
{
$goal_type = "double short-handed";
}
if ($goal_type == 3)
{
$goal_type = "powerplay";
}
if ($goal_type == 4)
{
$goal_type = "shootout";
}

if ($period == 1)
{
$period = "Pre-game";
$time = "";
}
if ($period == 2)
{
$period = "1st Period";
}
if ($period == 3)
{
$period = "1st Intermission";
}
if ($period == 4)
{
$period = "2nd Period";
}
if ($period == 5)
{
$period = "2nd Intermission";
}
if ($period == 6)
{
$period = "3rd Period";
}
if ($period == 7)
{
$period = "Overtime";
}
if ($period == 8)
{
$period = "Shoot-out";
$time = "";
}
if ($period == 9)
{
$period = "Post-game";
$time = "";
}

	$message = "Added home $goal_type goal by $player_number $player_name at $period $time";

    	$eventquery = "INSERT INTO event (type, game_id, team_id, datetime, message) " .
             "VALUES ('$type', '$game_id', '$team_id', '$datetime', '$message')";

    	mysql_query($eventquery) or die('Error, query failed. ' . mysql_error());
    
    	header('Location: ' . $_SERVER['REQUEST_URI']);
    
    	exit;
	}


// check if the form is submitted
if(isset($_POST['goal_away_insert']))
	{
    	$game_id    = $_POST['game_id'];
    	$team_id    = $_POST['team_id'];
    	$player_id   = $_POST['player_id'];
    	$player_id_assist1   = $_POST['player_id_assist1'];
    	$player_id_assist2   = $_POST['player_id_assist2'];
	$time = $_POST['time'];
	$period = $_POST['period'];
	$goal_type = $_POST['goal_type'];
    
    	$query = "INSERT INTO goal (game_id, team_id, player_id, player_id_assist1, player_id_assist2, time, period, goal_type) " .
             "VALUES ('$game_id', '$team_id', '$player_id', '$player_id_assist1', '$player_id_assist2', '$time', '$period', '$goal_type')";

    	mysql_query($query) or die('Error, query failed. ' . mysql_error());

	$playerquery = "SELECT player_name, player_number FROM player WHERE player_id = $player_id";

	$playerresult = mysql_query($playerquery) or die('Error, query failed. ' . mysql_error());
	$playerrow     = mysql_fetch_array($playerresult, MYSQL_ASSOC);

	$player_name = $playerrow['player_name'];
	$player_number = $playerrow['player_number'];

	$type = "4";
	$datetime = date("Y-m-d G:i:s");

if ($goal_type == 0)
{
$goal_type = "";
}
if ($goal_type == 1)
{
$goal_type = "short-handed";
}
if ($goal_type == 2)
{
$goal_type = "double short-handed";
}
if ($goal_type == 3)
{
$goal_type = "powerplay";
}
if ($goal_type == 4)
{
$goal_type = "shootout";
}


if ($period == 1)
{
$period = "Pre-game";
$time = "";
}
if ($period == 2)
{
$period = "1st Period";
}
if ($period == 3)
{
$period = "1st Intermission";
}
if ($period == 4)
{
$period = "2nd Period";
}
if ($period == 5)
{
$period = "2nd Intermission";
}
if ($period == 6)
{
$period = "3rd Period";
}
if ($period == 7)
{
$period = "Overtime";
}
if ($period == 8)
{
$period = "Shoot-out";
$time = "";
}
if ($period == 9)
{
$period = "Post-game";
$time = "";
}
	$message = "Added away $goal_type goal by $player_number $player_name at $period $time";

    	$eventquery = "INSERT INTO event (type, game_id, team_id, datetime, message) " .
             "VALUES ('$type', '$game_id', '$team_id', '$datetime', '$message')";

    	mysql_query($eventquery) or die('Error, query failed. ' . mysql_error());

    
    	header('Location: ' . $_SERVER['REQUEST_URI']);

    	exit;
	}


// check if the form is submitted
if(isset($_POST['gameposition']))
	{
    	// get the input from $_POST variable
    	$game_id    = $_POST['game_id'];
	$minutes    = sprintf("%02d",$_POST['minutes']);
	$seconds    = sprintf("%02d",$_POST['seconds']);
	$period   =  $_POST['period'];
	$penalty_light_home   =  $_POST['penalty_light_home'];
	$penalty_light_away   =  $_POST['penalty_light_away'];

	$time=$minutes . ":" . $seconds;

    	$query = "INSERT INTO gameprogress (game_id, period, time, penalty_light_home, penalty_light_away) " .
             "VALUES ('$game_id', '$period', '$time', '$penalty_light_home', '$penalty_light_away')";

    	mysql_query($query) or die('Error, query failed. ' . mysql_error());
     	header('Location: ' . $_SERVER['REQUEST_URI']);
     	exit;
	}

// check if the form is submitted
if(isset($_POST['penalty_home_insert']))
	{
    	$game_id    = $_POST['game_id'];
    	$team_id    = $_POST['team_id'];
    	$player_id   = $_POST['player_id'];
	$time = $_POST['time'];
	$period = $_POST['period'];
	$penalty_type = $_POST['penalty_type'];
    
    	$query = "INSERT INTO penalty (game_id, team_id, player_id, penalty_type, period, time) " .
             "VALUES ('$game_id', '$team_id', '$player_id', '$penalty_type', '$period', '$time')";

    	mysql_query($query) or die('Error, query failed. ' . mysql_error());
    
$playerquery = "SELECT player_name, player_number FROM player WHERE player_id = $player_id";

	$playerresult = mysql_query($playerquery) or die('Error, query failed. ' . mysql_error());
	$playerrow     = mysql_fetch_array($playerresult, MYSQL_ASSOC);

	$player_name = $playerrow['player_name'];
	$player_number = $playerrow['player_number'];

	$datetime = date("Y-m-d G:i:s");

if ($period == 1)
{
$period = "Pre-game";
$time = "";
}
if ($period == 2)
{
$period = "1st Period";
}
if ($period == 3)
{
$period = "1st Intermission";
}
if ($period == 4)
{
$period = "2nd Period";
}
if ($period == 5)
{
$period = "2nd Intermission";
}
if ($period == 6)
{
$period = "3rd Period";
}
if ($period == 7)
{
$period = "Overtime";
}
if ($period == 8)
{
$period = "Shoot-out";
$time = "";
}
if ($period == 9)
{
$period = "Post-game";
$time = "";
}
$type = "5";
	$message = "Added home penalty by $player_number $player_name at $period $time";

    	$eventquery = "INSERT INTO event (type, game_id, team_id, datetime, message) " .
             "VALUES ('$type', '$game_id', '$team_id', '$datetime', '$message')";

    	mysql_query($eventquery) or die('Error, query failed. ' . mysql_error());


    	header('Location: ' . $_SERVER['REQUEST_URI']);
    
    	exit;
	}

// check if the form is submitted
if(isset($_POST['penalty_away_insert']))
	{
    	$game_id    = $_POST['game_id'];
    	$team_id    = $_POST['team_id'];
    	$player_id   = $_POST['player_id'];
	$time = $_POST['time'];
	$period = $_POST['period'];
	$penalty_type = $_POST['penalty_type'];
    
    	$query = "INSERT INTO penalty (game_id, team_id, player_id, penalty_type, period, time) " .
             "VALUES ('$game_id', '$team_id', '$player_id', '$penalty_type', '$period', '$time')";

    	mysql_query($query) or die('Error, query failed. ' . mysql_error());
    
	$playerquery = "SELECT player_name, player_number FROM player WHERE player_id = $player_id";

	$playerresult = mysql_query($playerquery) or die('Error, query failed. ' . mysql_error());
	$playerrow     = mysql_fetch_array($playerresult, MYSQL_ASSOC);

	$player_name = $playerrow['player_name'];
	$player_number = $playerrow['player_number'];

if ($period == 1)
{
$period = "Pre-game";
$time = "";
}
if ($period == 2)
{
$period = "1st Period";
}
if ($period == 3)
{
$period = "1st Intermission";
}
if ($period == 4)
{
$period = "2nd Period";
}
if ($period == 5)
{
$period = "2nd Intermission";
}
if ($period == 6)
{
$period = "3rd Period";
}
if ($period == 7)
{
$period = "Overtime";
}
if ($period == 8)
{
$period = "Shoot-out";
$time = "";
}
if ($period == 9)
{
$period = "Post-game";
$time = "";
}

	$type = "5";
	$datetime = date("Y-m-d G:i:s");
	$message = "Added away penalty by $player_number $player_name at $period $time";

	$eventquery = "INSERT INTO event (type, game_id, team_id, datetime, message) " .
             "VALUES ('$type', '$game_id', '$team_id', '$datetime', '$message')";

    	mysql_query($eventquery) or die('Error, query failed. ' . mysql_error());


    	header('Location: ' . $_SERVER['REQUEST_URI']);
    
    	exit;
	}


// Specify the most recent game

	$query2   = "SELECT MAX(game_id) AS game_id_current FROM game";
	$result2  = mysql_query($query2) or die('Error, query failed. ' . mysql_error());
	$row2     = mysql_fetch_array($result2, MYSQL_ASSOC);

      $game_id_current = $row2['game_id_current'];

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

// check if the form is submitted
if(isset($_POST['btnSign']))
{
    // get the input from $_POST variable
    // trim all input to remove extra spaces
    $title    = trim($_POST['txtTitle']);
    $name    = trim($_POST['txtName']);
    $email   = trim($_POST['txtEmail']);
    $message = trim($_POST['mtxMessage']);
    $game_id = trim($_POST['game_id']);
    
    // escape the message ( if it's not already escaped )
    if(!get_magic_quotes_gpc())
    {
        $title    = addslashes($title);
        $name    = addslashes($name);
        $message = addslashes($message);
    }

	$date = date("Y-m-d G:i:s");

    // prepare the query string
    $query = "INSERT INTO comment (game_id, name, email, subject, message, date) " .
             "VALUES ('$game_id', '$name', '$email', '$title', '$message', '$date')";

    mysql_query($query) or die('Error, query failed. ' . mysql_error());

	$type = "6";
	$datetime = date("Y-m-d G:i:s");
	$message = "Added comment by $name to Game $game_id";

	$eventquery = "INSERT INTO event (type, game_id, team_id, datetime, message) " .
             "VALUES ('$type', '$game_id', '$team_id', '$datetime', '$message')";

    	mysql_query($eventquery) or die('Error, query failed. ' . mysql_error());

    
    // redirect to current page so if we click the refresh button 
    // the form won't be resubmitted ( as that would make duplicate entries )
    header('Location: ' . $_SERVER['REQUEST_URI']);
    
    // force to quite the script. if we don't call exit the script may
    // continue before the page is redirected
    exit;
}


if (isset($_GET[game]))
	{

	$game_id_current = $_GET[game];

	$query3   = "SELECT * FROM game WHERE game_id=$game_id_current";
	$result3  = mysql_query($query3) or die('Error, query failed. ' . mysql_error());
	$row3     = mysql_fetch_array($result3, MYSQL_ASSOC);

	}
	else
	{

	$query2   = "SELECT MAX(game_id) AS game_id_current FROM game";
$result2  = mysql_query($query2) or die('Error, query failed. ' . mysql_error());
$row2     = mysql_fetch_array($result2, MYSQL_ASSOC);

$game_id_current = $row2['game_id_current'];

$query3   = "SELECT * FROM game WHERE game_id=$game_id_current";
$result3  = mysql_query($query3) or die('Error, query failed. ' . mysql_error());
$row3     = mysql_fetch_array($result3, MYSQL_ASSOC);

	}

$team_id_home_current = $row3['team_id_home'];
$team_id_away_current = $row3['team_id_away'];
$game_date_current = $row3['date'];


?>