<!DOCTYPE html>
<html>
<head><title>Ваш персонаж</title></head>
<link rel="stylesheet" href="css/loginstyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">

<script language="javascript">
var imgstr = ['img/hero/0.png','img/hero/0.bmp'];
var imgs = [];
window.addEventListener("load",draw,true);

function ImagesInit()
{
  for (var i=0;i<=1;i++)
  {
    var tmp = new Image();
    tmp.src = imgstr[i];//i+".png";
    imgs.push(tmp);
	//alert('1');
  }
}

function timer()
{
	setTimeout("draw()", 1000);
}

function draw()
{
	//ImagesInit();
	var cnv = document.getElementById("canvas");
	var ctx = cnv.getContext("2d");
	
	ctx.drawImage(imgs[0],0,0);
	//ctx.fillRect(imgs[0],0,0);
	//alert('0');
}

</script>

<body onLoad="ImagesInit();timer();">
<div class="PanelArtMain">
<canvas id = "canvas" width="300" height="300"></canvas>
<?php
session_start();
$db = mysqli_connect("localhost","bg2user","","bg2");		
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

//echo '<img src=img/hero/0.bmp></img>';

$query='SELECT num,place FROM t_user_arts WHERE login_id = '.$_SESSION['ID'];
$result = mysqli_query($db,$query);
while ($line = mysqli_fetch_row($result))
{
	echo $line[0];
}

?>
</div>

</body>

</html>
