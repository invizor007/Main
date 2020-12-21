<!DOCTYPE html>
<html>
<head><title>Персонаж</title></head>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link rel="stylesheet" href="css/herostyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">

<?php
session_start();
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

if (!isset($_GET['id']))
{
	echo "Выберите игрока которого хотите посмотреть";
	exit();
}

$arthead = 0;
$artbody = 0;
$artlegs = 0;

$artsbag = array(0,0,0,0,0,0);
//$ind = 0;

$query='SELECT tip FROM t_accounts WHERE id = '.$_GET['id'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$_SESSION['herotip'] = $line[0];
$heroimg = "'".'img/person/'.$line[0].'.bmp'."'"; //echo $heroimg;'img/person/1.bmp'
//Ассасин, гладиатор, маг, рыцарь, монах, шаман
$incs = array(1=>0,2=>2,3=>0,4=>1,5=>1,6=>0);
$inca = array(1=>2,2=>0,3=>0,4=>1,5=>0,6=>1);
$inci = array(1=>0,2=>0,3=>2,4=>0,5=>1,6=>1);

$query='SELECT num,place FROM t_user_arts WHERE login_id = '.$_GET['id'];
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
 
window.addEventListener("load",timer,true);
</script>

<body onLoad="ImagesInit();">
<div class="PanelArtMain">
<canvas id = "canvas" width="350" height="400"></canvas>
</div>

<div class = "PanelStat">
<?php
$query = 'SELECT s_all,a_all,i_all,free from t_account_stat where id = '.$_GET['id'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result); //echo $query;

echo 'Сила '.$line[0].'<br>';
echo 'Ловкость '.$line[1].'<br>';
echo 'Интеллект '.$line[2].'<br>';

echo '<br>';
echo 'Количество здоровья: '.(100+5*$line[0]).'<br>';
echo 'Урон: '.(10+2*$line[1]).'<br>';
echo 'Количество маны: '.($line[2]).'<br>';
?>
</div>


</body>

</html>
