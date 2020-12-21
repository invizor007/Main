<?php
session_start();
if (!isset($_SESSION['ID']))
{
	echo "<font color=red><b>Сначала войдите в игру <a href='login.php'>тут</a></b></font>";
	exit();
}
$db = mysqli_connect("localhost","bg3user","","bg3");		
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

if ($_POST['action']=='sectornum')
{
	$query = 'SELECT SECTOR FROM t_main_plinfo WHERE ID='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	echo $line[0];
}

if ($_POST['action']=='pointnum')
{
	$query = 'SELECT POINT FROM t_main_plinfo WHERE ID='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	echo $line[0];
}

if ($_POST['action']=='exitgame')
{
	unset($_SESSION['ID']);
	echo 'Вы вышли из игры';
}

if ($_POST['action']=='naym')
{
	$id = $_POST['id'];
	//Запрос количества ресурсов
	$query = 'SELECT gold,meat,bones,energy FROM t_info_unit WHERE ID='.$id;
	$result = mysqli_query($db,$query);
	$rescost = mysqli_fetch_row($result);
	//Присвоение юнита (поиск -> вставка\обновление записи)
	$query = 'SELECT co FROM t_army WHERE plid='.$_SESSION['ID'].' AND uid='.$id;
	$result = mysqli_query($db,$query);
	if (mysqli_fetch_row($result))
	{
		$query = 'UPDATE t_army SET co=co+1 WHERE plid='.$_SESSION['ID'].' AND uid='.$id;
		mysqli_query($db,$query);
	}
	else
	{
		$query = 'INSERT INTO t_army (PLID,UID,CO) VALUES ('.$_SESSION['ID'].','.$id.',1)';
		mysqli_query($db,$query);
	}
	//Уменьшение количества ресурсов
	$query = 'UPDATE t_res SET gold=gold-'.$rescost[0].', meat=meat-'.$rescost[1].', bones=bones-'.$rescost[2].', energy=energy-'.$rescost[3].' WHERE ID='.$_SESSION['ID'];
	mysqli_query($db,$query);
	echo 'Юнит нанят';
}

if ($_POST['action']=='build')
{
	$id = $_POST['id'];
	//Запрос количества ресурсов
	$query = 'SELECT gold,stone FROM t_info_zd WHERE ID='.$id;
	$result = mysqli_query($db,$query);
	$rescost = mysqli_fetch_row($result);
	//Добавить здание в список построенных
	$query = 'INSERT INTO t_buildings (PLID,ZDID,CO) VALUES ('.$_SESSION['ID'].','.$id.',1)';
	mysqli_query($db,$query);
	//Уменьшение количества ресурсов
	$query = 'UPDATE t_res SET gold=gold-'.$rescost[0].', stone=stone-'.$rescost[1].' WHERE ID='.$_SESSION['ID'];
	mysqli_query($db,$query);
	echo 'Здание построено';
}
?>

