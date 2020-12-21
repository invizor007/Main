<html>
<head>
<title>Средневековое поселение</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/mapstyles.css">
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
	  alert(ind);
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
 

</script>
<body onLoad = 'isfirst = 1;firsttimer();'>

<div class="PanelRes">

<?php
session_start();
if (!isset($_SESSION['login']))
{
	echo "Сначала войдите в игру <a href='login.php'>тут</a>";
	exit();
}

echo "Ваши ресурсы: ".$_SESSION['wood']." дерева  ".$_SESSION['gold']." золота  ".$_SESSION['food']." еды  ".$_SESSION['stone']." камня<br>";

$db = mysqli_connect("localhost","pma","","bg1");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

$query = 'SELECT max(id) from t_neutral';
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);

$_SESSION['Ne1'] = rand(1,$line[0]);
$_SESSION['Ne2'] = rand(1,$line[0]);

?>
</div>

<div class = "PanelChoice1">
<font color="red" size=6><b>Налево пойдешь?</b></font>
<br>
<?php
$query = 'SELECT m1,m2,m3,a1,a2,a3,c1,c2,t,res_n,res_v from t_neutral where id = '.$_SESSION['Ne1'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);

for ($i=0;$i<8;$i++)
{	
	if ($line[$i]!=0)
	{
		$s = "img/units/".$line[$i].".bmp";
		echo '<img src = '.$s.'></img>';
	}
}
echo '<br>';
switch ($line[9])
{
	case 1: $s=$line[10].' дерева';break;
	case 2: $s=$line[10].' золота';break;
	case 3: $s=$line[10].' еды';break;
	case 4: $s=$line[10].' камня';break;
}

echo '<b>Охраняют '.$s.'</b><br>';
echo '<input type = button value = "Сразиться" class="btn btn-success" onClick = "javascript:document.location.href=`battle.php?choice=1`">';
?>
</div>

<div class = "PanelChoice2">
<font color="red" size=6><b>Направо пойдешь?</b></font>
<br>
<?php
$query = 'SELECT m1,m2,m3,a1,a2,a3,c1,c2,t,res_n,res_v from t_neutral where id = '.$_SESSION['Ne2'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);

for ($i=0;$i<8;$i++)
{	
	if ($line[$i]!=0)
	{
		$s = "img/units/".$line[$i].".bmp";
		echo '<img src = '.$s.'></img>';
	}
}
echo '<br>';
switch ($line[9])
{
	case 1: $s=$line[10].' дерева';break;
	case 2: $s=$line[10].' золота';break;
	case 3: $s=$line[10].' еды';break;
	case 4: $s=$line[10].' камня';break;
}

echo '<b>Охраняют '.$s.'</b><br>';
echo '<input type = button value = "Сразиться" class="btn btn-success" onClick = "javascript:document.location.href=`battle.php?choice=2`">';
?>
</div>

<div class = "PanelChoice3">
<font color="red" size=6><b>В лес пойдешь?</b></font>
<br>
<input type = button value = "Да" class="btn btn-success" onClick = "javascript:document.location.href=`forest.php`">
</div>

<div class = "PanelHome">
<?php
echo '<input type = button value = "Вернуться домой" class="btn btn-success" onClick = "javascript:document.location.href=`game.php`">';
?>
</div>

</body>
</html>