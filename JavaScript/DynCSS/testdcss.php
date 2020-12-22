<html>
<head>
<title>Динамический css</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="cssmain.css">
<link rel="stylesheet" href="testdcss.css.php" type="text/css">

<script language="javascript">
function PlusVal() {
      $.ajax({
           type: "POST",
           url: 'events.php',
           data:{action:'plus'},
           success:function(html) {
			 window.location.reload();
           }
      });
 }
 
function MinusVal() {
      $.ajax({
           type: "POST",
           url: 'events.php',
           data:{action:'minus'},
           success:function(html) {
			 window.location.reload();
           }
      });
 }
 
function RandomVal() {
      $.ajax({
           type: "POST",
           url: 'events.php',
           data:{action:'random'},
           success:function(html) {
			 window.location.reload();
           }
      });
 } 
</script>

<?php
echo '<div class="you_hp"></div>';
session_start();
if (!isset($_SESSION['val']))
{
	$_SESSION['val'] = 100;
}
echo '<b>Значение = '.$_SESSION['val'].'</b>';
echo "<br>";
echo '<input type=button class="btn btn-success" value = Больше onclick = "PlusVal()">';
echo " ";
echo '<input type=button class="btn btn-success" value = Меньше onclick = "MinusVal()">';
echo " ";
echo '<input type=button class="btn btn-success" value = Сгенерировать onclick = "RandomVal()">';
?>
</body>
</html>