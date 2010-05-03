<?php

	// This includes file checks to see if the various input forms for
	// the Panther Radio Listening Lounge have been submitted.

      // For information, contact Ryan Palmer (rypalmer@gmail.com)
      // Built July 2006 - by Ryan Palmer




// Get player info from player_id

function getplayerinfo($player_id_requested, $what_you_want)
{
$playerquery = "SELECT * FROM player WHERE player_id = $player_id_want";
$playerresult = mysql_query($playerquery) or die('Error, query failed. ' . mysql_error());
$playerrow     = mysql_fetch_array($playerresult, MYSQL_ASSOC);

if($what_you_requested == 'team_id')
{$output = $playerrow['team_id'];}

if($what_you_requested == 'player_name')
{$output = $playerrow['player_name'];}

if($what_you_requested == 'player_number')
{$output = $playerrow['player_number'];}

return $output;
}



// Get team info from team_id

function getteaminfo($team_id_requested, $what_you_want)
{
$teamquery = "SELECT * FROM team WHERE team_id = $team_id_requested";
$teamresult = mysql_query($teamquery) or die('Error, query failed. ' . mysql_error());
$teamrow     = mysql_fetch_array($teamresult, MYSQL_ASSOC);

if($what_you_want == 'school')
{$output = $teamrow['school'];}

if($what_you_want == 'arena_name')
{$output = $teamrow['arena_name'];}

if($what_you_want == 'team_img')
{$output = $teamrow['team_img'];}

if($what_you_want == 'game_type')
{$output = $teamrow['game_type'];}

return $output;
}


?>