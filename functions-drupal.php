<?php

/* This includes file checks to see if the various input forms for
 * the Panther Radio Listening Lounge have been submitted.
 *
 * For information, contact Ryan Palmer (rypalmer@gmail.com)
 * Updated September 2007 - by Ryan Palmer
*/


function get_game_id($request, $team = '') {
  $fivehourslater = time() + (60 * 60 * 5);
  $fivehoursbefore = time() - (60 * 60 * 7);
  switch ($request) {
  case 'current':
    $query = "SELECT n.nid FROM `node` AS n, content_type_game AS ctg where ((ctg.vid = n.vid) AND (n.type = 'game') AND ctg.field_date_value < $fivehourslater) AND (ctg.field_date_value > $fivehoursbefore) AND (n.status = 1) order by ctg.field_date_value ASC LIMIT 1";
    break;
  case 'home':
    $query = "SELECT 'node.nid' FROM `node` where ((`content_type_game.vid` = `node.vid`) AND (n.status = 1) AND (`node.type` = 'game') AND (content_type_game.field_date_value < $fivehourslater) AND (content_type_game.field_home_team_nid = $team)) order by content_type_game.field_date_value desc limit 1";
    break;
  case 'away':
    $query = "SELECT 'node.nid' FROM `node` where ((`content_type_game.vid` = `node.vid`) AND (`node.type` = 'game') AND (content_type_game.field_date_value < $fivehourslater) AND (content_type_game.field_visiting_team_nid = $team)) order by content_type_game.field_date_value desc limit 1";
    break;
  }

  //run the query
  $result = mysql_query($query) or die('Error, query failed. ' . mysql_error());
  $row = mysql_fetch_array($result, MYSQL_ASSOC);
  return $row[nid];
}

function load_game_info($game_id) {
if (!isset($game_id)) { return; }

  $query = "SELECT * FROM node AS n, content_type_game AS ctg, content_field_gender AS cfg, content_field_sport AS cfs WHERE ((ctg.vid = n.vid) AND (cfg.vid = n.vid) AND (cfs.vid = n.vid) AND (n.nid = $game_id)) order by ctg.vid desc 
limit 1";
  $result = mysql_query($query) or die('Error, query failed. ' . mysql_error());
  $row = mysql_fetch_array($result, MYSQL_ASSOC);
  $game = $row;
  // Process fields to make them look pretty
  $game['time'] = $game['field_game_progress_mins_value'] .':'. $game['field_game_progress_secs_value'];

// Set the $game['period']
  switch ($game['field_game_progress_period_value']) {
case '':
    $game['period'] = 'PREGAME';
    break;
case 'pre':
    $game['period'] = 'PREGAME';
    break;
case '1st':
    $game['period'] = '1st PERIOD';
    break;
case '1sthalf':
    $game['period'] = '1st HALF';
    break;
case '1stint':
    $game['period'] = '1st INT.';
    $game['time'] = '20:00';
    break;
case '2nd':
    $game['period'] = '2nd PERIOD';
    break;
case '2ndhalf':
    $game['period'] = '2nd HALF';
    break;
case '2ndint':
    $game['period'] = '2nd INT.';
    $game['time'] = '20:00';
    break;
case 'halftime':
    $game['period'] = 'HALFTIME';
    $game['time'] = '45:00';
    break;
case '3rd':
    $game['period'] = '3rd PERIOD';
    break;
case 'over':
    $game['period'] = 'OVERTIME';
    break;
case 'shoot':
    $game['period'] = 'SHOOT-OUT';
    break;
case 'post':
    $game['period'] = 'FINAL';
    $game['time'] = '00:00';
    break;
}

  // Fill in team info
  $game['home_team_name'] = get_team_info($game['field_home_team_nid'], 'school');
  $game['away_team_name'] = get_team_info($game['field_visiting_team_nid'], 'school');

  // Fix up the gender one-letter
switch ($game['field_gender_value']) {
  case 'male':
    $game['gender'] = "M";
  break;
  case 'female':
    $game['gender'] = "W";
  break;
}

// Is this on air or not?
if ($game['field_game_progress_period_value'] == 'post' || $game['field_game_progress_period_value'] == '') {
$game['onair'] = 'no';
}
else {
$game['onair'] = 'yes';
}

  return $game;
}




// Get player info from player_id

//function getplayerinfo($player_id_requested, $what_you_want)
//{
//$playerquery = "SELECT * FROM node, content_type_player WHERE (nid = $player_id_want";
//$playerresult = mysql_query($playerquery) or die('Error, query failed. ' . mysql_error());
//$playerrow     = mysql_fetch_array($playerresult, MYSQL_ASSOC);

//if($what_you_requested == 'team_id')
//{$output = $playerrow['team_id'];}

//if($what_you_requested == 'player_name')
//{$output = $playerrow['player_name'];}

//if($what_you_requested == 'player_number')
//{$output = $playerrow['player_number'];}

//return $output;
//}



// Get team info from team_id

function get_team_info($team_id_requested, $what_you_want)
{
  $teamquery = "SELECT * FROM node AS n, content_type_team AS ctt WHERE ((n.nid = $team_id_requested) AND (n.vid = ctt.vid)) ORDER BY n.vid DESC LIMIT 1";
  $teamresult = mysql_query($teamquery) or die('Error, query failed. ' . mysql_error());
  $teamrow     = mysql_fetch_array($teamresult, MYSQL_ASSOC);

  if($what_you_want == 'school')
  {
  $output = $teamrow['title'];}

//if($what_you_want == 'arena_name')
//{$output = $teamrow['arena_name'];}

//if($what_you_want == 'team_img')
//{$output = $teamrow['team_img'];}

//if($what_you_want == 'game_type')
//{$output = $teamrow['game_type'];}

  return $output;
}


?>
