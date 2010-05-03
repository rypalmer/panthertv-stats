<?php

	// This page allows games, teams and players to be added to the Interactive
	// Listening Lounge Database

      // For information, contact Ryan Palmer (rypalmer@gmail.com)
      // Built July 2006 - by Ryan Palmer


// include the database configuration and
// open connection to database


include ("connect.php");


// Check all forms to see if anything has been submitted


include ("include.php");

function game_type_verbose($game_type)
{
	if($game_type == 1)
	{ $game_type = "M.Hockey";}
	if($game_type == 2)
	{ $game_type = "W.Hockey";}
	if($game_type == 3)
	{ $game_type = "M.Soccer";}
	if($game_type == 4)
	{ $game_type = "W.Soccer";}
return $game_type;
}
?>

<html>
<head>
<title>Panther Radio Listening Lounge 2.0 - Stats Admin Interface</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<style type="text/css" media="all">@import "style.css";</style>

</head>
<body>

<div id="container">


<h1>Interactive Listening Lounge - Admin Interface</h1>
<p align="right"><a onclick="MyWindow=window.open('http://stats.upeiism.org','MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=730,height=420'); return false;" href="#">Launch the Listener Window</a></p>

<table width="760" border="1">
<tr><td width="48%">

<h2>Current Game</h2>

Active Game: <strong>Game <?=$game_id_current;?>, <?=$school_away_current;?> vs <?=$school_home_current;?></strong>
<br><em><?=$game_date_current;?>, <?=$arena_name_home_current;?></em>




<p><a href="gamestaff.php">Continue to the game staff control interface</a></p>

</td>
<td width="10"></td><td align="top">
<h2>Add a new game</h2>
	<form method="post" name="gameadd">
  
 	Home Team	<select name="team_id_home">

	<?php			
	$query = "SELECT * FROM team";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());

	while ($row = mysql_fetch_array($result)) 
		{
		list($team_id, $school, $arena_name, $team_img, $game_type) = $row;
		
		?><option value="<?=$team_id;?>"> <?echo game_type_verbose($game_type), " ", $school, "\n"; 
	
		}
	?>
	</select>
	<br />	
 	Away Team:	<select name="team_id_away">

 	<?php
 	$query = "SELECT * FROM team";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());
 		while ($row = mysql_fetch_array($result)) 
		{
		list($team_id, $school, $arena_name, $team_img, $game_type) = $row;
	
		?><option value="<?=$team_id;?>"> <?echo game_type_verbose($game_type), " ", $school, "\n"; 
	
		}
		date_default_timezone_set('America/Halifax');
	?>
	</select>
	<br />
	Date:	<input type="text" name="date" value="<?= date("Y-m-d G");?>:00:00">
	<br />
	Type: <select name="game_type"><option value="1">Mens Hockey</option>
<option value="2">Womens Hockey</option>
<option value="3">Mens Soccer</option>
<option value="4">Womens Soccer</option></select>
	<br />
	<input name="gameinsert" type="submit" id="gameinsert" value="Add the new game">
    </form>

</td>
</tr>
<tr height="10"><td colspan="3"></td></tr>
<tr><td align="top">
<h2>Add a new player</h2>
	<form method="post" name="playeradd">
 
 Player name:  <input type="text" name="player_name" size="40"><br />
 Player number: <input type="text" name="player_number" size="10"><br />
 Team	<select name="team_id">
 <?php

 $query6 = "SELECT MAX(player_id) AS maxplayer FROM player";
 $result6 = mysql_query($query6) or die('Error, query failed. ' . mysql_error());
 $row6     = mysql_fetch_array($result6, MYSQL_ASSOC);
 $player_id = $row6[maxplayer];

echo "player id:", $player_id;

 $lastaddedplayerquery = "SELECT team_id FROM player WHERE player_id = '$player_id' LIMIT 1";
 $lastaddedplayerresult = mysql_query($query) or die('Error, query failed. ' . mysql_error());
 $rowlastaddedplayer     = mysql_fetch_array($lastaddedplayerresult, MYSQL_ASSOC);

echo "teamid: ", $rowlastaddedplayer['team_id'];


 $query = "SELECT * FROM team";
	$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());
 		while ($row = mysql_fetch_array($result)) 
		{
		list($team_id, $school, $arena_name, $team_img, $game_type) = $row;
	
		?><option value="<?=$team_id;?>" <?if($team_id == $rowlastaddedplayer['team_id']){echo "SELECTED";}?>> <?echo game_type_verbose($game_type), " ", $school, "\n"; 
	
		}
		
	?>
	</select>
 
 
	<br />
	<input name="playerinsert" type="submit" id="playerinsert" value="Add the new Player">
    </form>
</td>
<td></td><td align="top"><h2>Enter a new team</h2>

	<form method="post" name="teamadd">
 
 School name:  <input type="text" name="school" size="50"><br />
 Arena name: <input type="text" name="arena_name" size="50"><br />
 Location of team graphic <input type="text" name="team_img" width="50"><br />
 
	<br />
	<input name="teaminsert" type="submit" id="teaminsert" value="Add the new Team">
    </form>
</td>
</tr>
<tr height="10"><td colspan="3"></td></tr>
<tr><td colspan="3" align="top">
<h2>Event history</h2>
<table width="750">

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
$query = "SELECT * FROM event ORDER BY event_id DESC LIMIT $offset, $rowsPerPage";
$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());

// if the guestbook is empty show a message
if(mysql_num_rows($result) == 0)
{
?>
<tr><td colspan="3">
 No events have been posted to the event log. </td></tr>
<?php
}
else
{
    // get all guestbook entries
    while($row = mysql_fetch_array($result))
    {
        // list() is a convenient way of assign a list of variables
        // from an array values 
        list($event_id, $type, $game_id, $team_id, $datetime, $message) = $row;

        // change all HTML special characters,
        // to prevent some nasty code injection
        $message = htmlspecialchars($message);        

        // convert newline characters ( \n OR \r OR both ) to HTML break tag ( <br> )
        $message = nl2br($message);

if ($type == 1)
{
$type = "Game";
$color = "#EBED53";
}
if ($type == 2)
{
$type = "Team";
$color = "#EBED53";
}
if ($type == 3)
{
$type = "Player";
$color = "#EBED53";
}
if ($type == 4)
{
$type = "Goal";
$color = "#5AED53";
}
if ($type == 5)
{
$type = "Penalty";
$color = "#ED6153";
}        
if ($type == 6)
{
$type = "Comment";
$color = "#53ADED";
}       
        
?>

 <tr height="10"><td colspan="3"></td></tr>
 <tr> 
  <td width="100" align="left" bgcolor="<?=$color;?>">&nbsp;&nbsp;<?=$type;?></td>
  <td bgcolor="<?=$color;?>"><?=$message;?></td>
  <td align="right" bgcolor="<?=$color;?>"> 
  <p class="small">Submitted:  <?=$datetime;?></p>
  </td>
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

</td></tr></table>

<br>
<br>
<br>
<center>&copy; 2006 - Ryan Palmer</center>
</div>
</body>
</html>