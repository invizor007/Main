<html>
<head>
<title>Kings Bounty</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/loginstyles.css">

<body>
<div class="PanelGameName">
Kings Bounty
</div>

<div class="PanelInfo">
<?php
$db = mysqli_connect("localhost","KBRoot","","kgbnt");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}
mysqli_set_charset($db, 'utf8');
$PagesCo = 6;


echo 'Информация об игре "Kings Bounty:"';
echo '<br><br>';

if (!isset($_GET['page'])) $_GET['page']=0;
if ($_GET['page']==0)
{
	echo 'Kings Bounty  - компьютерная версия одноименной настольной игры<br>';
	echo '<h4>Коротко об игре:</h4>';
	echo '<p>';
	echo 'Цель игры - развитие и захват замков и обелисков ';
	echo 'В игре 5 фракций, несколько типов юнитов';
	echo 'Необходимо захватить больше зданий согласно заданиям победных очков.';
	echo '</p>';
}

if ($_GET['page']==1)
{
	echo 'Ход игры: сыграть карту и взять новую <br>';
	echo 'Здания и обелиски выкладываются перед игроком.';
	echo 'Юниты используются на здание и некоторые могут остаться как его охрана.';

}

if ($_GET['page']==2)
{
	echo 'Здания: <br>';
	$query = 'SELECT t2.name,t1.fval,t1.name FROM t_info_bname t1,t_info_fname t2 WHERE t1.fid=t2.id';
	$result = mysqli_query($db,$query);
	echo '<ul>';
	while ($line = mysqli_fetch_row($result))
	{
		echo '<li>Фракция <b>'.$line[0].'</b> Здание сила <b>'.$line[1].'-'.$line[2].'</b><br>';
	}
	echo '</ul>';
}



if ($_GET['page']==3)
{
	echo 'Юниты: <br>';
	$query = 'SELECT t2.name,t1.fval,t1.name FROM t_info_uname t1,t_info_fname t2 WHERE t1.fid=t2.id and t2.id<=2';
	$result = mysqli_query($db,$query);
	echo '<ul>';
	while ($line = mysqli_fetch_row($result))
	{
		echo '<li>Фракция <b>'.$line[0].'</b> Юнит сила <b>'.$line[2].'-'.$line[1].'</b><br>';
	}
	echo '</ul>';
}

if ($_GET['page']==4)
{
	echo 'Юниты: <br>';
	$query = 'SELECT t2.name,t1.fval,t1.name FROM t_info_uname t1,t_info_fname t2 WHERE t1.fid=t2.id and t2.id>=3';
	$result = mysqli_query($db,$query);
	echo '<ul>';
	while ($line = mysqli_fetch_row($result))
	{
		echo '<li>Фракция <b>'.$line[0].'</b> Юнит сила <b>'.$line[1].'-'.$line[2].'</b><br>';
	}
	echo '</ul>';
}

if ($_GET['page']==5)
{
	echo '<br><br>';
	echo 'Исходный код игры открыт, вы можете использовать его в своих проектах. Желаю успеха во всех начинаниях. ';
}

?>
</div>

<div class="PanelNav">

<?php
$num = $_GET['page'];
if ($num==0)
	{ echo '<input type = button value = "Предыдущее" class="btn">'; }
else
{
	$s = "info.php?page=".($num-1);
	echo '<input type = button value = "Предыдущее" class="btn btn-success" onClick = javascript:document.location.href="'.$s.'">';
}

echo '&nbsp;&nbsp;&nbsp;';

$s = 'game.php';
echo '<input type = button value = "Назад к игре" class="btn btn-success" onClick = javascript:document.location.href="'.$s.'">';

echo '&nbsp;&nbsp;&nbsp;';

if ($num==5)
	{ echo '<input type = button value = "Следующее" class="btn">'; }
else
{
	$s = "info.php?page=".($num+1);
	echo '<input type = button value = "Следующее" class="btn btn-success" onClick = javascript:document.location.href="'.$s.'">';
}
?>

</div>

</body>

</html>