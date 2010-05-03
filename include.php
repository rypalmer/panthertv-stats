<?php

	// This includes file checks to see if the various input forms for
	// the Panther Radio Listening Lounge have been submitted.

      // For information, contact Ryan Palmer (rypalmer@gmail.com)
      // Built July 2006 - by Ryan Palmer

	date_default_timezone_set('America/Halifax');



// Specify the active game

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