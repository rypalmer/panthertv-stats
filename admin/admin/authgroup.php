<?
/*
# File: authgroup.php
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
	
	if ($check['level'] != 1)
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
	$group = new auth();

	$connection = mysql_connect($dbhost, $dbusername, $dbpass);
	$SelectedDB = mysql_select_db($dbname);
	$listusers = mysql_query("SELECT * from authuser");

?>
<?
// Check if we have instantiated $action and $act variable
// If yes, get the value from previous posting
// If not, set values to null or ""
 
if (isset($_POST['action'])) 
{
	$action = $_POST['action'];
	$act = "";
	$teamname = $_POST['teamname'];
	$teamlead = $_POST['teamlead'];
	$status = $_POST['status'];
}
elseif (isset($_GET['act']))
{
	$act = $_GET['act'];
	$action = "";
}
else
{
	$action = "";
	$act = "";
	$teamname = "";
	$teamlead = "";
	$status = "";
}

$message = "";

// ADD GROUP
if ($action == "Add") {
	$situation = $group->add_team($teamname, $teamlead, $status);
	
	if ($situation == "blank team name") {
		$message = "Team Name field cannot be blank.";
		$action = "";
	}
	elseif ($situation == "group exists") {
		$message = "Team Name already exists in the database. Please enter a new one.";
		$action = "";
	}
	elseif ($situation == 1) {
		$message = "New team added successfully.";
	}
	else {
		$message = "";
	}
}

// DELETE GROUP
if ($action=="Delete") {
	$delete = $group->delete_team($teamname);
	
	if ($delete) {
		$message = $delete;
		$action = "";
	}
	else {
		$teamname = "";
		$teamlead = "sa";
		$status = "active";
		$message = "The group has been deleted.<br>All users associated with the group are moved to the Ungrouped team";
	}
}

// MODIFY TEAM
if ($action == "Modify") {
	$update = $group->modify_team($teamname, $teamlead, $status);

	if ($update==1) {
		$message = "Team detail updated successfully.";
	}
	elseif ($update == "Admin team cannot be inactivated.") {
		$message = $update;
		$action = "";
	}
	elseif ($update == "Ungrouped team cannot be inactivated.") {
		$message = $update;
		$action = "";
	}
	elseif ($update == "Team Lead field cannot be blank.") {
		$message = $update;
		$action = "";
	}
	else {
		$message = "";
	}
}

// EDIT TEAM (accessed from clicking on username links)
if ($act == "Edit") {
    $teamname = $_GET['teamname'];
    $teamlead = $_GET['teamlead'];
    $status = $_GET['status'];
    $message = "Modify team details.";
}

// CLEAR FIELDS
if ($action == "Add New") {
	$teamname = "";
	$teamlead = "sa";
	$status = "active";
	$message = "New team detail entry.";
}

?>
<html>
<head>
<title>vAuthenticate Administrative Interface</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<p><font face="Arial, Helvetica, sans-serif" size="5"><b>vAuthenticate Administration 
  - Teams</b></font></p>
<table width="75%" border="1" cellspacing="0" cellpadding="0" bordercolor="#000000">
  <tr> 
    <td width="20%" bgcolor="#0099CC" height="16"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFCC">Administer</font></b></td>
    <td width="16%" bgcolor="#FFFFCC" height="16"> 
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="index.php">Home</a></font></div>
    </td>

    <td width="16%" bgcolor="#FFFFCC" height="16"> 
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="authuser.php">Users</a></font></div>
    </td>

    <td width="16%" bgcolor="#FFFFCC" height="16"> 
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="<? echo $logout; ?>">Logout</a></font></div>
    </td>
  </tr>
</table><br>&nbsp;
<table width="95%" border="0" cellspacing="0" cellpadding="0" align="left">
  <tr valign="top"> 
    <td width="50%"> 
      
	  <form name="AddTeam" method="Post" action="authgroup.php">
	    <table width="95%" border="1" cellspacing="0" cellpadding="0" align="center" bordercolor="#000000">
          <tr bgcolor="#000000"> 
            <td colspan="2"> 
              <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="3" color="#FFFFCC"><b>TEAM 
                DETAILS</b></font></div>
            </td>
          </tr>
          <tr valign="middle"> 
            <td width="27%" bgcolor="#33CCFF"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Team 
              Name </font></b></td>
            <td width="73%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp; 
              <?   
			  	if (($action == "Modify") || ($action=="Add") || ($act=="Edit")) {
					print "<input type=\"hidden\" name=\"teamname\" value=\"$teamname\">"; 
					print "<font face=\"Verdana, Arial, Helvetica, sans-serif\" color=\"#006666\" size=\"2\">$teamname</font>";
				}
				else {	
					print "<input type=\"text\" name=\"teamname\" size=\"15\" maxlength=\"15\" value=\"$teamname\">"; 
				}
				
			  ?>
              </font></td>
          </tr>
          <tr valign="middle"> 
            <td width="27%" bgcolor="#33CCFF"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Team 
              Lead </font></b></td>
            <td width="73%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp; 
              <select name="teamlead">
                <?
			  	// DISPLAY MEMBERS
			  	$row = mysql_fetch_array($listusers);
			  	while ($row) {
					$memberlist = $row["uname"];
					
					if ($teamlead == $memberlist) {
						print "<option value=\"$memberlist\" SELECTED>" . $row["uname"] . "</option>";
					}
					else {
						print "<option value=\"$memberlist\">" . $row["uname"] . "</option>";
					}
					$row = mysql_fetch_array($listusers);
				}
			  ?>
              </select>
              <a href="authuser.php">Add</a></font></td>
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
          <td colspan="3"> 
            <div align="center"><font size="3" face="Verdana, Arial, Helvetica, sans-serif" color="#FFFFCC"><b>TEAM 
              LIST</b></font></div>
          </td>
        </tr>
        <tr bgcolor="#CCCCCC"> 
          <td width="35%"> 
            <div align="center"><font size="1"><b><font face="Verdana, Arial, Helvetica, sans-serif">Team 
              Name </font></b></font></div>
          </td>
          <td width="34%"> 
            <div align="center"><font size="1"><font face="Verdana, Arial, Helvetica, sans-serif"><b>Team 
              Lead </b></font></font></div>
          </td>
          <td width="31%"> 
            <div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><b>Status</b></font></div>
          </td>
        </tr>

<?
	// Fetch rows from AuthUser table and display ALL users
	$qQuery = "SELECT * FROM authteam ORDER BY id";
	
	// OLD CODE - DO NOT REMOVE
	// $result = mysql_db_query($dbname, $qQuery);
	
	// REVISED CODE
	$result = mysql_query($qQuery);
	
	$row = mysql_fetch_array($result);
	while ($row) {  		
		print "<tr>"; 
        print "  <td width=\"35%\">";
        print "    <div align=\"left\"><font face=\"Verdana, Arial, Helvetica, sans-serif\" size=\"1\">";
		print "		<a href=\"authgroup.php?act=Edit&teamname=".$row["teamname"]."&teamlead=".$row["teamlead"]."&status=".$row["status"]."\">";
		print 		$row["teamname"];
		print "		</a>";
		print "	   </font></div>";
        print "  </td>";
        print "  <td width=\"34%\">";
        print "    <div align=\"center\"><font face=\"Verdana, Arial, Helvetica, sans-serif\" size=\"1\">".$row["teamlead"]."</font></div>";
        print "  </td>";
        print "  <td width=\"31%\">";
        print "    <div align=\"right\"><font size=\"1\" face=\"Verdana, Arial, Helvetica, sans-serif\">".($row["status"])."</font></div>";
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
