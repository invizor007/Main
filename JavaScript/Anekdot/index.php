﻿<html>
<head>
<title>Php place of invizor</title>
</head>
<link rel="stylesheet" type="text/css" href="../../../css3.css">
<body>

<h3>Случайный анекдот</h3>
<?
$f = fopen("anekbase.txt", "r");
$i=0;
$arr[$i]="";
while (!feof($f))
	{ 
	$line=fgets($f);
	if (strrpos($line,"#")==1)
		{
		$i++;
		$arr[$i]="";
		}
	else
		{
		$arr[$i].="<br>".$line;
		}
	}
srand((double) microtime()*1000000); 
$i=rand(0,$i);
echo "Анекдот№".($i+1)."<br>".$arr[$i];
?>
<h3><a href=anekbase.html>Все анекдоты</a></h3>
<a href="../../../index.php">
На главную
</a>
</body>
</html>