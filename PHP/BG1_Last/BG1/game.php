<?php
session_start();
?>

<html>
<head>
<title>Средневековое поселение</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/styles.css">
<script>
var isfirst = 1;
function firsttimer()
{
//alert(isfirst);
	if (isfirst==1)
	{
		window.setTimeout("timer();", 60000);
		isfirst=0;
	}
	else
	{
		window.setTimeout("timer();", 60000);
	}
	
}

function timer()
{
	alert('Прирост ресурсов');
      $.ajax({
           type: "POST",
           url: 'incres.php',
           data:{action:'incres'},
           success:function(html) {
             $("#AAA").val(html);
			 //alert(html);
			 window.location.reload();
           }
      });
	  
window.setTimeout("timer();", 300000);
}

function AjaxMapClick(ind) {
	  //alert('AjaxMapClick '+ind);
      $.ajax({
           type: "POST",
           url: 'mapclick.php',
           data:{action:'mapclick',id:ind},
           success:function(html) {
             $("#AAA").val(html);
			 alert(html);
			 window.location.reload();
           }

      });
 }
 
function AjaxZdClick(ind) {
	  //alert('AjaxZdClick '+ind);
      $.ajax({
           type: "POST",
           url: 'zdclick.php',
           data:{action:'zdclick',id:ind},
           success:function(html) {
             $("#AAA").val(html);
			 alert(html);
           }

      });
 }
 
function AjaxAddUClick(ind) {
	  //alert('AjaxAddUClick '+ind);
      $.ajax({
           type: "POST",
           url: 'addu.php',
           data:{action:'addu',id:ind},
           success:function(html) {
             $("#AAA").val(html);
			 alert(html);
			 window.location.reload();
           }

      });
 }
 
 function AjaxExtendClick() {
      $.ajax({
           type: "POST",
           url: 'extendclick.php',
           data:{action:'extendclick'},
           success:function(html) {
             $("#AAA").val(html);
			 alert('Выберите в какую сторону расширять владения');
           }

      });
 }
 
  function AjaxZddelClick() {
      $.ajax({
           type: "POST",
           url: 'zddelclick.php',
           data:{action:'zddelclick'},
           success:function(html) {
             $("#AAA").val(html);
			 alert('Выберите здание которое нужно снести');
           }

      });
 }
 
  function AjaxInfoClick() {
      $.ajax({
           type: "POST",
           url: 'infoclick.php',
           data:{action:'infoclick'},
           success:function(html) {
             $("#AAA").val(html);
           }

      });
 }
 
   function AjaxAddPeClick() {
      $.ajax({
           type: "POST",
           url: 'addpeclick.php',
           data:{action:'addpeclick'},
           success:function(html) {
             $("#AAA").val(html);
			 window.location.reload();
           }

      });
 }
 
   function AjaxFreePeClick() {
      $.ajax({
           type: "POST",
           url: 'freepeclick.php',
           data:{action:'freepeclick'},
           success:function(html) {
             $("#AAA").val(html);
			 window.location.reload();
           }

      });
 }
 
 function AjaxArmyClick(ind,v) {
	  //alert('AjaxArmyClick ind='+ind+' v='+v);
      $.ajax({
           type: "POST",
           url: 'armyclick.php',
           data:{action:'armyclick',id:ind,val:v},
           success:function(html) {
             $("#AAA").val(html);
			 alert(html);
			 window.location.reload();
           }

      });
 }
 
 function AjaxArmySetClick(ind) {
	  //alert('AjaxArmySetClick ind='+ind);
      $.ajax({
           type: "POST",
           url: 'armysetclick.php',
           data:{action:'armysetclick',id:ind},
           success:function(html) {
             $("#AAA").val(html);
			 alert(html);
			 
			 //if (html.IndexOf('Установка армии')>=0)
			//	{alert("aaa");}
			 window.location.reload();
           }

      });
 }
</script>
<body onLoad = 'isfirst = 1;firsttimer();'>

<div class="PanelRes">
<font color="gray" size=4><b>
<?php
//header("Content-type: text/html; charset=utf-8");
//session_start();
if (!isset($_SESSION['login']))
{
	echo "Сначала войдите в игру <a href='login.php'>тут</a>";
	exit();
}
//echo "Вы вошли как ".$_SESSION['login']."<br>";
echo "Ваши ресурсы: ".$_SESSION['wood']." дерева  ".$_SESSION['gold']." золота  ".$_SESSION['food']." еды  ".$_SESSION['stone']." камня<br>";
?>
</b></font>
</div>

<div class="PanelInfo">
<input type = button class="btn btn-success" value = "Карта приключений" onClick = "javascript:document.location.href=`map.php`">
<input type = button class="btn btn-success" value = "Информация об игре" onClick = "javascript:window.open(`info.php`)">
<br><br>
<input type = "text" id="AAA" size="102" value = "" /><br>
<div id="BBB"></div>
</div>

<div class="PanelMap">
<b>Ваше поселение:</b><br>
<?php
$db = mysqli_connect("localhost","pma","","bg1");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}
for ($Y = 0;$Y<6; $Y++)
{
	for ($X = 0;$X<6; $X++)
	{
		$zdnum = 0;
		if (($X<$_SESSION['xlimit'])&&($Y<$_SESSION['ylimit'])) {$zdnum = 0;}
		else {$zdnum=100;}
		
		$query = "SELECT zd_id FROM user_zd WHERE ACCOUNT_ID=".$_SESSION['ID']." AND X=".$X." AND Y=".$Y;
		$result = mysqli_query($db,$query);
		
		if ($result)
		{
			$line = mysqli_fetch_row($result);
			if ($line[0]!='')
				{$zdnum = $line[0];}
		}
		else
		{
			echo "Ошибка чтения данных из БД";
			exit();
		}
		
		$s='img/map/'.$zdnum.'.bmp';
		$ind = $Y*6+$X;
		echo "<img src = ".$s." id=".$ind." onClick = 'AjaxMapClick(".$ind.")'></img>";
	}
	echo "<br>";
}
$_SESSION['MAPCMODE']='info';

?>
</div>


<div class = "PanelZd">
<b>Построить здание:</b><br>
<?php
$db = mysqli_connect("localhost","pma","","bg1");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}
mysqli_set_charset($db, 'utf8');

echo '<table width = 300 height = 60 border=1>';
echo '<tr>';
for ($i = 1;$i<=5; $i++)
{
	echo '<td width=60 height=60 align=center valign=center>';
	$s='img/zd/'.$i.'.bmp';
	$query="SELECT name from zdinfo where id=".$i;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	
	echo '<img src = '.$s.' id = '.$i." title=".$line[0]." onClick = 'AjaxZdClick(".$i.")'></img>";
	echo '</td>';
}
echo '</tr>';

echo '<tr>';
for ($i = 6;$i<=10; $i++)
{
	echo '<td width=60 height=60 align=center valign=center>';
	$s='img/zd/'.$i.'.bmp'; 
	$query="SELECT name from zdinfo where id=".$i;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);	
	echo '<img src = '.$s.' id = '.$i." title=".$line[0]." onClick = 'AjaxZdClick(".$i.")'></img>";
	echo '</td>';
}
echo '</tr>';

echo '<tr>';
for ($i = 11;$i<=12; $i++)
{
	echo '<td width=60 height=60 align=center valign=center>';
	$s='img/zd/'.$i.'.bmp';
	$query="SELECT name from zdinfo where id=".$i;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);	
	echo '<img src = '.$s.' id = '.$i." title=".$line[0]." onClick = 'AjaxZdClick(".$i.")'></img>";
	echo '</td>';
}
echo '</tr>';

echo '</table>';

echo '&nbsp;&nbsp;<input type = button class="btn btn-success" value = "Расширить владения" onClick = "AjaxExtendClick()"><br>';
echo '&nbsp;&nbsp;<input type = button class="btn btn-success" value = "Снести здание" onClick = "AjaxZddelClick()"><br>';
echo '&nbsp;&nbsp;<input type = button class="btn btn-success" value = "Выделить здание" onClick = "AjaxInfoClick()">';
?>
</div>


<div class="PanelZdU">
<b>Нанять юнитов:</b><br>
<?php
if (!isset($_SESSION['zdmap']))
{
	$_SESSION['zdmap']=0;
}
$zdmap = $_SESSION['zdmap'];
$db = mysqli_connect("localhost","pma","","bg1");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

$query="SELECT id FROM uinfo WHERE zd_id=".$zdmap;
$result = mysqli_query($db,$query);
		
if ($result)
{
	while ($line = mysqli_fetch_row($result)) 
	{
		if ($line[0]!='') $n = $line[0]; 
		//"<img src = ".$s." id=".$ind." onClick = 'AjaxMapClick(".$ind.")'></img>";
		echo "<img src = img/units/".$n.".bmp id =".$n." onClick='AjaxAddUClick(".$n.")'></img>";
	}	
}
?>
</div>



<div class="PanelU">
<b>Ваши юниты:</b><br>
<?php
$db = mysqli_connect("localhost","pma","","bg1");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

for ($i=1;$i<=5;$i++)
{
	$query="SELECT co FROM user_u WHERE u_id=".$i." AND ACCOUNT_ID=".$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	if ($result)
	{
		$line = mysqli_fetch_row($result);
		if ($line[0]!='')
		{
			echo '<img src = img/units/'.$i.'.bmp id ='.$i.'>';
			echo $line[0];
		}
	}
}
echo '<br>';
for ($i=6;$i<=10;$i++)
{
	$query="SELECT co FROM user_u WHERE u_id=".$i." AND ACCOUNT_ID=".$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	if ($result)
	{
		$line = mysqli_fetch_row($result);
		if ($line[0]!='')
		{
			echo '<img src = img/units/'.$i.'.bmp id ='.$i.'>';
			echo $line[0];
		}
	}
}

?>
</div>


<div class = "PanelPe">
<b>Распределение крестьян:</b><br>
<?php
$db = mysqli_connect("localhost","pma","","bg1");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

if ( ($_SESSION['zdmap']>=2)and($_SESSION['zdmap']<=5)and($_SESSION['MAPCMODE']=='info') )
{
	$query = "SELECT wood_c,gold_c,food_c,stone_c,free_c from user_pe where id = ".$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	if ($result)
	{
		$line = mysqli_fetch_row($result);
		$_SESSION['pe_c'] = $line[0];
		switch ($_SESSION['zdmap'])
		{
			case 2: $_SESSION['pe_c'] = $line[0]; $_SESSION['pe_t'] = 1; echo 'На лесопилках:<br>'; break;
			case 3: $_SESSION['pe_c'] = $line[1]; $_SESSION['pe_t'] = 2; echo 'На золотых шахтах:<br>'; break;
			case 4: $_SESSION['pe_c'] = $line[2]; $_SESSION['pe_t'] = 3; echo 'В садах:<br>'; break;
			case 5: $_SESSION['pe_c'] = $line[3]; $_SESSION['pe_t'] = 4; echo 'На каменоломнях:<br>'; break;
		}
		
		$_SESSION['pe_m'] = $line[4];
		
		echo 'Работают '.$_SESSION['pe_c'].' крестьян. Свободны '.$_SESSION['pe_m'].' крестьян<br>';
		echo '&nbsp;&nbsp;<input type = button class="btn btn-success" value = "Добавить крестьянина" onClick = "AjaxAddPeClick()">'; echo '<br>';
		echo '&nbsp;&nbsp;<input type = button class="btn btn-success" value = "Освободить крестьянина" onClick = "AjaxFreePeClick()">';
	}
}
?>
</div>


<div class = "PanelArmy">
<b>Распределение армии:</b><br>
<?php
for ($Y = 0;$Y<5; $Y++)
{
	for ($X = 0;$X<3; $X++)
	{
		$s='img/map/0.bmp'; $v=0; $u=-1;
		if ( ($X==0) and ($Y!=2) ) $s='img/map/100.bmp';
		if ( ($X==1) and (($Y-2)*($Y-2)==4) ) $s='img/map/100.bmp';
		
		if ( ($X==2) and (($Y-2)*($Y-2)<4) ) {$s='img/map/101.bmp';$v=1;$u=$Y-1;}
		if ( ($X==1) and (($Y-2)*($Y-2)<4) ) {$s='img/map/102.bmp';$v=2;$u=$Y-1;}
		if ( ($X==2) and (($Y-2)*($Y-2)==4) ) {$s='img/map/103.bmp';$v=3;$u=$Y/4;}
		if ( ($X==0) and ($Y==2) ) {$s='img/map/104.bmp';$v=4;$u=0;}
		
		if ( ($v>=1)and($v<=3) )
		{
			switch ($v)
			{
				case 1: $query = 'SELECT m1,m2,m3 from t_account_army where id='.$_SESSION['ID']; break;
				case 2: $query = 'SELECT a1,a2,a3 from t_account_army where id='.$_SESSION['ID']; break;
				case 3: $query = 'SELECT c1,c2,0 from t_account_army where id='.$_SESSION['ID']; break;
			}
			$result = mysqli_query($db,$query);
			if (!$result)
			{
				echo 'Ошибка выполнения запроса в БД';
				exit();
			}
			$line = mysqli_fetch_row($result);
			if ($line[$u]!=0)
			{
				$s='img/map/'.(200+$line[$u]).'.bmp';
			}
		}
		
		$ind = $Y*3+$X;
		echo "<img src = ".$s." id=".$ind." onClick = 'AjaxArmyClick(".$ind.",".$v.")'></img>";	
	}
	echo '<br>';
}

if ( isset($_SESSION['ATip']) and ($_SESSION['ATip']>=1) and ($_SESSION['ATip']<=3) )
{
	for ($i=0;$i<=3;$i++)
	{
		if ($i==3) {$s = 'img/units/100.bmp';}
		else {$s = 'img/units/'.( ($_SESSION['ATip']-1)*3+$i+2).'.bmp';}
		echo "<img src = ".$s." id=as".$i." onClick = 'AjaxArmySetClick(".$i.")'></img>";	
	}
}
?>
</div>

</body>
</html>