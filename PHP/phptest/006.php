<?php
$r=0.0;
$c=0;
for ($i=0;$i<10;$i++)
	{
	$c=rand(0,9);
	$r=0.1*$r+$c;
	}
$r*=0.1;
echo $r;
echo "<br>";

$iMaxRand=31632;
$iRand=rand(1, $iMaxRand);
$fRand=$iRand/$iMaxRand;
echo $fRand;
?>