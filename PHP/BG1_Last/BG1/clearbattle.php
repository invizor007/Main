<?php
$db = mysqli_connect("localhost","pma","","bg1");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

$query = 'DELETE FROM t_bat_units where battle_id >= 2';
$result = mysqli_query($db,$query);
$query = 'DELETE FROM t_bat_ustat where battle_id >= 2';
$result = mysqli_query($db,$query);
$query = 'DELETE FROM t_bat_freepl where battle_id >= 2';
$result = mysqli_query($db,$query);
?>