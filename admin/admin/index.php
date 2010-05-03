<?
/*
# File: admin/index.php
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
    require_once ('../auth.php');
    require_once ('../authconfig.php');
    require_once ('../check.php');

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
?>

<html>
<head>
<title>vAuthenticate Administrative Interface</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<p><font face="Arial, Helvetica, sans-serif" size="5"><b>vAuthenticate Administration</b></font></p>
<table width="75%" border="1" cellspacing="0" cellpadding="0" bordercolor="#000000">
  <tr> 
    <td width="20%" bgcolor="#0099CC" height="16"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2" color="#FFFFCC">Administer</font></b></td>

    <td width="16%" bgcolor="#FFFFCC" height="16"> 
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="authuser.php">Users</a></font></div>
    </td>
    <td width="16%" bgcolor="#FFFFCC" height="16"> 
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="authgroup.php">Groups</a></font></div>
    </td>

    <td width="16%" bgcolor="#FFFFCC" height="16"> 
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><a href="<? echo $logout; ?>">Logout</a></font></div>
    </td>
  </tr>
</table>
<table width="75%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td valign="middle">
      <p>&nbsp;</p>
    </td>
  </tr>
  <tr>
    <td valign="middle"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Welcome 
      to the administration panel of vAuthenticate! Please click on any of the 
      five (5) administrative functions above. Below is a description of each 
      function:</font>

<p><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
<b>Settings</b> - Control site-wide signup and security settings.</font></p>

<p><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
<b>Users</b> - Add, modify, activate/inactivate, delete, and group users.</font></p>

<p><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
<b>Groups</b> - Create, modify, activate/inactivate, and delete groups.</font></p>
      
<p><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
<b>Emailer</b> - Customize profiles for the types of email to be sent for notification.</font></p>

<p><font face="Verdana, Arial, Helvetica, sans-serif" size="2">
<b>Logout</b> - End the current session.</font></p>


    </td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
