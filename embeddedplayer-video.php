<?php

	// This file is still currently in development

      // For information, contact Ryan Palmer (rypalmer@gmail.com)
      // Built July 2006 - by Ryan Palmer

	// For what home team should I play the stream for?

if(isset($_GET[display_home_team]))
{

	$display_home_team = $_GET[display_home_team];
	
	if($display_home_team == 1)
	{
	// Play Acadia's stream
//	echo "we are playing the acadia stream";
	$stream = "http://beat2.upei.ca/pantherradio.asx";
	}
	else if($display_home_team == 2)
	{
	// Play Dalhousie's stream
//	echo "we are playing the dal stream";
	$stream = "http://beat2.upei.ca/pantherradio.asx";
	}
	else if($display_home_team == 3)
	{
	// Play St Thomas's stream
//	echo "we are playing the st thomas stream";
	$stream = "http://beat2.upei.ca/pantherradio.asx";
	}
	else if($display_home_team == 4)
	{
	// Play St Mary's stream
//	echo "we are playing the st marys stream";
	$stream = "http://beat2.upei.ca/pantherradio.asx";
	}
	else if($display_home_team == 5)
	{
	// Play St FX's stream
//	echo "we are playing the st fx stream";
	$stream = "http://beat2.upei.ca/pantherradio.asx";
	}
	else if($display_home_team == 6)
	{
	// Play UNB's stream
//	echo "we are playing the unb stream";
	$stream = "http://beat2.upei.ca/pantherradio.asx";
	}
	else if($display_home_team == 7)
	{
	// Play U de M's stream
//	echo "we are playing the u de m stream";
	$stream = "http://beat2.upei.ca/pantherradio.asx";
	}
	else if($display_home_team == 8)
	{
	// Play UPEI's stream
//	echo "we are playing the UPEI stream";
	$stream = "http://beat2.upei.ca/pantherradio.asx";
	}
	else if($display_home_team == 20)
	{
	// Play UPEI's stream
//	echo "we are playing the UPEI stream";
	$stream = "http://beat2.upei.ca/pantherradio-b.asx";
	}
	else if($display_home_team == 30)
	{
	// Play UPEI's stream
//	echo "we are playing the UPEI stream";
	$stream = "http://beat2.upei.ca/pantherradio-b.asx";
	}
}
else
{
//	echo "we are playing the default stream perhaps radioatupei";
	$stream = "http://beat2.upei.ca/pantherradio-b.asx";
}	



?>

<html>
<head>
<title>Panther Radio Listening Lounge 2.0 - Game Control</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#EDD175"><center>
<!--
<OBJECT ID="WMP7" CLASSID="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6">
    <PARAM NAME="URL" VALUE="mms://beat2.upei.ca:8026/RadioUPEI">
</OBJECT>
-->
<p>We're experimenting with video tonight. If you have a highspeed connection, try clicking the link below.</p>
<p><strong><a href="mms://beat2.upei.ca:8026/RadioUPEI">Click here to launch the video!</a></strong></p>
<p>Try copying and pasting the link into Windows Media Player or Real Player if it won't launch. Let us know if you have any problems connecting!</p>

<!--<script>
 var is_mac = ((navigator.appVersion.indexOf("Mac") != -1) || (navigator.appVersion.indexOf("mac") != -1));
 if (is_mac) {
   document.write('<FONT SIZE=1 COLOR=white FACE="Arial, Helvetica,sans-serif">Your browser should prompt you to open<BR> the Windows Media content in this page<BR> in the Windows Media Player.<BR>If your browser does not, <A HREF="http://beat2.upei.ca/pantherradio.asx">click here</A>.</FONT>');
 } else {
   document.write('<EMBED TYPE="application/x-mplayer2" PLUGINSPAGE="http://www.microsoft.com/windows/windowsmedia/download/" SRC="<?=$stream;?>"  NAME=MediaPlayer SHOWCONTROLS=1 SHOWSTATUSBAR=1 AUTOSTART=1 WIDTH=298 HEIGHT=70></EMBED>');
 }</script>-->


</center>
</body>
</html>