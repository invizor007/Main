<!DOCTYPE html>
<html>
<head><title>Карта мира</title></head>
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

if (!isset($_SESSION['MX']))
{
	$_SESSION['MX']=0;
}
if (!isset($_SESSION['MY']))
{
	$_SESSION['MY']=0;
}

if (!isset($_SESSION['FMX']))
{
	$_SESSION['FMX']=0;
}
if (!isset($_SESSION['FMY']))
{
	$_SESSION['FMY']=0;
}

?>

<script language="javascript">
function AjaxMove(ind) {
      $.ajax({
           type: "POST",
           url: 'ev_world.php',
           data:{action:'move',ind:ind},
           success:function(html) {
			 window.location.reload();
           }

      });
 }
 
function AjaxClickXY(ind) {
      $.ajax({
           type: "POST",
           url: 'ev_world.php',
           data:{action:'clickxy',ind:ind},
           success:function(html) {
			 window.location.reload();
           }

      });
 }
 
function AjaxWDrill() {
      $.ajax({
           type: "POST",
           url: 'ev_world.php',
           data:{action:'drill'},
           success:function(html) {
			 //window.location.reload();
			 document.location.href = 'sector.php';
           }

      });
 }
 
function AjaxWFlag() {
      $.ajax({
           type: "POST",
           url: 'ev_world.php',
           data:{action:'setflag'},
           success:function(html) {
			 window.location.reload();
           }

      });
 } 
 
function AjaxVisit() {
      $.ajax({
           type: "POST",
           url: 'ev_world.php',
           data:{action:'visit'},
           success:function(html) { alert(html);
			 window.location.reload();
           }

      });	
}

function OpenDetails()
{
	window.open('details.php');
}

function AjaxMakeCamp() {
      $.ajax({
           type: "POST",
           url: 'ev_world.php',
           data:{action:'makecamp'},
           success:function(html) { alert(html);
			 window.location.reload();
           }

      });	
}
</script>

<body>

<?php
//Формирование карты сектора
if (!isset($_SESSION['sector'])) {
	$_SESSION['sector'] = -1;
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

//Запрос по секторам
//$query = 'SELECT objid,pointnum FROM t_sector where sectornum='.$_SESSION['sector'];
$query = 'SELECT objnum,sectornum FROM t_world where 1=1';
$result = mysqli_query($db,$query);

//if (!$result) echo 'hoho';
$world = array();
for ($i=0;$i<1600;$i++) {$world[$i]=0;}

while ($line = mysqli_fetch_row($result))
{
	$objnum=$line[0];
	$sectornum = $line[1];
	
	$world[$sectornum] = $objnum;
}


?>

<div class = "PanelMap">
<?php
for ($i=0;$i<15;$i++)
{
	for ($j=0;$j<25;$j++)
	{
		$num = ($i+$_SESSION['MY'])*40+($j+$_SESSION['MX']);
		
		if ( ($i+$_SESSION['MY']==$_SESSION['FMY'])&&($j+$_SESSION['MX']==$_SESSION['FMX']) )
		{
			echo '<img src="img/land/f.bmp" onclick="AjaxClickXY('.$num.')">';
		}
		else if ( ($_SESSION['CampS']==$num) )
		{
			echo '<img src="img/land/c.bmp" onclick="AjaxClickXY('.$num.')">';
		}		
		else
		{
			if ($world[$num]==0)
			{
				echo '<img src="img/land/0.bmp" onclick="AjaxClickXY('.$num.')">';
			}
			else
			{
				echo '<img src="img/globj/'.$world[$num].'.bmp" onclick="AjaxClickXY('.$num.')">';
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
if ($_SESSION['MY']==0) echo ' Высота '.($_SESSION['MY']-1).'&#9940;';
else echo '<a onClick="AjaxMove(0)"> Высота '.($_SESSION['MY']-1).' &uarr;</a>';
?>
</div>

<div class = "DownBtnTab">
<?php
if ($_SESSION['MY']==39) echo ' Высота '.($_SESSION['MY']+1).'&#9940;';
else echo '<a onClick="AjaxMove(1)"> Высота '.($_SESSION['MY']+1).' &darr;</a>';
?>
</div>

<div class = "LeftBtnTab">
<?php
if ($_SESSION['MX']==0) echo '<br>Д<br>о<br>л<br>г<br>о<br>т<br>а<br><br> '.($_SESSION['MX']-1).'<br>&#9940;';
else echo '<a onclick="AjaxMove(2)"><br>Д<br>о<br>л<br>г<br>о<br>т<br>а<br><br> '.($_SESSION['MX']-1).'<br>&larr; </a>';
?>
</div>

<div class = "RightBtnTab">
<?php
if ($_SESSION['MX']==39) echo '<br>Д<br>о<br>л<br>г<br>о<br>т<br>а<br><br> '.($_SESSION['MX']+1).'<br>&#9940;';
else echo '<a onclick="AjaxMove(3)"><br>Д<br>о<br>л<br>г<br>о<br>т<br>а<br><br> '.($_SESSION['MX']+1).'<br>&rarr; </a>';

?>
</div>

<div class = "PanelControl">
<?php
echo '<input type=button class="btn btn-success" value="Перейти" onClick="AjaxWDrill()"><br><br>';
echo '<input type="number" value="'.$_SESSION['FMX'].'"><br><br>';
echo '<input type="number" value="'.$_SESSION['FMY'].'"><br><br>';
echo '<input type=button class="btn btn-success" value="Флажок" onClick="AjaxWFlag()"><br><br>';
echo '<input type=button class="btn btn-success" value="Посетить" onClick="AjaxVisit();"><br><br>';
echo '<input type=button class="btn btn-success" value="Квесты и ключи" onClick="OpenDetails();"><br><br>';
echo '<input type=button class="btn btn-success" value="Высадка" onClick="AjaxMakeCamp();"><br><br>';
?>
</div>

<div class="PanelTimer">
<font color=red size=6><b>
<div id="TimerDiv">
<?php
$query = 'SELECT movetime,actiontype FROM t_main_plinfo WHERE id='.$_SESSION['ID'];
$result = mysqli_query($db,$query);	
$line = mysqli_fetch_row($result);
if ($line[1]==2) 
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
	$query = 'SELECT msg FROM t_message WHERE msgid=2 AND PLID='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	echo $line[0];
?>

</body>
</html>
