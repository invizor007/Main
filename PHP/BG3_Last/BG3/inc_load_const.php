<?php

function load_const()
{
	$db = mysqli_connect("localhost","bg3user","","bg3");
	$query = 'SELECT NAME, VALUE FROM t_game_const where 1=1';
	$result = mysqli_query($db,$query);
	while ($line = mysqli_fetch_row($result))
	{
		$name=$line[0];
		$_SESSION[$name]=$line[1];
	}
}

load_const();
//echo $_SESSION['COUNTZD'];
?>