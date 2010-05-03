<?php
/*
# File: login.php
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
<?php include_once ("authconfig.php"); ?>
<html>
<head>
<title>UPEI ISM Listener Lounge Administration Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css" media="all">@import "style.css";</style>
</head>

<body >
<div id="container"><p>&nbsp;</p>
<center><h2>Login</h2>
<p>&nbsp;</p>
<form name="Sample" method="post" action="<?php print $resultpage ?>">
  <table width="40%" border="1" cellpadding="0" cellspacing="0" >
    <tr> 
      <td colspan="2" bgcolor="#FFFFCC" valign="middle"> 
        <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="3"><b>Panther Radio Listening Lounge Administration</b></font></div>
    </td>
  </tr>
    <tr> 
      <td width="32%" bgcolor="#CCCCCC" valign="middle"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;Username</font></b></td>
      <td width="68%" valign="middle"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
        &nbsp;
<input type="text" name="username" size="15" maxlength="15">
        </font></b></td>
  </tr>
    <tr> 
      <td width="32%" bgcolor="#CCCCCC" valign="middle"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;Password</font></b></td>
      <td width="68%" valign="middle"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
        &nbsp;
<input type="password" name="password" size="15" maxlength="15">
        </font></b></td>
  </tr>
    <tr valign="middle" bgcolor="#CCCCCC"> 
      <td colspan="2"> 
        <div align="center">
          <input type="submit" name="Login" value="Login">
          <input type="reset" name="Clear" value="Clear">
        </div>
      </td>
  </tr>
    <tr valign="middle" bgcolor="#CCCCCC"> 
      <td colspan="2"> 
        <div align="center">
		For support, contact <a href="mailto:upeiism@gmail.com">UPEI ISM</a>
        </div>
      </td>
  </tr>
</table>
</form></center>

<p>&nbsp;</p>
</div>
</body>
</html>
