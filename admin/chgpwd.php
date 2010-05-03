<?
/*
# File: chgpwd.php
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
	include_once ("auth.php");
	include_once ("authconfig.php");
	include_once ("check.php");
?>

<head><title>Change Password</title></head>
<body bgcolor="#FFFFFF">

<p align="center"><b><font face="Arial">Change Password</font></b></p>
<div align="center">
  <center>
  <form method="POST" action="chgpwd.php">
  <table border="0" cellpadding="0" cellspacing="0" width="40%">
    <tr>
      <td width="100%" bgcolor="#C0C0C0" colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td width="34%" bgcolor="#C0C0C0"><b><font size="2" face="Arial">&nbsp; Old Password:</font></b></td>
      <td width="66%" bgcolor="#C0C0C0">
      <input type="password" name="oldpasswd" size="25"></td>
    </tr>
    <tr>
      <td width="34%" bgcolor="#C0C0C0"><b><font size="2" face="Arial">&nbsp; New Password:</font></b></td>
      <td width="66%" bgcolor="#C0C0C0">
      <input type="password" name="newpasswd" size="25"></td>
    </tr>
    <tr>
      <td width="34%" bgcolor="#C0C0C0"><b><font size="2" face="Arial">&nbsp; Confirm:</font></b></td>
      <td width="66%" bgcolor="#C0C0C0">
      <input type="password" name="confirmpasswd" size="25"></td>
    </tr>
    <tr>
      <td width="100%" colspan="2" bgcolor="#C0C0C0">&nbsp; </td>
    </tr>
    <tr>
      <td width="100%" colspan="2" bgcolor="#C0C0C0">
      <p align="center"><input type="submit" value="Save Changes" name="submit">
      <input type="reset" value="Reset Fields" name="reset"></td>
    </tr>
    <tr>
      <td width="100%" colspan="2" bgcolor="#C0C0C0">&nbsp;
       </td>
    </tr>
  </table>      
  </form>
  </center>
</div>

<? 
	// Get global variable values if there are any
	if (isset($_POST['submit']))
	{
		$USERNAME = $_COOKIE['USERNAME'];
		$PASSWORD = $_COOKIE['PASSWORD'];
		$submit = $_POST['submit'];
		$oldpasswd = $_POST['oldpasswd'];
		$newpasswd = $_POST['newpasswd'];
		$confirmpasswd = $_POST['confirmpasswd'];
    }
	else
	{
		$submit = "";
	}

	$user = new auth();
	$connection = mysql_connect($dbhost, $dbusername, $dbpass);
	
	// REVISED CODE
	$SelectedDB = mysql_select_db($dbname);
	$userdata = mysql_query("SELECT * FROM authuserWHERE uname='$USERNAME' and passwd='$PASSWORD'");
	
	if ($submit)
	{
		// Check if Old password is the correct
		if ($oldpasswd != $PASSWORD)
		{
			print "<p align=\"center\">";
			print "	<font face=\"Arial\" color=\"#FF0000\">";
			print "		<b>Old password is wrong!</b>";
			print "	</font>";
			print "</p>";
			exit;
		}
		
		// Check if New password if blank
		if (trim($newpasswd) == "")
		{
			print "<p align=\"center\">";
			print "	<font face=\"Arial\" color=\"#FF0000\">";
			print "		<b>New password cannot be blank!</b>";
			print "	</font>";
			print "</p>";
			exit;
		}
				
		// Check if New password is confirmed
		if ($newpasswd != $confirmpasswd)
		{
			print "<p align=\"center\">";
			print "	<font face=\"Arial\" color=\"#FF0000\">";
			print "		<b>New password was not confirmed!</b>";
			print "	</font>";
			print "</p>";
			exit;
		}
		
		// If everything is ok, use auth class to modify the record
		$update = $user->modify_user($USERNAME, $newpasswd, $check["team"], $check["level"], $check["status"]);
		if ($update) {
			print "<p align=\"center\">";
			print "	<font face=\"Arial\" color=\"#FF0000\">";
			print "		<b>Password Changed!</b><br>";
			print "		You will be required to re-login so that your session will recognize the new password. <BR>";
			print "		Click <a href=\"$login\">here</a> to login again.";
			print "	</font>";
			print "</p>";
		}
		
	}	// end - new password field is not empty
?>

</body>
