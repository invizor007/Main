<?php
session_start();

if (isset($_POST['action']) && $_POST['action']=='zddelclick')
{
	$_SESSION['MAPCMODE'] = 'zddel';
	echo "Снос строений";
}
?>