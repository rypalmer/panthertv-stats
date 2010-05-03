<?php

	date_default_timezone_set('America/Halifax');

$years = date("Y");
$months = date("m");
$days = date("d");
$hours = date("G");
$minutes = date("i");
$seconds = date("s");
$daysthismonth = date("t");

$hours = $hours + 10;

if($hours >= 13)
{
$hours = $hours - 24;
$days = $days + 1;
}

if($days > $daysthismonth)
{$days = $days - $daysthismonth;
$months = $months + 1;}

if($months > 12)
{$months = $months - 12;
$years = $years + 1;}

$tenhourslater = $years . "-" . $months . "-" . $days . " " . $hours . ":" . $minutes . ":" . $seconds;

echo $tenhourslater, "<br>\n";


?>
