<?
/*
# File: members/index.php
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
# post office) them to:
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
?>

<html>
<head>
<title>Panther Radio Listening Lounge Administration</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<p><font face="Arial, Helvetica, sans-serif" size="5"><b>Panther Radio Listening Lounge 
  User Login Results</b></font></p>
<table width="60%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr bgcolor="#000066"> 
    <td colspan="2"> 
      <div align="center"><font color="#FFFFCC"><b><font face="Arial, Helvetica, sans-serif" size="3">Results 
	</font></b></font></div>
    </td>
  </tr>
  <tr> 
    <td width="16%" bgcolor="#0099CC"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">ID</font></b></td>
    <td width="84%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp; <? echo $check["id"] ?></font></td>
  </tr>
  <tr> 
    <td width="16%" bgcolor="#0099CC"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Username</font></b></td>
    <td width="84%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp; <? echo $check["uname"] ?></font></td>
  </tr>

  <tr> 
    <td width="16%" bgcolor="#0099CC"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password</font></b></td>
    <td width="84%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp; <? echo $_COOKIE['PASSWORD'] ?> &nbsp;&nbsp;<a href="<? echo $changepassword; ?>">Change</a></font></td>
  </tr>

  <tr> 
    <td width="16%" bgcolor="#0099CC"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Team</font></b></td>
    <td width="84%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp; <? echo $check["team"] ?></font></td>
  </tr>
  <tr> 
    <td width="16%" bgcolor="#0099CC"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Level</font></b></td>
    <td width="84%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp; <? echo $check["level"] ?></font> </td>
  </tr>
  <tr> 
    <td width="16%" bgcolor="#0099CC"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Status</font></b></td>
    <td width="84%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp; <? echo $check["status"] ?></font></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="60%" border="1" cellspacing="0" cellpadding="0" bordercolor="#000000">
  <tr> 
    <td height="22" colspan="2" bgcolor="#CCCC00"> 
      <div align="center"><b><font face="Arial, Helvetica, sans-serif" size="3">Panther
	Radio Listening Lounge Adminstration</font></b></div>
    </td>
  </tr>
  <tr valign="top"> 
    <td width="16%" bgcolor="#CCCCCC"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
      <a href="gamestaff.php">Game Staff Page</a></font></b></td>
    <td width="84%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Go here when its
	gametime and you want to administer the game.</font></td>
  </tr>
  <tr valign="top"> 
    <td width="16%" bgcolor="#CCCCCC"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
	<a onclick="MyWindow=window.open('http://stats.upeiism.org/index.php?display_home_team=<?$team_editors = $check['level'] - 100; echo $team_editors;?>','MyWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=no,width=730,height=420'); return false;" href="#">
	Popop Listening Lounge</a></font></b></td>
    <td width="84%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">This is a preview of your team's 
	Live Listening Lounge.</font></td>
  </tr>
</table>
<p>&nbsp;</p>
<table width="60%" border="1" cellspacing="0" cellpadding="0" bordercolor="#000000">
  <tr bgcolor="#CCCCCC"> 
    <td colspan="2"> 
      <div align="center"><font face="Arial, Helvetica, sans-serif"><b><font size="3">Field 
        Description</font></b></font></div>
    </td>
  </tr>
  <tr valign="top"> 
    <td width="16%"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">ID</font></b></td>
    <td width="84%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Unique 
      identifier. This is not editable even by the administrator</font></td>
  </tr>
  <tr valign="top"> 
    <td width="16%"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Username</font></b></td>
    <td width="84%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">A 
      unique identifier chosen by the user during signup process OR a unique identifier 
      given by the administrator to the user. The administrator has the power 
      to change this when needed.</font></td>
  </tr>
  <tr valign="top"> 
    <td width="16%"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Password</font></b></td>
    <td width="84%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">A 
      security requirement whose value depends on either the user OR the administrator. 
      The administrator has the power to change this when needed.</font></td>
  </tr>
  <tr valign="top"> 
    <td width="16%"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Team</font></b></td>
    <td width="84%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">A 
      group to which the specified user is a part of. This is used to simplify 
      mass status modification. A user cannot be a member of 2 or more teams.</font></td>
  </tr>
  <tr valign="top"> 
    <td width="16%"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Level</font></b></td>
    <td width="84%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">This 
      is the level of power that a user posses. The administrator has the option 
      to set the number of levels available. 1 is the highest, which usually pertains 
      to system administrators and sometimes, web masters.</font></td>
  </tr>
  <tr> 
    <td width="16%"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Status</font></b></td>
    <td width="84%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">This 
      can either be ACTIVE or INACTIVE. Inactive accounts cannot log into the 
      system. An inactive account can be activated by the administrator or someone 
      with administrative privileges.</font></td>
  </tr>
</table>
<p><font face="Verdana" size=2>Click <a href="<? echo $logout; ?>">here<a> to logout.</font></p>
