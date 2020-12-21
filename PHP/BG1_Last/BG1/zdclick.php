<?php
session_start();

if (isset($_POST['action']) && $_POST['action']=='zdclick')
{
	$_SESSION['MAPCMODE'] = 'zdbuild';
	$_SESSION['zdbuild'] = $_POST['id'];
	echo "Строительство здания";
}
?>