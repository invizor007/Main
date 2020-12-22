<?php
session_start();

if ($_POST['action']=='plus')
{
	$_SESSION['val']++;
}

if ($_POST['action']=='minus')
{
	$_SESSION['val']--;
}

if ($_POST['action']=='random')
{
	$_SESSION['val']=rand(1,200);
}
?>