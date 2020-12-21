<!DOCTYPE html>
<html>
<head><title>Детальная информация</title></head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link rel="stylesheet" href="css/detailsstyle.css">
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

if (!isset($_SESSION['EPLID'])) 
{
	$_SESSION['EPLID']=-1;
}
?>

<script language="javascript">
function AjaxChooseEPL() {
	var epli1 = document.getElementById('EPLInput1').value;
	var epli2 = document.getElementById('EPLInput2').value;
	$.ajax({
		type: "POST",
		url: 'ev_details.php',
		data:{action:'ChooseEPL',epli1:epli1,epli2:epli2},
		success:function(html) {
			alert(html);
			window.location.reload();
		}
	});
}

function AjaxSetKey() {
	var ind1 = document.getElementById('pswd1').value;
	var ind2 = document.getElementById('pswd2').value;
	var ind3 = document.getElementById('pswd3').value;
	$.ajax({
		type: "POST",
		url: 'ev_details.php',
		data:{action:'SetKey',ind1:ind1,ind2:ind2,ind3:ind3},
		success:function(html) {
			//window.location.reload();
		}
	});
}

function AjaxSolveQuest() {
	var sol = document.getElementById('mininum1').value;
	var ind = document.getElementById('mininum2').value;
	$.ajax({
		type: "POST",
		url: 'ev_details.php',
		data:{action:'SolveQuest',ind:ind,sol:sol},
		success:function(html) {
			alert(html);
			window.location.reload();
		}
	});
}

function AjaxHackEnemy(ind) {
	var sol = document.getElementById('mininum1').value;
	$.ajax({
		type: "POST",
		url: 'ev_details.php',
		data:{action:'HackEnemy',ind:ind,sol:sol},
		success:function(html) {
			alert(html);
			window.location.reload();
		}
	});
}

</script>

<div class="MainDiv">

<div class="QuestInfo">
<b>Активные квесты:<br><br></b>
<table border = 1><tr><td><b>Задание</b></td><td><b>Прогресс</b></td></tr>
<?php
$query = 'SELECT qid,currc,goalc FROM t_active_quest where plid='.$_SESSION['ID'];
$result = mysqli_query($db,$query);

while ($line = mysqli_fetch_row($result))
{
	$query2 = 'SELECT msg FROM t_info_quest where id='.$line[0];
	$result2 = mysqli_query($db,$query2);
	$line2 = mysqli_fetch_row($result2);
	
	echo '<tr>';
	echo '<td>'.$line2[0].'</td>';
	echo '<td>'.$line[1].' из '.$line[2].'</td>';
	echo '</tr>';
}
?>
</table>
</div>

<div class="KeysInfo">
<b>Установка паролей:<br></b>
<?php
$query = 'SELECT keyt,keyv FROM t_keys where plid='.$_SESSION['ID'];
$result = mysqli_query($db,$query);
$pswdarr = array(0,0,0);

while ($line = mysqli_fetch_row($result))
{
	$pswdarr[$line[0]] = $line[1];
}
?>

<table>
<tr><td>От сокровищницы </td><td><input type=number id="pswd1" value=<?php echo $pswdarr[1]?>> </td></tr>
<tr><td>От казармы </td><td><input type=number id="pswd2" value=<?php echo $pswdarr[2]?>> </td></tr>
<tr><td>От поздемелья </td><td><input type=number id="pswd3" value=<?php echo $pswdarr[3]?>> </td></tr>
</table>
<input type=button value="Установить" onclick="AjaxSetKey()">
</div>

<div class="ChooseEPL">
<b>Выбрать врага:<br><br></b>
<input type="number" id="EPLInput1" value=0> Сектор<br><br>
<input type="number" id="EPLInput2" value=0> Позиция<br><br>
<input type="button" id="EPLBtn" value="Выбрать" onclick="AjaxChooseEPL()"><br>

<?php
$query = 'SELECT login FROM t_accounts WHERE id='.$_SESSION['EPLID'];
$result = mysqli_query($db,$query);
if ($line = mysqli_fetch_row($result))
{
	echo 'Выбран игрок: '.$line[0];
}
?>
</div>

<div class="KeyDigitsInfo">
<b>Статистика ваших нападений:<br></b>
<textarea cols=37 rows=5>
<?php
$query = 'SELECT keynum,dval FROM t_key_digits WHERE plid='.$_SESSION['ID'].' AND eplid='.$_SESSION['EPLID'];
$result = mysqli_query($db,$query);
while ($line = mysqli_fetch_row($result))
{
	switch ($line[0])
	{
		case 1: echo 'От сокровищницы '.$line[1].'. ';break;
		case 2: echo 'От казармы '.$line[1].'. ';break;
		case 3: echo 'От поздемелья '.$line[1].'. ';break;
	}
}
?>
</textarea>
</div>

<div class="KeyEDigitsInfo">
<b>Статистика нападений на вас:<br></b>
<textarea cols=37 rows=5>
<?php
if (!isset($_SESSION['EPLID'])) 
{
	$_SESSION['EPLID']=-1;
}
$query = 'SELECT keynum FROM t_key_digits WHERE eplid='.$_SESSION['ID'];
$result = mysqli_query($db,$query);
while ($line = mysqli_fetch_row($result))
{
	switch ($line[0])
	{
		case 1: echo 'Подобрана цифра от сокровищницы. ';break;
		case 2: echo 'Подобрана цифра от казармы. ';break;
		case 3: echo 'Подобрана цифра от подземелья. ';break;
	}
}
?>
</textarea>
</div>

<div class="EnterCode">
Введите число: <input type="number" value=0 id="mininum1"><br><br>
<input type="button" value="Решить квест номер" onclick="AjaxSolveQuest()"> <input type="number" value=0 id="mininum2"><br><br>
Взломать объект игрока<br>
<a onclick="AjaxHackEnemy(1)">Сокровищница</a>
<a onclick="AjaxHackEnemy(2)">Казарма</a>
<a onclick="AjaxHackEnemy(3)">Подземелье</a>
</div>

</div>

</body>
</html>

