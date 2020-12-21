<?php
session_start();

if (isset($_POST['action']) && $_POST['action']=='infoclick')
{
	$_SESSION['MAPCMODE'] = 'info';
	echo "Информация";
}
?>