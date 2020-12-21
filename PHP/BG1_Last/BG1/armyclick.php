<?php
session_start();

if (isset($_POST['action']) && $_POST['action']=='armyclick')
{
	$_SESSION['AX']=$_POST['id'] % 3;
	$_SESSION['AY']=floor($_POST['id'] / 3);
	$_SESSION['ATip']=$_POST['val'];
	$db = mysqli_connect("localhost","pma","","bg1");
	if (mysqli_connect_errno()) 
	{
		echo "Connect failed: %s\n".mysqli_connect_error();
		exit();
	}
	
	if ($_POST['val']==0)
	{
		echo 'В этой ячейке армию не ставят';
	}
	else if ( ($_POST['val']>=1) and ($_POST['val']<=3) )
	{
		echo 'Тут ставится армия';
	}
	else if ($_POST['val']==4)
	{
		echo 'Это ваша башня';
	}
}
?>