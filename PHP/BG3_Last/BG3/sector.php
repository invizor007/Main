<!DOCTYPE html>
<html>
<head><title>Карта сектора</title></head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link rel="stylesheet" href="css/mapstyles.css">
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

$query = 'SELECT value FROM t_game_const where name="OBJCOUNT"';
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$_SESSION['objcount'] = $line[0];

$query = 'SELECT count(*) FROM t_info_secobj where 1=1';
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$_SESSION['objtypecount'] = $line[0];

if (!isset($_SESSION['SX']))
{
	$_SESSION['SX']=0;
}
if (!isset($_SESSION['SY']))
{
	$_SESSION['SY']=0;
}

if (!isset($_SESSION['FSX']))
{
	$_SESSION['FSX']=0;
}
if (!isset($_SESSION['FSY']))
{
	$_SESSION['FSY']=0;
}

$query = 'SELECT sector,point FROM t_main_plinfo WHERE id='.$_SESSION['ID'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$_SESSION['homes'] = $line[0];
$_SESSION['homep'] = $line[1];

?>

<script language="javascript">
var a= [];
var imgs=[];
var sx=0,sy=0,ex=0,ey=0;

function AjaxMove(ind) {
      $.ajax({
           type: "POST",
           url: 'ev_sector.php',
           data:{action:'move',ind:ind},
           success:function(html) {
			 window.location.reload();
           }

      });
 }
 
function AjaxClickXY(ind) {
      $.ajax({
           type: "POST",
           url: 'ev_sector.php',
           data:{action:'clickxy',ind:ind},
           success:function(html) {
			 window.location.reload();
           }

      });
 }
 
function AjaxWDrill() {
      $.ajax({
           type: "POST",
           url: 'ev_sector.php',
           data:{action:'drill'},
           success:function(html) {
			 document.location.href = 'sector.php';
           }

      });
 }
 
function AjaxWFlag() {
      $.ajax({
           type: "POST",
           url: 'ev_sector.php',
           data:{action:'setflag'},
           success:function(html) { //alert(html);
			 window.location.reload();
           }

      });
 }
 
function AjaxVisit() {
      $.ajax({
           type: "POST",
           url: 'ev_sector.php',
           data:{action:'visit'},
           success:function(data) {
			 //window.location.reload();
			 $('#TimerDiv').html(data);
			 setTimeout('TimerTick();',1000);
           }

      });
 }
 
function TimerTick() {
	  var timetxt = $('#TimerDiv').html();
	  if (Number.parseInt(timetxt)<=0) {return;}
	  
      $.ajax({
           type: "POST",
           url: 'ev_sector.php',
           data:{action:'timertick'},
           success:function(data) {
		    if (Number.parseInt(data)<=0) 
			  {
				  AjaxSectorAction();
			  }//onload="TimerTick()"
			  else
			  {
				  $('#TimerDiv').html(data);
				  setTimeout('TimerTick();',1000);
			  }
           }
      });

	
 }
 
function AjaxSectorAction() {
      $.ajax({
           type: "POST",
           url: 'ev_sector.php',
           data:{action:'sectoraction'},
           success:function(data) { 
				$('#TimerDiv').html('0'); //alert(data);
				alert('Посещено');
				window.location.reload();
           }
      });
}
 
function AjaxToMap(){
      $.ajax({
           type: "POST",
           url: 'ev_sector.php',
           data:{action:'tomap'},
           success:function(html) {
			 document.location.href = 'world.php';
           }

      });
}


function OpenReport()
{
	window.open('report.php');
}
</script>

<body onload="TimerTick()">

<?php
//Формирование карты сектора
if (!isset($_SESSION['sect'])) {
	$_SESSION['sect'] = $_SESSION['homes'];
}
$query = 'SELECT campp,camps FROM t_main_plinfo WHERE id='.$_SESSION['ID'];
$result = mysqli_query($db,$query);
if ($line = mysqli_fetch_row($result))
{
	$_SESSION['CampP']=$line[0];
	$_SESSION['CampS']=$line[1];
}
if (!isset($_SESSION['CampP'])) {$_SESSION['CampP']=-1;}
if (!isset($_SESSION['CampS'])) {$_SESSION['CampS']=-1;}

$query = 'SELECT objid,pointnum FROM t_sector where sectornum='.$_SESSION['sect'];
$result = mysqli_query($db,$query);

$sector = array();
for ($i=0;$i<1600;$i++) {$sector[$i]=0;}

while ($line = mysqli_fetch_row($result))
{
	$objid=$line[0];
	$pointnum = $line[1];
	$x = $pointnum % 40;
	$y = ($pointnum-$x) / 40;
	
	$sector[$pointnum] = $objid;
}

$query = 'SELECT point,id FROM t_main_plinfo WHERE id<>'.$_SESSION['ID'].' AND sector='.$_SESSION['sect'];
$result = mysqli_query($db,$query);

while ($line = mysqli_fetch_row($result))
{
	$sector[$line[0]] = $line[1]+100;
}

?>

<div class = "PanelMap">
<?php
//формирирование карты сектора

for ($i=0;$i<15;$i++)
{
	for ($j=0;$j<25;$j++)
	{		
		$num = ($i+$_SESSION['SY'])*40+($j+$_SESSION['SX']);
		
		if ( ($_SESSION['homes']==$_SESSION['sect'])&&($_SESSION['homep']==$num) )
		{
			echo '<img src="img/land/t.bmp" onclick="AjaxClickXY('.$num.')">';
		}		
		else if ( ($i+$_SESSION['SY']==$_SESSION['FSY'])&&($j+$_SESSION['SX']==$_SESSION['FSX']) )
		{
			echo '<img src="img/land/f.bmp" onclick="AjaxClickXY('.$num.')">';
		}
		else if ( ($_SESSION['CampS']==$_SESSION['sect'])&&($_SESSION['CampP']==$num) )
		{
			echo '<img src="img/land/c.bmp" onclick="AjaxClickXY('.$num.')">';
		}		
		else
		{
			if ($sector[$num]==0)
			{
				echo '<img src="img/land/0.bmp" onclick="AjaxClickXY('.$num.')">';
			}
			else if ($sector[$num]>=100)
			{
				echo '<img src="img/land/et.bmp" onclick="AjaxClickXY('.$num.')">';
			}
			else
			{
				echo '<img src="img/seobj/'.$sector[$num].'.bmp" onclick="AjaxClickXY('.$num.')">';
			}			
		}		

	}
	echo '<br>';
}

// https://htmlweb.ru/html/symbols.php - специальные символы в html
?>
</div>

<div class = "UpBtnTab">
<?php
if ($_SESSION['SY']==0) echo ' Высота '.($_SESSION['SY']-1).'&#9940;';
else echo '<a onClick="AjaxMove(0)"> Высота '.($_SESSION['SY']-1).' &uarr;</a>';
?>
</div>

<div class = "DownBtnTab">
<?php
if ($_SESSION['SY']==39) echo ' Высота '.($_SESSION['SY']+1).'&#9940;';
else echo '<a onClick="AjaxMove(1)"> Высота '.($_SESSION['SY']+1).' &darr;</a>';
?>
</div>

<div class = "LeftBtnTab">
<?php
if ($_SESSION['SX']==0) echo '<br>Д<br>о<br>л<br>г<br>о<br>т<br>а<br><br> '.($_SESSION['SX']-1).'<br>&#9940;';
else echo '<a onclick="AjaxMove(2)"><br>Д<br>о<br>л<br>г<br>о<br>т<br>а<br><br> '.($_SESSION['SX']-1).'<br>&larr; </a>';
?>
</div>

<div class = "RightBtnTab">
<?php
if ($_SESSION['SX']==39) echo '<br>Д<br>о<br>л<br>г<br>о<br>т<br>а<br><br> '.($_SESSION['SX']+1).'<br>&#9940;';
else echo '<a onclick="AjaxMove(3)"><br>Д<br>о<br>л<br>г<br>о<br>т<br>а<br><br> '.($_SESSION['SX']+1).'<br>&rarr; </a>';
?>
</div>

<div class = "PanelControl">
<?php
echo '<input type=button class="btn btn-success" value="Перейти" onClick="AjaxWDrill()"><br><br>';
echo '<input type="number" value="'.$_SESSION['FSX'].'"><br><br>';
echo '<input type="number" value="'.$_SESSION['FSY'].'"><br><br>';
echo '<input type=button class="btn btn-success" value="Флажок" onClick="AjaxWFlag()"><br><br>';
echo '<input type=button class="btn btn-success" value="Посетить" onClick="AjaxVisit();TimerTick();"><br><br>';

echo '<input type=button class="btn btn-success" value="Последний поход" onClick="OpenReport()"><br><br>';
echo '<input type=button class="btn btn-success" value="Общая карта" onClick="AjaxToMap()">';

?>
</div>

<div class="PanelTimer">
<font color=red size=6><b>
<div id="TimerDiv">
<?php
$query = 'SELECT movetime,actiontype FROM t_main_plinfo WHERE id='.$_SESSION['ID'];
$result = mysqli_query($db,$query);	
$line = mysqli_fetch_row($result);
if ($line[1]==1) 
{
	echo $line[0];
}
else
{
	echo '0';
}
?>
</div>
</b></font>
</div>

<div class="PanelArmyInfo">
<?php
$unitimgname = array (1=>'1.png',2=>'2.png',3=>'3.png',4=>'4.png',5=>'5.png',6=>'6.png',7=>'7.png');
$query = 'SELECT uid,co FROM t_army WHERE plid='.$_SESSION['ID'];
$result = mysqli_query($db,$query);
echo 'Ваша армия:<br>';
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
?>
</div>

<div class = "PanelResInfo">
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

<div class = "BroadcastLine">
<?php
	$query = 'SELECT msg FROM t_message WHERE msgid=1 AND PLID='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	echo $line[0];
?>
</div>

</body>
</html>
