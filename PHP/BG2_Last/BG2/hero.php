<!DOCTYPE html>
<html>
<head><title>Ваш персонаж</title></head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link rel="stylesheet" href="css/herostyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">

<?php
session_start(); //unset($_SESSION['arenaid']);
if (!isset($_SESSION['ID']))
{
	echo "Сначала войдите в игру <a href='login.php'>тут</a>";
	exit();
}
$db = mysqli_connect("localhost","bg2user","","bg2");		
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

$arthead = 0;
$artbody = 0;
$artlegs = 0;

$artsbag = array(0,0,0,0,0,0);
//$ind = 0;

$query='SELECT tip FROM t_accounts WHERE id = '.$_SESSION['ID'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$_SESSION['herotip'] = $line[0];
$heroimg = "'".'img/person/'.$line[0].'.jpg'."'";
//Ассасин, гладиатор, маг, рыцарь, монах, шаман
$incs = array(1=>0,2=>2,3=>0,4=>1,5=>1,6=>0);
$inca = array(1=>2,2=>0,3=>0,4=>1,5=>0,6=>1);
$inci = array(1=>0,2=>0,3=>2,4=>0,5=>1,6=>1);

$query='SELECT num,place FROM t_user_arts WHERE login_id = '.$_SESSION['ID'];
$result = mysqli_query($db,$query);
while ($line = mysqli_fetch_row($result))
{
	if ($line[1] == 1) {$arthead = $line[0];}
	else if ($line[1] == 2) {$artbody = $line[0];}
	else if ($line[1] == 3) {$artlegs = $line[0];}
	else if ($line[1]>10)
	{
		$artsbag[$line[1]-11] = $line[0];
		//$ind++;
	}
}
/*
for ($i = $ind; $i<6; $i++)
{
	$artsbag[$i] = 0;
}
*/
?>

<script language="javascript">
var imgstr = [<?php echo $heroimg?>,'img/arts/1.bmp','img/arts/2.bmp','img/arts/3.bmp','img/arts/4.bmp','img/arts/5.bmp',
'img/arts/6.bmp','img/arts/7.bmp','img/arts/8.bmp','img/arts/9.bmp','img/arts/10.bmp'];
var imgs = [];

function ImagesInit()
{
  for (var i=0;i<11;i++)
  {
    var tmp = new Image();
    tmp.src = imgstr[i];
    imgs.push(tmp);
  }
}

function timer()
{
	setTimeout("draw()", 100);
}

function draw()
{
	//ImagesInit();
	var cnv = document.getElementById("canvas");
	var ctx = cnv.getContext("2d");
	
	ctx.drawImage(imgs[0],1,1);
	var arthead = <?php echo $arthead?>;
	var artbody = <?php echo $artbody?>;
	var artlegs = <?php echo $artlegs?>;
	if (arthead>0) { ctx.drawImage(imgs[arthead],160,20); }
	if (artbody>0) { ctx.drawImage(imgs[artbody],160,170); }
	if (artlegs>0) { ctx.drawImage(imgs[artlegs],160,330);}
	//ctx.fillRect(imgs[0],0,0);
	//alert('0');
	//alert (imgs.length);
}

function AjaxSetArtClick(ind) {
      $.ajax({
           type: "POST",
           url: 'ev_setart.php',
           data:{action:'setart',id:ind},
           success:function(html) {
			 alert(html);
			 window.location.reload();
           }

      });
 }
 
function AjaxTobagArtClick(e) {
	  var ind = 0; 
	  if ( (e.clientX>160)&&(e.clientX<200)&&(e.clientY>20)&&(e.clientY<60) ) ind=1;
	  if ( (e.clientX>160)&&(e.clientX<200)&&(e.clientY>170)&&(e.clientY<210) ) ind=2;
	  if ( (e.clientX>160)&&(e.clientX<200)&&(e.clientY>330)&&(e.clientY<370) ) ind=3; //alert(ind);
	  if (ind==0) return;
      $.ajax({
           type: "POST",
           url: 'ev_setart.php',
           data:{action:'tobag',id:ind},
           success:function(html) {
			 alert(html);
			 window.location.reload();
           }

      });
 }
 
function AjaxAddStatClick(ind) {
      $.ajax({
           type: "POST",
           url: 'ev_setstat.php',
           data:{action:'setstat',id:ind},
           success:function(html) {
			 window.location.reload();
           }

      });
 }
 
function AjaxMakeNullClick() {
      $.ajax({
           type: "POST",
           url: 'ev_setstat.php',
           data:{action:'makenull'},
           success:function(html) {
			 window.location.reload();
           }

      });
 }
 
function AjaxArenaNewClick() {
      $.ajax({
           type: "POST",
           url: 'ev_arena.php',
           data:{action:'create'},
           success:function(html) {
			 window.location.reload();
           }

      });
 }
 
function AjaxArenaDeleteClick() {
      $.ajax({
           type: "POST",
           url: 'ev_arena.php',
           data:{action:'delete'},
           success:function(html) {
			 window.location.reload();
           }

      });
 }

function AjaxArenaBatStartClick() {
      $.ajax({
           type: "POST",
           url: 'ev_arena.php',
           data:{action:'batstart'},
           success:function(html) {
			 alert('Начинаем битву');
		     document.location.replace("battle.php");
           }

      });
 }
 
function AjaxArenaJoinClick(ind) {
      $.ajax({
           type: "POST",
           url: 'ev_arena.php',
           data:{action:'join',id:ind},
           success:function(html) {
			 window.location.reload();
           }

      });
 }
 
function AjaxHuntClick(ind1,ind2) {
      $.ajax({
           type: "POST",
           url: 'ev_arena.php',
           data:{action:'hunt',id1:ind1,id2:ind2},
           success:function(html) { 
		     if (html!='Находясь в заявке на бой нельзя охотиться')
			 {
				alert('Начинаем охоту');
				document.location.replace("battle.php");
				//window.location.reload();				 
			 }
           }

      });
 }
 
window.addEventListener("load",timer,true);
</script>

<body onLoad="ImagesInit();">
<div class="PanelArtMain" onclick=AjaxTobagArtClick(event)>
<canvas id = "canvas" width="350" height="400"></canvas>
</div>

<div class = "PanelArtBag">
Рюкзак с артефактами<br>
<?php
for ($i = 0;$i < 6; $i++)
{
	$s = 'img/arts/'.$artsbag[$i].'.bmp';
	$arthint = 'arthint';
	if ($artsbag[$i]>0)
	{
		$query = 'SELECT name from t_art_info WHERE id = '.$artsbag[$i];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$arthint = $line[0];
		
		$query = 'SELECT quan from t_user_arts WHERE login_id = '.$_SESSION['ID'].' and place = 11+'.$i;
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$arthint = $arthint.'('.$line[0].')';
		echo '<img src = '.$s.' id = '.$i." title='".$arthint."' onClick = 'AjaxSetArtClick(".$i.")'></img>";
	}
	else
	{
		echo '<img src='.$s.' title="Пусто"></img>';
	}
}
?>
</div>

<div class = "PanelStat">
Характеристики игрока<br>
<?php
$query = 'SELECT lev,exp from t_accounts where id = '.$_SESSION['ID'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
echo 'Уровень <b>'.$line[0].'</b>. Опыт <b>'.$line[1].'</b><br><br>';

$query = 'SELECT s_all,a_all,i_all,free from t_account_stat where id = '.$_SESSION['ID'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result); //echo $query;

if ($line[3]>0)
	echo 'Сила <b>'.$line[0].'</b><a onclick="AjaxAddStatClick(1)">+</a>'.'<br>';
else
	echo 'Сила <b>'.$line[0].'</b><br>';
	
if ($line[3]>0)
	echo 'Ловкость <b>'.$line[1].'</b><a onclick="AjaxAddStatClick(2)">+</a>'.'<br>';
else
	echo 'Ловкость <b>'.$line[1].'</b><br>';

if ($line[3]>0)
	echo 'Интеллект <b>'.$line[2].'</b><a onclick="AjaxAddStatClick(3)">+</a>'.'<br>';
else	
	echo 'Интеллект <b>'.$line[2].'</b><br>';

echo 'Свободно очков <b>'.$line[3].'</b><br>';
echo '<input type = "button" value = "Сбросить" onclick="AjaxMakeNullClick()"></input>';

echo '<br>';
echo 'Количество здоровья: <b>'.(100+5*$line[0]).'</b><br>';
echo 'Урон: <b>'.(10+2*$line[1]).'</b><br>';
echo 'Количество маны: <b>'.($line[2]).'</b><br>';
?>
</div>

<div class = "PanelArena">
Арена<br>
<?php
echo '<input type = "button" value = "Создать заявку" onclick="AjaxArenaNewClick()">';
echo '<input type = "button" value = "Отменить заявку" onclick="AjaxArenaDeleteClick()">';
echo '<input type = "button" value = "Начать битву" onclick="AjaxArenaBatStartClick()">';

$query = 'SELECT t1.id,t2.login,t3.login '.
	'from t_arena t1 left join t_accounts t2 on t1.pl1 = t2.id '.
	'left join t_accounts t3 on t1.pl2 = t3.id where t1.stat = 1';

$result = mysqli_query($db,$query);
while ($line = mysqli_fetch_row($result))
{
	if (!isset($_SESSION['arenaid']))
		echo '<b><font color=red>Заявка №'.$line[0].' Игрок: '.$line[1].' vs '.$line[2].
		'<input type=button value = "+" onclick = AjaxArenaJoinClick('.$line[0].')>'.'<br>'.'</font></b>';
	else
		echo '<b><font color=red>Заявка №'.$line[0].' Игрок: '.$line[1].' vs '.$line[2].'<br>'.'</font></b>';		
}


?>
</div>

<div class = "HeroFind">
Найти игрока<br>
<form method="POST" action="hero.php">
<input type = "text" name="HeroFindInput">
<input type = "submit" value = "Найти" onclick="HeroFindClick()">
</form>
<?php
if (isset($_POST['HeroFindInput']))
{
	$query = 'SELECT id from t_accounts where login = "'.$_POST['HeroFindInput'].'"';
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	if (!$line[0])
	{
		echo 'Игрок не найден';
	}
	else
	{
		echo '<a href = plinfo.php?id='.$line[0].'>'.$_POST['HeroFindInput'].'</a>';
	}
}
?>
</div>

<div class = "Hunt">
Охота<br>
<?php
for ($i=1;$i<=3;$i++)
{
	$r1 = rand(1,5);
	$r2 = rand(0,5);
	$s = "AjaxHuntClick(".$r1.",".$r2.")";
	
	$query = 'SELECT name from t_monstrs where id = '.$r1;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);	
	$monname = $line[0];
	echo '<img src=img/monstr_mini/'.$r1.'.jpg title='.$monname.' onclick='.$s.'>'.$r2.'<br>';
}
?>
</div>

</body>

</html>
