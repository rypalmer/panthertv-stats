<?
/*
# File: authuser.php
# Script Name: vAuthenticate 3.0.1
# Author: Vincent Ryan Ong
# Email: support@beanbug.net
#
# Description:
# vAuthenticate is a revolutionary authentication script which uses
# PHP and MySQL for lightning fast processing. vAuthenticate comes
# with an admin interface where webmasters and administrators can
# create new user accounts, new user groups, activate/inactivate
# groups or individual accounts, set user level, etc. This may be
# used to protect files for member-only areas. vAuthenticate
# uses a custom class to handle the bulk of insertion, updates, and
# deletion of data. This class can also be used for other applications
# which needs user authentication.
#
# This script is a freeware but if you want to give donations,
# please send your checks (coz cash will probably be stolen in the
# post office) to:
#
# Vincent Ryan Ong
# Rm. 440 Wellington Bldg.
# 655 Condesa St. Binondo, Manila
# Philippines, 1006
*/
?>
<?
	include_once ("../auth.php");
	include_once ("../authconfig.php");
	include_once ("../check.php");
	
	if ($check["level"] != 1)
	{
		// Feel free to change the error message below. Just make sure you put a "\" before
		// any double quote.
		print "<font face=\"Arial, Helvetica, sans-serif\" size=\"5\" color=\"#FF0000\">";
		print "<b>Illegal Access</b>";
		print "</font><br>";
  		print "<font face=\"Verdana, Arial, Helvetica, sans-serif\" size=\"2\" color=\"#000000\">";
		print "<b>You do not have permission to view this page.</b></font>";
		
		exit; // End program execution. This will disable continuation of processing the rest of the page.
	}	
	
	$user = new auth();
	
	$connection = mysql_connect($dbhost, $dbusername, $dbpass);
	$SelectedDB = mysql_select_db($dbname);
	$listteams = mysql_query("SELECT * from authteam");
	
?>
<?
// Get initial values from superglobal variables
// Let's see if the admin clicked a link to get here
// or was originally here already and just pressed 
// a button or clicked on the User List

if (isset($_POST['action'])) 
{
	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$team = $_POST['team'];
	$level = $_POST['level'];
	$status = $_POST['status'];
	$action = $_POST['action'];
	$act = "";
}
elseif (isset($_GET['act']))
{
	$act = $_GET['act'];
	$action = "";
}
else
{
	$action = "";
	$username = "";
	$password = "";	
	$team = "";
	$level = "";
	$status = "";
	$action = "";
	$act = "";
}

$message = "";

// ADD USER
if ($action == "Add") {
	$situation = $user->add_user($username, $password, $team, $level, $status);
	
	if ($situation == "blank username") {
		$message = "Username field cannot be blank.";
		$action = "";
	}
	elseif ($situation == "username exists") {
		$message = "Username already exists in the database. Please enter a new one.";
		$action = "";
	}
	elseif ($situation == "blank password") {
		$message = "Password field cannot be blank for new members.";
		$action = "";
	}
	elseif ($situation == "blank level") {
		$message = "Level field cannot be blank.";
		$action = "";
	}
	elseif ($situation == 1) {
		$message = "New user added successfully.";
	}
	else {
		$message = "";
	}
}

// DELETE USER
if ($action=="Delete") {
	// Delete record in authuser table
	$delete = $user->delete_user($username);
	
	// Delete record in signup table
	$deletesignup =  mysql_query("DELETE FROM signup WHERE uname='$username'");

	if ($delete && $deletesignup) {
		$message = $delete;
	}
	else {
		$username = "";
		$password = "";
		$team = "Ungrouped";
		$level = "";
		$status = "active";
		$message = "The user has been deleted.";
	}
}

// MODIFY USER
if ($action == "Modify") {
	$update = $user->modify_user($username, $password, $team, $level, $status);

	if ($update==1) {
		$message = "User detail updated successfully.";
	}
	elseif ($update == "blank level") {
		$message = "Level field cannot be blank.";
		$action = "";
	}
	elseif ($update == "sa cannot be inactivated") {
		$message = "This user cannot be inactivated.";
		$action = "";
	}
	elseif ($update == "admin cannot be inactivated") {
		$message = "This user cannot be inactivated";
		$action = "";
	}
	else {
		$message = "";
	}
}

// EDIT USER (accessed from clicking on username links)
if ($act == "Edit") 
{
    $username = $_GET['username'];
	$listusers = mysql_query("SELECT * from authuser where uname='$username'");
	$rows = mysql_fetch_array($listusers);
	$username = $rows["uname"];
	$password = "";
	$team = $rows["team"];
	$level = $rows["level"];
	$status = $rows["status"];

	$message = "Modify user details.";
}

// CLEAR FIELDS
if ($action == "Add New") {
	$username = "";
	$password = "";
	$team = "Ungrouped";
	$level = "";
	$status = "active";
	$message = "New user detail entry.";
}

?>

<html>
<head>
<title>vAuthenticate Administrative Interface</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<p><font face="Arial, Helvetica, sans-serif" size="5"><b>vAuthenticate Administration 
  - Users</b></font></p>
<table width="75%" border="1" cellspacing="0" cellpadding="0" bordercolor="#000000">
  <tr> 
    <td width="20%" bgcolor="#0099CC" height="16"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFCC">Administer</font></b></td>
    <td width="16%" bgcolor="#FFFFCC" height="16"> 
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="index.php">Home</a></font></div>
    </td>

    <td width="16%" bgcolor="#FFFFCC" height="16"> 
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="authgroup.php">Groups</a></font></div>
    </td>

    <td width="16%" bgcolor="#FFFFCC" height="16"> 
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="<? echo $logout; ?>">Logout</a></font></div>
    </td>
  </tr>
</table><br>&nbsp;
<table width="95%" border="0" cellspacing="0" cellpadding="0" align="left">
  <tr valign="top"> 
    <td width="50%"> 
      
	  <form name="AddUser" method="Post" action="authuser.php">
	    <table width="95%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#000000">
          <tr bgcolor="#000000"> 
            <td colspan="2"> 
              <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="3" color="#FFFFCC"><b>USER 
                DETAILS</b></font></div>
            </td>
          </tr>
          <tr valign="middle"> 
            <td width="27%" bgcolor="#33CCFF"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Username</font></b></td>
            <td width="73%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp; 
              <?   
			  	if (($action == "Modify") || ($action=="Add") || ($act=="Edit")) {
					print "<input type=\"hidden\" name=\"username\" value=\"$username\">"; 
					print "<font face=\"Verdana, Arial, Helvetica, sans-serif\" color=\"#006666\" size=\"2\">$username</font>";
				}
				else {	
					print "<input type=\"text\" name=\"username\" size=\"15\" maxlength=\"15\" value=\"$username\">"; 
				}
				
			  ?>
              </font></td>
          </tr>
          <tr valign="middle"> 
            <td width="27%" bgcolor="#33CCFF"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password</font></b></td>
            <td width="73%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp; 
              <? print "<input type=\"password\" name=\"password\" size=\"20\" maxlength=\"15\" value=\"$password\">"; ?>
              </font></td>
          </tr>
          <tr valign="middle"> 
            <td width="27%" bgcolor="#33CCFF"><font face="Verdana, Arial, Helvetica, sans-serif" size="1">&nbsp;</font></td>
            <td width="73%"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#000099">&nbsp;&nbsp;Leave
              the password field blank if you want to retain the old password. 
              </font></td>
          </tr>
          <tr valign="middle"> 
            <td width="27%" bgcolor="#33CCFF"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Team</font></b></td>
            <td width="73%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp; 
              <select name="team">
                <?
			  	// DISPLAY TEAMS
			  	$row = mysql_fetch_array($listteams);
			  	while ($row) {
					$teamlist = $row["teamname"];
					
					if ($team == $teamlist) {
						print "<option value=\"$teamlist\" SELECTED>" . $row["teamname"] . "</option>";
					}
					else {
						print "<option value=\"$teamlist\">" . $row["teamname"] . "</option>";
					}
					$row = mysql_fetch_array($listteams);
				}
			  ?>
              </select>
              <a href="authgroup.php">Add</a></font></td>
          </tr>
          <tr valign="middle"> 
            <td width="27%" bgcolor="#33CCFF"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Level</font></b></td>
            <td width="73%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp; 
              <? print "<input type=\"text\" name=\"level\" size=\"4\" maxlength=\"4\" value=\"$level\">"; ?>
              </font></td>
          </tr>
          <tr valign="middle"> 
            <td width="27%" bgcolor="#33CCFF"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Status</font></b></td>
            <td width="73%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp; 
              <select name="status">
                <?
			  	// ACTIVE / INACTIVE
				if ($status == "inactive") {
					print "<option value=\"active\">Active</option>";
                	print "<option value=\"inactive\" selected>Inactive</option>";
				}
				else {
					print "<option value=\"active\" selected>Active</option>";
                	print "<option value=\"inactive\">Inactive</option>";
				}
              
			  ?>
              </select>
              </font></td>
          </tr>
          <tr bgcolor="#CCCCCC" valign="middle"> 
            <td colspan="2"> 
              <div align="center"><font size="2"><font size="2"><font size="2"><font face="Verdana, Arial, Helvetica, sans-serif"> 
                <?
					
				if (($action=="Add") || ($action == "Modify") || ($act=="Edit")) {
					print "<input type=\"submit\" name=\"action\" value=\"Add New\"> ";
					print "<input type=\"submit\" name=\"action\" value=\"Modify\"> ";
					print "<input type=\"submit\" name=\"action\" value=\"Delete\"> ";
				}
				else {
					print "<input type=\"submit\" name=\"action\" value=\"Add\"> ";
                }
				
				?>
                <input type="reset" name="Reset" value="Clear">
                </font></font></font></font></div>
            </td>
          </tr>
        </table>
	  </form>
	  

      <p>&nbsp;</p>
      <table width="95%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#000000">
        <tr> 
          <td bgcolor="#990000"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFCC">Message:</font></b></td>
        </tr>
        <tr> 
          <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#0000FF">
		  <?
		  	if ($message) {
			 	print $message;
		  	}
			else {
				print "<BR>&nbsp;";
			}
		  ?>
		  </font></td>
        </tr>
      </table>
      <p>&nbsp;</p>
      </td>
    <td width="50%"> 
      
	  
	  <table width="95%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#000000">
        <tr bgcolor="#000000"> 
          <td colspan="5"> 
            <div align="center"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFCC"><b>USER 
              LIST</b></font></div>
          </td>
        </tr>
        <tr bgcolor="#CCCCCC"> 
          <td width="20%"> 
            <div align="center"><font size="1"><b><font face="Verdana, Arial, Helvetica, sans-serif">Username</font></b></font></div>
          </td>
          <td width="25%"> 
            <div align="center"><font size="1"><b><font face="Verdana, Arial, Helvetica, sans-serif">Group</font></b></font></div>
          </td>
          <td width="15%"> 
            <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b>Status</b></font></div>
          </td>
          <td width="30%"> 
            <div align="center"><font size="1"><b><font face="Verdana, Arial, Helvetica, sans-serif">Last Login</font></b></font></div>
          </td>
          <td width="10%"> 
            <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b>Count</b></font></div>
          </td>
        </tr>

<?
	// Fetch rows from AuthUser table and display ALL users
	// OLD CODE - DO NOT REMOVE
	// $result = mysql_db_query($dbname, "SELECT * FROM authuser ORDER BY id");
	
	// REVISED CODE
	$result = mysql_query("SELECT * FROM authuser ORDER BY id");
	
	$row = mysql_fetch_array($result);
	while ($row) {  		
		print "<tr>"; 
        print "  <td width=\"20%\">";
        print "    <div align=\"left\"><font face=\"Verdana, Arial, Helvetica, sans-serif\" size=\"1\">";
		print "		<a href=\"authuser.php?act=Edit&username=".$row['uname']."\">";
		print 		$row['uname'];
		print "		</a>";
		print "	   </font></div>";
        print "  </td>";
        print "  <td width=\"25%\">";
        print "    <div align=\"center\"><font face=\"Verdana, Arial, Helvetica, sans-serif\" size=\"1\">".$row['team']."</font></div>";
        print "  </td>";
        print "  <td width=\"15%\">";
        print "    <div align=\"center\"><font size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\">".($row['status'])."</font></div>";
        print "  </td>";
        print "  <td width=\"30%\">";
        print "    <div align=\"center\"><font face=\"Verdana, Arial, Helvetica, sans-serif\" size=\"1\">".$row['lastlogin']."</font></div>";
        print "  </td>";
        print "  <td width=\"10%\">";
        print "    <div align=\"right\"><font size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\">".($row['logincount'])."</font></div>";
        print "  </td>";
        print "</tr>";
		
		$row = mysql_fetch_array($result);
	}
?>
     
	  </table>
	  
      
    </td>
  </tr>
</table>

</body>
</html>
