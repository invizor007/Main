<html>
<head>
<title>Средневековое поселение</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
</head>

<link rel="stylesheet" href="css/foreststyles.css">
<script>
var isfirst = 1;
function firsttimer()
{
//alert(isfirst);
	if (isfirst==1)
	{
		window.setTimeout("timer();", 300000);
		isfirst=0;
	}
	else
	{
		window.setTimeout("timer();", 300000);
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

function AjaxForestClick(ind) {
      $.ajax({
           type: "POST",
           url: 'forestclick.php',
           data:{action:'forestclick',id:ind},
           success:function(html) {
			 alert(html);
			 //window.location.reload();
			 if (html == 'На вас нападают бандиты. Хорошо что вам удается убежать')
				{document.location.href = "game.php";}
           }
      });
 }
 
function AjaxHomeClick() {
      $.ajax({
           type: "POST",
           url: 'forestclick.php',
           data:{action:'homeclick'},
           success:function(html) {
			 alert(html);
			 document.location.href = "game.php";
           }
      });
 } 
 
</script>
<body onLoad = 'isfirst = 1;firsttimer();'>

<div class="PanelRes">
<font color="yellow" size=4><b>
<?php
session_start();
if (!isset($_SESSION['login']))
{
	echo "Сначала войдите в игру <a href='login.php'>тут</a>";
	exit();
}
//echo "Вы вошли как ".$_SESSION['login']."<br>";
echo "Ваши ресурсы: ".$_SESSION['wood']." дерева  ".$_SESSION['gold']." золота  ".$_SESSION['food']." еды  ".$_SESSION['stone']." камня<br>";

$_SESSION['forest_trap'] = rand(1,4);
do
$_SESSION['forest_klad'] = rand(1,4);
while ( $_SESSION['forest_klad']==$_SESSION['forest_trap'] );
$_SESSION['forest_visited'] = 0;
$_SESSION['klad_n']=0;
$_SESSION['klad_v']=0;
?>
</b></font>
</div>


<div class="PanelChoice1">
<input type = button value = "Пойти сюда" class="btn btn-success" onClick = AjaxForestClick(0)>
</div>

<div class="PanelChoice2">
<input type = button value = "Пойти сюда" class="btn btn-success" onClick = AjaxForestClick(1)>
</div>

<div class="PanelChoice3">
<input type = button value = "Пойти сюда" class="btn btn-success" onClick = AjaxForestClick(2)>
</div>

<div class="PanelChoice4">
<input type = button value = "Пойти сюда" class="btn btn-success" onClick = AjaxForestClick(3)>
</div>

<div class="PanelHome">
<input type = button value = "Вернуться домой" class="btn btn-success" onClick = AjaxHomeClick()>
</div>

</body>
</html>