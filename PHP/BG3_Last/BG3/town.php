<!DOCTYPE html>
<html>
<head><title>Ваш город</title></head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link rel="stylesheet" href="css/mainstyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">

<?php
session_start();
if (!isset($_SESSION['ID']))
{
	echo "<font color=red><b>Сначала войдите в игру <a href='login.php'>тут</a></b></font>";
	exit();
}
$unitimgname = array (1=>'1.png',2=>'2.png',3=>'3.png',4=>'4.png',5=>'5.png',6=>'6.png',7=>'7.png');
$zdimgname = array (1=>'1.png',2=>'2.png',3=>'3.png',4=>'4.png',5=>'5.png',6=>'6.png',7=>'7.png');

$db = mysqli_connect("localhost","bg3user","","bg3");		
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

$query = 'SELECT value FROM t_game_const where name="COUNTZD"';
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$zdcount = $line[0];

$query = 'SELECT value FROM t_game_const where name="COUNTU"';
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$ucount = $line[0];

$zdstat = array($zdcount);
$ustat = array($ucount);

//количество ресурсов у игрока
$query = 'SELECT gold,meat,bones,energy,stone FROM t_res WHERE id='.$_SESSION['ID'];
$result = mysqli_query($db,$query);
$plres = mysqli_fetch_row($result);

//Определение какие здания доступны для строительства
for ($i=1;$i<=$zdcount;$i++)
{
	$zdstat[$i]=0;
	$query = 'SELECT gold,stone FROM t_info_zd where id='.$i;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	if ($line[0]>$plres[0]) $zdstat[$i]=1;
	if ($line[1]>$plres[4]) $zdstat[$i]=1;
	
	$query = 'SELECT count(1) FROM t_buildings WHERE plid='.$_SESSION['ID'].' AND zdid='.$i;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	if ($line[0]>0) {$zdstat[$i]=2;}
}

//Определение каких юнитов можно нанять
for ($i=1;$i<=$ucount;$i++)
{
	$ustat[$i]=0;
	$query = 'SELECT gold,meat,bones,energy FROM t_info_unit where id='.$i;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	if ($line[0]>$plres[0]) $ustat[$i]=1;
	if ($line[1]>$plres[1]) $ustat[$i]=1;
	if ($line[2]>$plres[2]) $ustat[$i]=1;
	if ($line[3]>$plres[3]) $ustat[$i]=1;
	
	//требования по наличию определенных зданий
	$query = 'SELECT zdid FROM t_info_requzd WHERE uid='.$i;
	$result = mysqli_query($db,$query);
	while ($line = mysqli_fetch_row($result))
	{
		if ($zdstat[$line[0]]!=2)
		{
			$ustat[$i]=2;
		}
	}		
}
?>

<script language="javascript">
function AjaxSectorNum() {
      $.ajax({
           type: "POST",
           url: 'ev_town.php',
           data:{action:'sectornum'},
           success:function(html) {
			 alert(html);
           }

      });
 }
 
function AjaxPointNum() {
      $.ajax({
           type: "POST",
           url: 'ev_town.php',
           data:{action:'pointnum'},
           success:function(html) {
			 alert(html);
           }

      });
 }
 
function ExitGame() {
      $.ajax({
           type: "POST",
           url: 'ev_town.php',
           data:{action:'exitgame'},
           success:function(html) {
			 alert(html);
			 window.location.reload();
           }

      });
 }
 
function AjaxNaym(ind) {
      $.ajax({
           type: "POST",
           url: 'ev_town.php',
           data:{action:'naym',id:ind},
           success:function(html) {
			 alert(html);
			 window.location.reload();
           }

      });
 }
 
function AjaxBuild(ind) {
	  if (!confirm("Вы действительно хотите построить здание?")) return;
      $.ajax({
           type: "POST",
           url: 'ev_town.php',
           data:{action:'build',id:ind},
           success:function(html) {
			 alert(html);
			 window.location.reload();
           }

      });
 }
 
 
function NoBuildAlert(ind){
	if (ind==1) alert("Недостаточно ресурсов для строительства");
	if (ind==2) alert("Здание уже построено");
	return;
}

function NoNaymAlert(ind){
	if (ind==1) alert("Недостаточно ресурсов для найма юнита");
	if (ind==2) alert("Нет необходимых зданий для найма юнита");
	return;
}

function ToSector(){
	location.href='sector.php';
}

function ToMap(){
	location.href='world.php';
}
</script>

<body>

<div class = "PanelRes">
<?php
	$query = 'SELECT gold,meat,bones,energy,stone FROM t_res WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	echo 'Ваши ресурсы:<br>';
	echo 'Золото: '.$line[0].'<br>';
	echo 'Мясо: '.$line[1].'<br>';
	echo 'Кости: '.$line[2].'<br>';
	echo 'Энергия: '.$line[3].'<br>';
	echo 'Камень: '.$line[4].'<br>';
?>
</div>

<div class = "PanelArmy">
<?php
$query = 'SELECT uid,co FROM t_army WHERE plid='.$_SESSION['ID'];
$result = mysqli_query($db,$query);
echo 'Ваша армия:<br>';
echo '<table>';
while ($line = mysqli_fetch_row($result))
{
	echo '<tr>';
	$uid = $line[0];
	$co = $line[1];
	
	$query2 = 'SELECT name FROM t_info_unit WHERE id='.$uid;
	$result2 = mysqli_query($db,$query2);
	$line2 = mysqli_fetch_row($result2);
			
	echo '<td><img src=img/units/'.$unitimgname[$uid].'></img><td>';
	echo '<td>'.$line2[0].' '.$co.'шт.</td>';
	echo '</tr>';
}
echo '</table>'
?>
</div>

<div class = "PanelBuild">
<?php 
echo 'Построить здание:<br>';
for ($i=1;$i<=$zdcount;$i++)
{
	$query2 = 'SELECT name FROM t_info_zd WHERE id='.$i;
	$result2 = mysqli_query($db,$query2);
	$line2 = mysqli_fetch_row($result2);
	if ($zdstat[$i]==0)
	{
		echo '<div class="ObjZdB"><img src=img/zd/'.$zdimgname[$i].' onclick=AjaxBuild('.$i.')></img>';
	}
	else
	{
		echo '<div class="ObjZdB"><img src=img/zd/'.$zdimgname[$i].' onclick=NoBuildAlert('.$zdstat[$i].')></img>';
	}
	
	$fontstr = '<font color=green>';
	if ($zdstat[$i]==1) $fontstr = '<font color=red>';
	if ($zdstat[$i]==2) $fontstr = '<font color=yellow>';
	echo '<b> '.$fontstr.$line2[0].'</font></b></div>';
}
?>
</div>

<div class="PanelNaym">
<?php
echo 'Нанять юнитов:<br>';
for ($i=1;$i<=$ucount;$i++)
{
	$query2 = 'SELECT name FROM t_info_unit WHERE id='.$i;
	$result2 = mysqli_query($db,$query2);
	$line2 = mysqli_fetch_row($result2);
	if ($ustat[$i]==0)
	{
		echo '<div class="ObjUN"><img src=img/units/'.$unitimgname[$i].' onclick=AjaxNaym('.$i.')></img>';
	}
	else
	{
		echo '<div class="ObjUN"><img src=img/units/'.$unitimgname[$i].' onclick=NoNaymAlert('.$ustat[$i].')></img>';
	}
	$stclass = 'btn-success';
	if ($ustat[$i]==1) $stclass='btn-danger';
	if ($ustat[$i]==2) $stclass='btn-secondary';
	
	if ($ustat[$i]==0)
	{
		echo '<input type=button class="btn '.$stclass.' " value="'.$line2[0].'" onclick=AjaxNaym('.$i.')></div>';
	}
	else
	{
		echo '<input type=button class="btn '.$stclass.' " value="'.$line2[0].'" onclick=NoNaymAlert('.$ustat[$i].')></div>';
	}
}
?>
</div>

<div class="PanelMove">
<input type=button class="btn" value="Номер ячейки" onclick="AjaxPointNum()"><br><br>
<input type=button class="btn" value="Номер сектора" onclick="AjaxSectorNum()"><br><br>
<input type=button class="btn" value="Выйти из игры" onclick="ExitGame()">
</div>

<div class="PanelZd">
<?php
echo 'Ваши здания:<br>';
for ($i=1;$i<=$zdcount;$i++)
{
	if ($zdstat[$i]==2)
	{
		$query = 'SELECT name FROM t_info_zd WHERE id='.$i;
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		
		echo '<div class="ObjZd"><img src=img/zd/'.$zdimgname[$i].'></img>';
		echo $line[0].'</div>';
	}	
}
?>
</div>

<div class="DivToSector">
<input type=button class="btn btn-success" value="На карту сектора" onclick="ToSector()">
</div>

<div class="DivToMap">
<input type=button class="btn btn-success" value="На карту мира" onclick="ToMap()">
</div>

</body>
</html>
