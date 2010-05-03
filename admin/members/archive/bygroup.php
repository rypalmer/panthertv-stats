<?
/*
# File: members/bygroup.php
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
<html>
<head>
<?php
	include_once ("../auth.php");
	include_once ("../authconfig.php");
	include_once ("../check.php");

    if (!($check['team']=='Group 1') && !($check['team']=='Group 3'))
    {
        echo 'You are not allowed to access this page.';
		exit();
    }
?>

<title>vAuthenticate Sample Member Page</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000">
<table width="84%" border="1" cellspacing="0" cellpadding="0">
  <tr> 
    <td colspan="2" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><font size="3">vAuthenticate: 
      Sample Authentication Page</font></b></font></td>
  </tr>
  <tr> 
    <td width="27%" valign="top"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Access 
      Restriction:</font></b></td>
    <td width="73%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Per 
      Group - Any Level</font></td>
  </tr>
  <tr> 
    <td width="27%" valign="top"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Access 
      Rights:</font></b></td>
    <td width="73%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Group 
      1, Group 3</font></td>
  </tr>
  <tr> 
    <td width="27%" valign="top"><b><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Details:</font></b></td>
    <td width="73%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Only 
      members of Group 1 and Group 3 are allowed to see this page (unless you've 
      changed the code). This is an example of a page being secured on a per-group 
      basis. </font></td>
  </tr>
  <tr> 
    <td width="27%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Code:</b></font></td>
    <td width="73%" valign="top"> 
      <p><font face="Verdana, Arial, Helvetica, sans-serif" size="2">The following 
        code snippet is an example of how to implement this type of access restriction. 
        Put this code on top of your pages which will be governed by this type 
        of security. Please note that this is only an example and you would need 
        to make certain adjustments based on your preferences. Here's the code 
        snippet: </font></p>
      <p>
	  <blockquote> 
        <p><font color="#000099" face="Courier New, Courier, mono" size="2">&lt;?php</font><font face="Courier New, Courier, mono" size="2"><br>
          &nbsp;&nbsp;include_once</font><font color="#000099" face="Courier New, Courier, mono" size="2"> 
          (&quot;../auth.php&quot;);<br>
          &nbsp;&nbsp;</font><font face="Courier New, Courier, mono" size="2">include_once</font><font color="#000099" face="Courier New, Courier, mono" size="2"> 
          (&quot;../authconfig.php&quot;);<br>
          &nbsp;&nbsp;</font><font face="Courier New, Courier, mono" size="2">include_once</font><font color="#000099" face="Courier New, Courier, mono" size="2"> 
          (&quot;../check.php&quot;); </font></p>
        <p><font color="#000099" face="Courier New, Courier, mono" size="2">&nbsp;&nbsp;</font><font face="Courier New, Courier, mono" size="2">if</font><font color="#000099" face="Courier New, Courier, mono" size="2"> 
          (!($check['team']=='Group 1') && !($check['team']=='Group 3'))<br>
          &nbsp;&nbsp;{<br>
          &nbsp;&nbsp;&nbsp;&nbsp;</font><font face="Courier New, Courier, mono" size="2">echo</font><font color="#000099" face="Courier New, Courier, mono" size="2"> 
          'You are not allowed to access this page.';<br>
          &nbsp;&nbsp;&nbsp;&nbsp;</font><font face="Courier New, Courier, mono" size="2">exit()</font><font color="#000099" face="Courier New, Courier, mono" size="2">;<br>
          &nbsp;&nbsp;}</font><font face="Courier New, Courier, mono" size="2"><br>
          <font color="#000099">?&gt;</font></font></p>
      </blockquote> </td>
  </tr>
</table>
</body>
</html>
