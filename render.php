<?php
      // For information, contact Ryan Palmer (rypalmer@gmail.com)
      // Built Summer 2006 - by Ryan Palmer

      // include the database configuration and
      // open connection to database

include ("connect.php");
include ("include.php");
include ("functions.php");

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

// EDIT BELOW FOR START OF SEASON!!!
$hours = $hours + 10;
//$months = $months + 2;
//$days = $days + 13;

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
//echo $query2;
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

//	$query4   = "SELECT * FROM team WHERE team_id = $team_id_home_current LIMIT 1";
//	$result4  = mysql_query($query4) or die('Error, query failed. ' . mysql_error());
//	$row4     = mysql_fetch_array($result4, MYSQL_ASSOC);

//	$school_home_current = $row4['school'];
//	$arena_name_home_current = $row4['arena_name'];
//	$team_img_home_current = $row4['team_img'];

	$school_home_current = getteaminfo($team_id_home_current, school);
	$arena_name_home_current = getteaminfo($team_id_home_current, arena_name);
	$team_img_home_current = getteaminfo($team_id_home_current, team_img);


//	$query5   = "SELECT * FROM team WHERE team_id = $team_id_away_current LIMIT 1";
//	$result5  = mysql_query($query5) or die('Error, query failed. ' . mysql_error());
//	$row5     = mysql_fetch_array($result5, MYSQL_ASSOC);

//	$school_away_current = $row5['school'];
//	$arena_name_away_current = $row5['arena_name'];
//	$team_img_away_current = $row5['team_img'];

	$school_away_current = getteaminfo($team_id_away_current, school);
	$arena_name_away_current = getteaminfo($team_id_away_current, arena_name);
	$team_img_away_current = getteaminfo($team_id_away_current, team_img);

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
$penalty_light_home = $row['penalty_light_home'];
$penalty_light_away = $row['penalty_light_away'];

}



	// get team info for home and away teams

//	$query4   = "SELECT * FROM team WHERE team_id = $team_id_home_current LIMIT 1";
//	$result4  = mysql_query($query4) or die('Error, query failed. ' . mysql_error());
//	$row4     = mysql_fetch_array($result4, MYSQL_ASSOC);

//	$school_home_current = $row4['school'];
//	$arena_name_home_current = $row4['arena_name'];
//	$team_img_home_current = $row4['team_img'];

	$school_home_current = getteaminfo($team_id_home_current, school);
	$arena_name_home_current = getteaminfo($team_id_home_current, arena_name);
	$team_img_home_current = getteaminfo($team_id_home_current, team_img);


//	$query5   = "SELECT * FROM team WHERE team_id = $team_id_away_current LIMIT 1";
//	$result5  = mysql_query($query5) or die('Error, query failed. ' . mysql_error());
//	$row5     = mysql_fetch_array($result5, MYSQL_ASSOC);

//	$school_away_current = $row5['school'];
//	$arena_name_away_current = $row5['arena_name'];
//	$team_img_away_current = $row5['team_img'];

	$school_away_current = getteaminfo($team_id_away_current, school);
	$arena_name_away_current = getteaminfo($team_id_away_current, arena_name);
	$team_img_away_current = getteaminfo($team_id_away_current, team_img);




// Start the image generation

// File and new size
$filename = 'images/scoreboard-off-big-panthers.png';

if(isset($_GET[size]))
{
$percent = $_GET[size]/100;
if($percent > '1.50')
{
$percent = '1.5';
}
}
else
{
$percent = 1;
}


// Content type
header('Content-type: image/png');

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

$colourtime = imagecolorallocate($im, 200, 200, 200);
$colourgoal = imagecolorallocate($im, 255, 228, 0);
$colourperiod = imagecolorallocate($im, 0, 190, 0);
$colourwhite = imagecolorallocate($im, 255, 255, 255);
$colourblack = imagecolorallocate($im, 0, 0, 0);

$arial = 'arialbd.ttf';

$pos1x = $newwidth * 0.294;
$pos1y = $newheight * 0.37;
$fsize1 = $percent * 96;

$pos2x = $newwidth * 0.17;
$pos2y = $newheight * 0.74;
$fsize2 = $percent * 70;

$pos3x = $newwidth * 0.76;
$pos3y = $newheight * 0.74;
$fsize3 = $percent * 70;

$periodheader = "PERIOD";

if ($period == '1')
{
$period = "";
$time = "20:00";
$periodheader = "PREGAME";
$pos4x = $newwidth * 0.385;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 27;
}
if ($period == '2')
{
$period = "1";
}
if ($period == '3')
{
$periodheader = "1ST INTERMISSION";
$time = "20:00";
$period = "";
}
if ($period == '4')
{
$period = "2";
}
if ($period == '5')
{
$periodheader = "2ND INTERMISSION";
$time = "20:00";
$period = "";
}
if ($period == '6')
{
$period = "3";
}
if ($period == '7')
{
$period = "";
$periodheader = "OVERTIME";
}
if ($period == '8')
{
$period = "";
$time = "00:00";
$periodheader = "SHOOTOUT";
}
if ($period == '9')
{
$period = "";
$time = "00:00";
$periodheader = "FINAL";
}
if ($period == '10')
{
$period = "";
$time = "45:00";
$periodheader = "PREGAME";
$pos4x = $newwidth * 0.387;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 27;
}
if ($period == '11')
{
$periodheader = "HALF";
$pos4x = $newwidth * 0.44;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 30;
$period = "1";
}
if ($period == '12')
{
$periodheader = "HALF (it)";
$pos4x = $newwidth * 0.40;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 30;
$period = "1";
}
if ($period == '13')
{
$periodheader = "HALF TIME";
$pos4x = $newwidth * 0.37;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 30;
$time = "45:00";
$period = '';
}
if ($period == '14')
{
$periodheader = "HALF";
$pos4x = $newwidth * 0.43;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 30;
$period = "2";
}
if ($period == '15')
{
$periodheader = "HALF (it)";
$pos4x = $newwidth * 0.40;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 30;
$period = "2";
}
if ($period == '16')
{
$periodheader = "EXTRA";
$pos4x = $newwidth * 0.417;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 30;
$period = "2";
$time = '90:00';
}
if ($period == '17')
{
$periodheader = "SHOOT-OUT";
$period = "";
$pos4x = $newwidth * 0.362;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 28;
$time = '90:00';
}
if ($period == '18')
{
$periodheader = 'FULL';
$period = "";
$pos4x = $newwidth * 0.43;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 30;
}

if($periodheader == 'PERIOD')
{
$pos4x = $newwidth * 0.41;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 30;
}

if($periodheader == '1ST INTERMISSION')
{
$pos4x = $newwidth * 0.314;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 25;
}

if($periodheader == '2ND INTERMISSION')
{
$pos4x = $newwidth * 0.31;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 25;
}

if($periodheader == 'OVERTIME')
{
$pos4x = $newwidth * 0.381;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 27;
}

if($periodheader == 'POST-GAME')
{
$pos4x = $newwidth * 0.32;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 25;
}

if($periodheader == 'SHOOTOUT')
{
$pos4x = $newwidth * 0.382;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 25;
}

if($periodheader == 'FINAL')
{
$pos4x = $newwidth * 0.43;
$pos4y = $newheight * 0.69;
$fsize4 = $percent * 30;
}

$pos5x = $newwidth * 0.48;
$pos5y = $newheight * 0.87;
$fsize5 = $percent * 50;

// echo $periodheader, " ", $pos4x, " ", $pos4y, " ", $fsize4;


imagettftext($im, $fsize1, 0, $pos1x, $pos1y, $colourtime, $arial, $time); 
imagettftext($im, $fsize2, 0, $pos2x, $pos2y, $colourgoal, $arial, $score_home); 
imagettftext($im, $fsize3, 0, $pos3x, $pos3y, $colourgoal, $arial, $score_away); 
imagettftext($im, $fsize4, 0, $pos4x, $pos4y, $colourwhite, $arial, $periodheader); 
imagettftext($im, $fsize5, 0, $pos5x, $pos5y, $colourperiod, $arial, $period); 

$penlight = 'images/penlight.png';
list($penlight_width, $penlight_height) = getimagesize($penlight);
$source_penlight = imagecreatefrompng($penlight);
$width_resized = 33 * $percent;
$height_resized = 33 * $percent;
$penlight_resized = imagecreatetruecolor($width_resized, $height_resized); // Create memory space for resized picture
imagecopyresized($penlight_resized, $source_penlight, 0, 0, 0, 0, $width_resized, $height_resized, $penlight_width, $penlight_height);

$penlight_pos1x = $newwidth * 0.283;
$penlight_pos1y = $newheight * 0.472;

$penlight_pos2x = $newwidth * 0.333;
$penlight_pos2y = $newheight * 0.472;

$penlight_pos3x = $newwidth * 0.624;
$penlight_pos3y = $newheight * 0.472;

$penlight_pos4x = $newwidth * 0.675;
$penlight_pos4y = $newheight * 0.472;

if($penalty_light_home == 1)
{
imagecopymerge($im, $penlight_resized, $penlight_pos2x, $penlight_pos1y, 0, 0, $width_resized, $height_resized, 100);
}
if($penalty_light_home == 2)
{
imagecopymerge($im, $penlight_resized, $penlight_pos1x, $penlight_pos1y, 0, 0, $width_resized, $height_resized, 100);
imagecopymerge($im, $penlight_resized, $penlight_pos2x, $penlight_pos2y, 0, 0, $width_resized, $height_resized, 100);
}
if($penalty_light_away == 1)
{
imagecopymerge($im, $penlight_resized, $penlight_pos3x, $penlight_pos3y, 0, 0, $width_resized, $height_resized, 100);
}
if($penalty_light_away == 2)
{
imagecopymerge($im, $penlight_resized, $penlight_pos3x, $penlight_pos3y, 0, 0, $width_resized, $height_resized, 100);
imagecopymerge($im, $penlight_resized, $penlight_pos4x, $penlight_pos4y, 0, 0, $width_resized, $height_resized, 100);
}


// insert team graphics

list($team_img_home_current_width, $team_img_home_current_height) = getimagesize($team_img_home_current);
$team_img_home_current_source = imagecreatefrompng($team_img_home_current);
$width_resized = 120 * $percent;
$height_resized = 120 * $percent;
$team_img_home_current_resized = imagecreatetruecolor($width_resized, $height_resized); 
imagecopyresized($team_img_home_current_resized, $team_img_home_current_source, 0, 0, 0, 0, $width_resized, $height_resized, $team_img_home_current_width, $team_img_home_current_height);

$team_img_home_current_posx = $newwidth * 0.063;
$team_img_home_current_posy = $newheight * 0.19;

imagecopymerge($im, $team_img_home_current_resized, $team_img_home_current_posx, $team_img_home_current_posy, 0, 0, $width_resized, $height_resized, 100);

list($team_img_away_current_width, $team_img_away_current_height) = getimagesize($team_img_away_current);
$team_img_away_current_source = imagecreatefrompng($team_img_away_current);
$width_resized = 120 * $percent;
$height_resized = 120 * $percent;
$team_img_away_current_resized = imagecreatetruecolor($width_resized, $height_resized); 
imagecopyresized($team_img_away_current_resized, $team_img_away_current_source, 0, 0, 0, 0, $width_resized, $height_resized, $team_img_away_current_width, $team_img_away_current_height);

$team_img_away_current_posx = $newwidth * 0.79;
$team_img_away_current_posy = $newheight * 0.19;

imagecopymerge($im, $team_img_away_current_resized, $team_img_away_current_posx, $team_img_away_current_posy, 0, 0, $width_resized, $height_resized, 100);


// find out of the game hasn't started yet

$years = date("Y");
$months = date("m");
$days = date("d");
$hours = date("H");
$minutes = date("i");
$seconds = date("s");
$daysthismonth = date("t");

$minutes = $minutes + 5;

if($minutes >= 60)
{
$minutes = $minutes - 60;
$hours = $hours + 1;
}

if($hours >= 25)
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

$rightnow = $years . "-" . $months . "-" . $days . " " . $hours . ":" . $minutes . ":" . $seconds;

if($rightnow < $game_date_current)
{
//overlay shaded box
// define an image box, resize it

list($boxwidth, $boxheight) = getimagesize('images/boxoverlay.png');

$box_source = imagecreatefrompng('images/boxoverlay.png');
$boxnewwidth = $boxwidth * $percent;
$boxnewheight = $boxheight * $percent;

$box_resized = imagecreatetruecolor($boxnewwidth, $boxnewheight); 

	//	$background = imagecolorallocate($box_resized, 0, 0, 0);
	//	ImageColorTransparent($box_resized, $background); // make the new temp image all transparent
	//	imagealphablending($box_resized, false); 

imagecopyresized($box_resized, $box_source, 0, 0, 0, 0, $boxnewwidth, $boxnewheight, $boxwidth, $boxheight);

//coordinates
$boxposx = ($newwidth - $boxnewwidth) / 2;
$boxposy = 0.13 * $newheight;

imagecopymerge($im, $box_resized, $boxposx, $boxposy, 0, 0, $boxnewwidth, $boxnewheight, 100);

$fsize6 = $percent * 34;
$fsize7 = $percent * 32;
$fsize8 = $percent * 26;

$pos6x = 140 * $percent;
$pos6y = 140 * $percent;

$pos7x = 110 * $percent;
$pos7y = 240 * $percent;

$pos8x = 210 * $percent;
$pos8y = 310 * $percent;

$pos9x = 110 * $percent;
$pos9y = 380 * $percent;

$pos10x = 112 * $percent;
$pos10y = 465 * $percent;

$query6 = "SELECT DATE_FORMAT(date, '%M %D, %Y  %h:%i%p') AS date FROM game WHERE game_id = '$game_id_current' LIMIT 1";
// echo $query6;
$result6  = mysql_query($query6) or die('Error, query failed. ' . mysql_error());
$row6     = mysql_fetch_array($result6, MYSQL_ASSOC);

$game_date_current_nice = $row6[date];

imagettftext($im, $fsize5, 0, $pos6x, $pos6y, $colourblack, $arial, 'Next Broadcast:');
imagettftext($im, $fsize7, 0, $pos7x, $pos7y, $colourblack, $arial, $school_home_current);
imagettftext($im, $fsize6, 0, $pos8x, $pos8y, $colourblack, $arial, 'vs.');
imagettftext($im, $fsize7, 0, $pos9x, $pos9y, $colourblack, $arial, $school_away_current);
imagettftext($im, $fsize8, 0, $pos10x, $pos10y, $colourblack, $arial, $game_date_current_nice);

}

// Output

header("Content-type: image/png");

imagepng($im);

imagedestroy($im);

mysql_close();

?>
