<?php

include 'ev_setart.php';

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

if ($_POST['action']=='setstat')
{
	$num = $_POST['id'];
	switch ($num)
	{
		case 1: $query = 'UPDATE t_account_stat set free=free-1,s_all=s_all+1,s_nat=s_nat+1  where id = '.$_SESSION['ID'];break;
		case 2: $query = 'UPDATE t_account_stat set free=free-1,a_all=a_all+1,a_nat=a_nat+1  where id = '.$_SESSION['ID'];break;
		case 3: $query = 'UPDATE t_account_stat set free=free-1,i_all=i_all+1,i_nat=i_nat+1  where id = '.$_SESSION['ID'];break;
	}
	$result = mysqli_query($db,$query);
}

if ($_POST['action']=='makenull')
{
	$incs = array(1=>0,2=>2,3=>0,4=>1,5=>1,6=>0);
	$inca = array(1=>2,2=>0,3=>0,4=>1,5=>0,6=>1);
	$inci = array(1=>0,2=>0,3=>2,4=>0,5=>1,6=>1);

	$query = 'UPDATE t_account_stat set free=free_max,s_nat='.(2+$incs[$_SESSION['herotip']]).
		',a_nat='.(2+$inca[$_SESSION['herotip']]).',i_nat='.(2+$inci[$_SESSION['herotip']]).' where id = '.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	calc_art_bonus();
}

?>

