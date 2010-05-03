<?php

// This is the Panther Radio Interactive Listening Lounge
// This is the scoreboard
// For support contact Ryan Palmer rypalmer@gmail.com

?>

<html>
<head>


<title>Panther Radio Interactive Listening Lounge</title>
</head>
<frameset cols="325,*" resize="no" BORDER=0 FRAMEBORDER=0 FRAMESPACING=0>
    <frame src="fangui-video.php<?if(isset($_GET[display_game_id])){?>?display_game_id=<?=$_GET[display_game_id];}?><?if(isset($_GET[display_home_team])){?>?display_home_team=<?=$_GET[display_home_team];}?>" scrolling="no" resize="no">

<frameset rows="285,*" BORDER=0 FRAMEBORDER=0 FRAMESPACING=0>
    <frame src="embeddedplayer-video.php<?if(isset($_GET[display_game_id])){?>?display_game_id=<?=$_GET[display_game_id];}?><?if(isset($_GET[display_home_team])){?>?display_home_team=<?=$_GET[display_home_team];}?>" scrolling="no" resize="no">
    <frame src="fantalkback.php<?if(isset($_GET[display_game_id])){?>?display_game_id=<?=$_GET[display_game_id];}?><?if(isset($_GET[display_home_team])){?>?display_home_team=<?=$_GET[display_home_team];}?>" scrolling="yes" resize="no">

</frameset>


    <noframes><body>
        <!-- Alternative non-framed version -->
    </body></noframes>

</frameset>
</html>