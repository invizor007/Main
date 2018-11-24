<?php
$str1="a ab abc abcd abcde abcdef";
$str2="";
echo $str1;
$strs=explode(" ",$str1);
for ($i=0;$i<count($strs);$i++)
	{
	for ($j=strlen($strs[$i])-1;$j>0;$j--)
		if ($j%3==0) {$strs[$i]=substr_replace($strs[$i], ' ', $j, 0);}
	}
$str2=implode(" ", $strs);
echo "<br>";
echo $str2;
?>