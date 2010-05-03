<?php
      // For information, contact Ryan Palmer (rypalmer@gmail.com)
      // Built Summer 2006 - by Ryan Palmer

      // include the database configuration and
      // open connection to database

include ("connect-drupal.php");
//include ("include.php");
include ("functions-drupal.php");

if (!isset($_GET[display_game_id])) {
  if (isset($_GET[display_home_team])) {
    $current_game_id = get_game_id('home', $_GET[display_home_team]); }
  elseif (isset($_GET[display_away_team])) {
    $current_game_id = get_game_id('away', $_GET[display_away_team]); }
  else {
    $current_game_id = get_game_id('current');
  }
} else {
$current_game_id = $_GET[display_game_id];
}

// load info on game, teams, etc

$current_game = load_game_info($current_game_id);

//print_r($current_game);
//exit();
// Everything is good to here

// Start the image generation

// File and new size
$filename = 'images/render-mini-bg.png';

if(isset($_GET[size])) {
  $percent = $_GET[size]/100;
  if($percent > '1.50') {
    $percent = '1.5';}
  } else {
$percent = 1;}


// Get new sizes
list($width, $height) = getimagesize($filename);
$newwidth = $width * $percent;
$newheight = $height * $percent;

// Load
$im = imagecreatetruecolor($newwidth, $newheight);
$source = imagecreatefrompng($filename);

// Resize
// imagecopyresized($im, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
imagecopyresampled($im, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

if (!isset($current_game_id)) {

// Output

header("Content-type: image/png");

imagepng($im);

imagedestroy($im);

mysql_close();



// "There is no game to display";
//exit();
}




$colourtime = imagecolorallocate($im, 106, 105, 105);
$colourgoal = imagecolorallocate($im, 255, 228, 0);
$colourperiod = imagecolorallocate($im, 0, 190, 0);
$colourwhite = imagecolorallocate($im, 255, 255, 255);
$colourblack = imagecolorallocate($im, 0, 0, 0);
$colourgrey = imagecolorallocate($im, 0, 0, 0);

$arial = 'arialbd.ttf';
// Place the time
$pos1x = $newwidth * 0.482;
$pos1y = $newheight * 0.573;
$fsize1 = $percent * 9;

$pos2x = $newwidth * 0.84;
$pos2y = $newheight * 0.73;
$fsize2 = $percent * 13;

$pos3x = $newwidth * 0.84;
$pos3y = $newheight * 0.89;
$fsize3 = $percent * 13;

$periodheader = "PERIOD";

switch ($current_game['field_game_progress_period_value']) {
  case 'pre':
    $pos4x = $newwidth * 0.385;
    $pos4y = $newheight * 0.69;
    $fsize4 = $percent * 27;
  break;
  case '1st':
    $pos4x = $newwidth * 0.41;
    $pos4y = $newheight * 0.69;
    $fsize4 = $percent * 6;
  break;
  case '1sthalf':
    $pos4x = $newwidth * 0.41;
    $pos4y = $newheight * 0.69;
    $fsize4 = $percent * 6;
  break;
  case '2nd':
    $pos4x = $newwidth * 0.41;
    $pos4y = $newheight * 0.69;
    $fsize4 = $percent * 6;
  break;
  case '2ndhalf':
    $pos4x = $newwidth * 0.41;
    $pos4y = $newheight * 0.69;
    $fsize4 = $percent * 6;
  break;
  case '3rd':
    $pos4x = $newwidth * 0.41;
    $pos4y = $newheight * 0.69;
    $fsize4 = $percent * 6;
  break;
  case '1stint':
    $pos4x = $newwidth * 0.41;
    $pos4y = $newheight * 0.69;
    $fsize4 = $percent * 6;
  break;
  case 'halftime':
    $pos4x = $newwidth * 0.41;
    $pos4y = $newheight * 0.69;
    $fsize4 = $percent * 6;
  break;
  case '2ndint':
    $pos4x = $newwidth * 0.41;
    $pos4y = $newheight * 0.69;
    $fsize4 = $percent * 6;
  break;
  case 'over':
    $pos4x = $newwidth * 0.41;
    $pos4y = $newheight * 0.69;
    $fsize4 = $percent * 6;
    break;
  case 'post':
    $pos4x = $newwidth * 0.41;
    $pos4y = $newheight * 0.69;
    $fsize4 = $percent * 6;
  break;
  case 'shootout':
    $pos4x = $newwidth * 0.41;
    $pos4y = $newheight * 0.69;
    $fsize4 = $percent * 6;
  break;
//  case 'final':
  //  $pos4x = $newwidth * 0.41;
    //$pos4y = $newheight * 0.573;
   // $fsize4 = $percent * 9;
 // break;
}

// Place the period text
$pos5x = $newwidth * 0.64;
$pos5y = $newheight * 0.573;
$fsize5 = $percent * 9;

// Place the team names
$pos6x = $newwidth * 0.09;
$pos6y = $pos2y;
$fsize6 = $fsize2; //$percent * 12;

$pos7x = $newwidth * 0.09;
$pos7y = $pos3y;
$fsize7 = $fsize6;

//Place the Gender M or F
$pos8x = $newwidth * 0.16;
$pos8y = $newheight * 0.366;
$fsize8 = $percent * 24;

// echo $periodheader, " ", $pos4x, " ", $pos4y, " ", $fsize4;

imagettftext($im, $fsize1, 0, $pos1x, $pos1y, $colourtime, $arial, $current_game['time']); 
imagettftext($im, $fsize2, 0, $pos2x, $pos2y, $colourblack, $arial, $current_game['field_home_score_value']); 
imagettftext($im, $fsize3, 0, $pos3x, $pos3y, $colourblack, $arial, $current_game['field_visiting_score_value']); 
//imagettftext($im, $fsize4, 0, $pos4x, $pos4y, $colourtime, $arial, $current_game['period']); 
imagettftext($im, $fsize5, 0, $pos5x, $pos5y, $colourtime, $arial, $current_game['period']); 

// Team names

imagettftext($im, $fsize6, 0, $pos6x, $pos6y, $colourblack, $arial, $current_game['home_team_name']);
imagettftext($im, $fsize7, 0, $pos7x, $pos7y, $colourblack, $arial, $current_game['away_team_name']);

// Overlay the ON AIR and Click to listen or watch text
if($current_game['onair'] == 'yes') {
  // overlay images/on-air-overlay1.png
  // overlay images/on-air-overlay1.png

list($oao1width, $oao1height) = getimagesize('images/on-air-overlay1.png');
$oao1_source = imagecreatefrompng('images/on-air-overlay1.png');
$oao1newwidth = $oao1width * $percent;
$oao1newheight = $oao1height * $percent;
$oao1_resized = imagecreatetruecolor($oao1newwidth, $oao1newheight);
imagecopyresized($oao1_resized, $oao1_source, 0, 0, 0, 0, $oao1newwidth, $oao1newheight, $oao1width, $oao1height);
$oao1posx = 0.365899 * $newwidth;
$oao1posy = 0.00 * $newheight;
imagecopymerge($im, $oao1_resized, $oao1posx, $oao1posy, 0, 0, $oao1newwidth, $oao1newheight, 100);

list($oao2width, $oao2height) = getimagesize('images/on-air-overlay2.png');
$oao2_source = imagecreatefrompng('images/on-air-overlay2.png');
$oao2newwidth = $oao2width * $percent;
$oao2newheight = $oao2height * $percent;
$oao2_resized = imagecreatetruecolor($oao2newwidth, $oao2newheight);
imagecopyresized($oao2_resized, $oao2_source, 0, 0, 0, 0, $oao2newwidth, $oao2newheight, $oao2width, $oao2height);
$oao2posx = 0.399 * $newwidth;
$oao2posy = 0.1817 * $newheight;
imagecopymerge($im, $oao2_resized, $oao2posx, $oao2posy, 0, 0, $oao2newwidth, $oao2newheight, 100);

}

// Overlay either the hockey stick or the basketball
if ($current_game['field_sport_value'] == 'hockey') {
  list($sohwidth, $sohheight) = getimagesize('images/sport-overlay-hockey.png');
  $soh_source = imagecreatefrompng('images/sport-overlay-hockey.png');
  $sohnewwidth = $sohwidth * $percent;
  $sohnewheight = $sohheight * $percent;
  $soh_resized = imagecreatetruecolor($sohnewwidth, $sohnewheight);
  imagecopyresized($soh_resized, $soh_source, 0, 0, 0, 0, $sohnewwidth, $sohnewheight, $sohwidth, $sohheight);
  $sohposx = 0.09 * $newwidth;
  $sohposy = 0.21 * $newheight;
  imagecopymerge($im, $soh_resized, $sohposx, $sohposy, 0, 0, $sohnewwidth, $sohnewheight, 100);
}
if ($current_game['field_sport_value'] == 'basketball') {
  list($sohwidth, $sohheight) = getimagesize('images/sport-overlay-basketball.png');
  $soh_source = imagecreatefrompng('images/sport-overlay-basketball.png');
  $sohnewwidth = $sohwidth * $percent;
  $sohnewheight = $sohheight * $percent;
  $soh_resized = imagecreatetruecolor($sohnewwidth, $sohnewheight);
  imagecopyresized($soh_resized, $soh_source, 0, 0, 0, 0, $sohnewwidth, $sohnewheight, $sohwidth, $sohheight);
  $sohposx = 0.09 * $newwidth;
  $sohposy = 0.21 * $newheight;
  imagecopymerge($im, $soh_resized, $sohposx, $sohposy, 0, 0, $sohnewwidth, $sohnewheight, 100);
  $pos8x = $newwidth * 0.13;
  $pos8y = $newheight * 0.336;
}
if ($current_game['field_sport_value'] == 'soccer') {
  list($sohwidth, $sohheight) = getimagesize('images/sport-overlay-soccer.png');
  $soh_source = imagecreatefrompng('images/sport-overlay-soccer.png');
  $sohnewwidth = $sohwidth * $percent;
  $sohnewheight = $sohheight * $percent;
  $soh_resized = imagecreatetruecolor($sohnewwidth, $sohnewheight);
  imagecopyresized($soh_resized, $soh_source, 0, 0, 0, 0, $sohnewwidth, $sohnewheight, $sohwidth, $sohheight);
  $sohposx = 0.09 * $newwidth;
  $sohposy = 0.21 * $newheight;
  imagecopymerge($im, $soh_resized, $sohposx, $sohposy, 0, 0, $sohnewwidth, $sohnewheight, 100);
  $pos8x = $newwidth * 0.13;
  $pos8y = $newheight * 0.336;
}



// Gender 1 letter

imagettftext($im, $fsize8, 0, $pos8x, $pos8y, $colourgrey, $arial, $current_game['gender']);


// Output

header("Content-type: image/png");

imagepng($im);

imagedestroy($im);

mysql_close();

?>
