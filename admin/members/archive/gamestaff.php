<?php
      include_once ("/admin/auth.php");
      include_once ("/admin/authconfig.php");
      include_once ("/admin/check.php");

      if (($check['level'] != 5))
      {
        echo 'You are not allowed to access this page.';
        exit();
      }
else
{
    ?>

<?php

	// This is the business-end of the Interactive Listening Lounge for 
	// Panther Radio Game Staff

      // For information, contact Ryan Palmer (rypalmer@gmail.com)
      // Built July 2006 - by Ryan Palmer

// include the database configuration and
// open connection to database

include ("/connect.php");


// Check all forms to see if anything has been submitted


include ("include.php");

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
<p align="right"><a onclick="MyWindow=window.open('http://www.ryanpalmer.ca/pantherradio/frame.html','MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=730,height=420'); return false;" href="#">Launch the Listener Window</a>
<br><a href="gameadmin.php">Return to the Game Admin page</a></p>

<table width="760" border="1" align="center">

<tr><td colspan="3">Active Game: <strong>Game <?=$game_id_current;?>, <?=$school_home_current;?> vs. <?=$school_away_current;?></strong>
<br><em><?=$game_date_current;?>, <?=$arena_name_home_current;?></em>

</td></tr>

<!--<tr><td width="48%"></td><td width="10"></td><td></td></tr>-->

<tr><td>

<?php

$query = "SELECT * FROM gameprogress ORDER BY gameprogress_id DESC LIMIT 1";
$result = mysql_query($query) or die('Error, query failed. ' . mysql_error());
$row     = mysql_fetch_array($result, MYSQL_ASSOC);


$gameprogress_id = $row['gameprogress_id'];
$game_id = $row['game_id'];
$period = $row['period'];
$time = $row['time'];
$dashtime = " - " . $row['time'];


if ($period == 1)
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

?>
<h2>Current Game Position</h2>
<?php

echo $period, $dashtime, "\n";
?>
</td><td></td><td>


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
	while($i<20)
		{

		?><option value="<?=$i;?>"><?=$i;?></option><?

		$i = $i + 1;

		}
		?>
	</select>
	<select name="seconds">
<?php	$i = 0;
	while($i<60)
		{

		?><option value="<?=$i;?>"><?=$i;?></option><?

		$i = $i + 1;

		}
		?>
	</select>

	<br />
	<input name="gameposition" type="submit" id="gameposition" value="Update the current game position">
    </form>

</td></tr>

<tr height="10"><td colspan="3"></td></tr>

<tr><td width="48%">

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
	</select>
 
	<input type="hidden" name="game_id" value="<?=$game_id_current;?>" >
	<input type="hidden" name="team_id" value="<?=$team_id_home_current;?>" ><br />
	Period: <select name="period">
	<option value="2"<?=$selected2;?>>1st Period</option>
	<option value="3"<?=$selected4;?>>2nd Period</option>
	<option value="4"<?=$selected6;?>>3rd Period</option>
	<option value="5"<?=$selected7;?>>Overtime</option>
	<option value="6"<?=$selected8;?>>Shootout</option>
	</select><br />
	Time of the goal: <input type="text" name="time" size="10" value="<?=$time;?>">


	<br />
	<input name="goal_home_insert" type="submit" id="goal_home_insert" value="Add the Home Goal">
    </form>

</td>

<td width="10"></td>

<td>

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
	</select>
 
	<input type="hidden" name="game_id" value="<?=$game_id_current;?>" >
	<input type="hidden" name="team_id" value="<?=$team_id_away_current;?>" ><br />
	Period: <select name="period">
	<option value="2"<?=$selected2;?>>1st Period</option>
	<option value="3"<?=$selected4;?>>2nd Period</option>
	<option value="4"<?=$selected6;?>>3rd Period</option>
	<option value="5"<?=$selected7;?>>Overtime</option>
	<option value="6"<?=$selected8;?>>Shootout</option>
	</select><br />
	Time of the goal: <input type="text" name="time" size="10" value="<?=$time;?>">


	<br />
	<input name="goal_away_insert" type="submit" id="goal_away_insert" value="Add the Away Goal">
    </form>


</td></tr>
<tr height="10"><td colspan="3"></td></tr>
<tr>
<td>
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
<td>
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
</td>




<tr>
<td colspan="3"><ul><li><a href="gameadmin.php">back to Game Admin</a></li></ul>
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
<center>&copy; 2006 - Ryan Palmer</center>
</div>

</body>
</html>

<?php } ?>