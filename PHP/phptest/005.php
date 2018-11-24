<?php
$one = "Один";
$two = "Два";
$three = "Три";

$numbers=array($one,$two,$three);
$current=$one;
echo current($numbers);
echo "<br>";
echo next($numbers);
?>