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

if ($_POST['action']=='herofind')
{
	$query = 'INSERT INTO t_arena (PL1,PL2,STAT) VALUES ('.$_SESSION['ID'].',0,1)';
	$result = mysqli_query($db,$query);
	
	$query = 'SELECT id from t_arena where pl1='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$_SESSION['arenaid'] = $line[0];
}



?>

