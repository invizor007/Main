<?php
session_start();

if (isset($_POST['action']) && $_POST['action']=='extendclick')
{
	$_SESSION['MAPCMODE'] = 'extend';
	echo "Расширение территории";
}
?>