<!DOCTYPE html>
<html>
<head><title>История похода</title></head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link rel="stylesheet" href="css/reportstyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">

<?php
session_start();$_SESSION['ID']=1;//временно
if (!isset($_SESSION['ID']))
{
	echo "Сначала войдите в игру <a href='login.php'>тут</a>";
	exit();
}
$db = mysqli_connect("localhost","bg3user","","bg3");		
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}
?>

<div class="PanelYArmy">
<?php
if ( (isset($_SESSION['RepStat'])) and (isset($_SESSION['RepFight'])) )
{
	$unitimgname = array (1=>'1.png',2=>'2.png',3=>'3.png',4=>'4.png',5=>'5.png',6=>'6.png',7=>'7.png');
	$query = 'SELECT rid,val FROM t_report WHERE rtype=1 and plid='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	echo 'Ваша<br>армия:<br>';
	while ($line = mysqli_fetch_row($result))
	{
		$uid = $line[0];
		$co = $line[1];
	
		$query2 = 'SELECT name FROM t_info_unit WHERE id='.$uid;
		$result2 = mysqli_query($db,$query2);
		$line2 = mysqli_fetch_row($result2);
			
		echo '<img src=img/units/'.$unitimgname[$uid].'></img>';
		echo $co.'<br>';	
	}	
}
else
{
	$unitimgname = array (1=>'1.png',2=>'2.png',3=>'3.png',4=>'4.png',5=>'5.png',6=>'6.png',7=>'7.png');
	$query = 'SELECT uid,co FROM t_army WHERE plid='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	echo 'Ваша<br>армия:<br>';
	while ($line = mysqli_fetch_row($result))
	{
		$uid = $line[0];
		$co = $line[1];
	
		$query2 = 'SELECT name FROM t_info_unit WHERE id='.$uid;
		$result2 = mysqli_query($db,$query2);
		$line2 = mysqli_fetch_row($result2);
			
		echo '<img src=img/units/'.$unitimgname[$uid].'></img>';
		echo $co.'<br>';	
	}		
}

?>
</div>

<div class="PanelEArmy">
<?php
if ( (isset($_SESSION['RepStat'])) and (isset($_SESSION['RepFight'])) )
{
	$unitimgname = array (1=>'1.png',2=>'2.png',3=>'3.png',4=>'4.png',5=>'5.png',6=>'6.png',7=>'7.png');
	$query = 'SELECT rid,val FROM t_report WHERE rtype=2 and plid='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	echo 'Вражеская<br>армия:<br>';
	while ($line = mysqli_fetch_row($result))
	{
		$uid = $line[0];
		$co = $line[1];
	
		$query2 = 'SELECT name FROM t_info_unit WHERE id='.$uid;
		$result2 = mysqli_query($db,$query2);
		$line2 = mysqli_fetch_row($result2);
			
		echo '<img src=img/units/'.$unitimgname[$uid].'></img>';
		echo $co.'<br>';	
	}	
}
else
{
	echo 'Вражеская<br>армия:<br><br><br>';
	echo 'Сражения<br>не было';
}

?>
</div>

<div class="PanelRArmy">
<?php
if ( (isset($_SESSION['RepStat'])) and (isset($_SESSION['RepFight'])) )
{
	$unitimgname = array (1=>'1.png',2=>'2.png',3=>'3.png',4=>'4.png',5=>'5.png',6=>'6.png',7=>'7.png');
	$query = 'SELECT rid,val FROM t_report WHERE rtype=3 and plid='.$_SESSION['ID'];//rtype=3
	$result = mysqli_query($db,$query);
	echo 'Остаток<br>армии:<br>';
	while ($line = mysqli_fetch_row($result))
	{
		$uid = $line[0];
		$co = $line[1];
	
		$query2 = 'SELECT name FROM t_info_unit WHERE id='.$uid;
		$result2 = mysqli_query($db,$query2);
		$line2 = mysqli_fetch_row($result2);
			
		echo '<img src=img/units/'.$unitimgname[$uid].'></img>';
		echo $co.'<br>';	
	}
}
?>
</div>

<div class="LabelVS">VS</div>
<div class="LabelAR1">=></div>

<div class="LabelBS">
<?php
if (isset($_SESSION['RepStat']))
{
	echo $_SESSION['RepStat'];
}
else
{
	echo 'Последних действий не было';
}
?>
</div>

<div class="LabelF1">
<?php
if (isset($_SESSION['YForce']))
{
	echo 'Сила:<br>'.$_SESSION['YForce'];
}
?>
</div>

<div class="LabelF2">
<?php
if (isset($_SESSION['LEForce']))
{
	echo 'Сила:<br>'.$_SESSION['LEForce'];
}
?>
</div>

<div class="LabelF3">
<?php
if (isset($_SESSION['NYForce']))
{
	echo 'Сила:<br>'.$_SESSION['NYForce'];
}
?>
</div>

<div class="PanelBonuses">
<?php
echo 'Полученные<br>бонусы:<br>';
if (isset($_SESSION['RepStat']))
{
	$query = 'SELECT rid,val FROM t_report WHERE rtype=4 and plid='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);

	while ($line = mysqli_fetch_row($result))
	{
		$rid = $line[0];
		$co = $line[1];
		$bname = 'Бонус';
		switch ($rid)
		{
			case 1: $bname = 'Золото';break;
			case 2: $bname = 'Мясо';break;
			case 3: $bname = 'Кости';break;
			case 4: $bname = 'Энергия';break;
			case 5: $bname = 'Камень';break;
		}
			
		echo $bname.'('.$co.')шт.<br>';	
	}
}
else
{
	echo 'Бонусы отсуствуют';
}
?>
</div>

<div class="PanelBattleRes">
<?php
echo 'Ресурсы<br>за битву:<br>';
if (isset($_SESSION['BMEAT']))
{
	echo 'Мясо '.$_SESSION['BMEAT'].'<br>';
}
if (isset($_SESSION['BBONES']))
{
	echo 'Кости '.$_SESSION['BBONES'];
}
?>
</div>

</body>
</html>

