<!DOCTYPE html>
<html>
<head><title>Информация об игре</title></head>
<script type="text/javascript" src="jquery.min.js"></script>
<link rel="stylesheet" href="css/mainstyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">

<?php

/////Получение данных о состоянии игры

session_start(); 
//$_SESSION['ID']=1;$_SESSION['GameId']=1;$_SESSION['plnum']=1;$_SESSION['placepl']=2;//Временно
if (!isset($_SESSION['ID']))
{
	echo "<font color=red><b>Сначала войдите в игру <a href='login.php'>тут</a></b></font>";
	exit();
}

if (!isset($_SESSION['GameId']))
{
	echo "<font color=red><b>Сначала войдите в игру <a href='login.php'>тут</a></b></font>";
	exit();
}

if (!isset($_SESSION['SeeGameId']))
{
	$_SESSION['SeeGameId'] = $_SESSION['GameId'];
}


$db = mysqli_connect("localhost","KBRoot","","kgbnt");		
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

if (!isset($_SESSION['SeeID']))
{
	$_SESSION['SeeID'] = $_SESSION['ID'];
}

?>

<script language="javascript">


function StartGame()
{
	$.ajax({
			type: "POST",
			url: 'ev_control.php',
			data:{action:'start_game'},
			success:function(html) {
				alert(html);
			}
		});	
	location.reload();
}

function ChooseGame(i)
{
	var v_gmnum = <?echo $_SESSION['SeeGameId']?>;
	$.ajax({
			type: "POST",
			url: 'ev_control.php',
			data:{action:'choose_game',plnum:i,gmnum:v_gmnum},
			success:function(html) {
				alert(html);
			}
		});	
	location.reload();
}

function SeeGame()
{
	var v_seegameid = 0;
	v_seegameid = document.getElementById("inpchgame").value;
	
	$.ajax({
			type: "POST",
			url: 'ev_control.php',
			data:{action:'see_game',SeeGameId:v_seegameid},
			success:function(html) {
				alert(html);
			}
		});	
	location.reload();
}

//PanelInfo, PanelYouCard, PanelUsedCardArea, PanelCardList, PanelFrontCard

</script>

<body>

<div class = "PanelGameView">
<?php
$query = 'SELECT val FROM t_gm_temp WHERE code="PLCO" AND gm_id='.$_SESSION['SeeGameId'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$plco = $line[0];

$query = 'SELECT val FROM t_gm_temp WHERE code="STEP" AND gm_id='.$_SESSION['SeeGameId'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$step = $line[0];
$stepstat = "";
if ($step==0) $stepstat = " Игры с таким номером не существует ";
if ($step==1) $stepstat = " <b>В процессе создания</b> ";
if ($step==2) $stepstat = " <b>Начата</b> ";
if ($step==3) $stepstat = " <b>Завершена</b> ";

echo 'Найти игру: ';
echo '<input name="inpchgame" class="Inp1" id="inpchgame" type="number" value='.$_SESSION['SeeGameId'].'>';
echo '<input name="btnchgame" class="KBBTN" id="btnchgame" type="button" value="Смотреть" onclick=SeeGame()><br>';
echo 'Игра номер '.$_SESSION['SeeGameId'].$stepstat.'<br>';

echo 'Количество игроков '.$plco.'<br><br>';
echo '<table border=2>';
for ($i=1;$i<=$plco;$i++)
{
	echo '<tr>';
	$query = 'SELECT humflg,score FROM t_gm_pl WHERE plnum='.$i.' AND gm_id='.$_SESSION['SeeGameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	if (!isset($line[0])) $line[0]="N";
	if (!isset($line[1])) $line[1]="0";
	
	if ($step==1)
	{		
		if ($line[0]=="N")
			$str1 = '<a onclick=ChooseGame('.$i.')>Присоединиться</a>';
		else
			$str1 = ' Занято ';
		echo '<td>'.' <b> Игрок номер '.$i.'</b> </td> <td>'.$str1.'</td>';
	}
	if ($step==2)
	{
		if ($line[0]=="N")
			$str1 = ' Компьютерный игрок ';
		else
			$str1 = ' Игрок Человек ';
		echo '<td>'.' <b> Игрок номер '.$i.'</b> </td> <td>'.$str1.'</td>';
	}
	if ($step==3)
	{
		if ($line[0]=="N")
			$str1 = ' Компьютерный игрок ';
		else
			$str1 = ' Игрок Человек ';
		echo '<td>'.' <b> Игрок номер '.$i.'</b> </td> <td>'.$str1.'</td> <td> Счет '.$line[1].'</td>';
	}	
	

	echo '</tr>';
}
echo '</table>';

if ($step==1)
{
	echo '<input name="btnstart" class="KBBTN" id="btnstart" type="button" value="Начать игру" onclick=StartGame()><br>';
}

//tit
echo '<b> Титулы: </b><br>';
$query = 'SELECT num FROM t_gm_tit WHERE GM_ID='.$_SESSION['SeeGameId'];
$result1 = mysqli_query($db,$query);

while ($line1 = mysqli_fetch_row($result1))
{
	$str1 = 'img/tit/'.$line1[0].'.jpg';
	echo '<img src='.$str1.'>';
}
?>
</div>


</body>
</html>
