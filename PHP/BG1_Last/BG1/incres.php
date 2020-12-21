<?php
session_start();

if ( isset($_POST['action']) and $_POST['action']=='incres' and isset($_SESSION['ID']) )
{
	$db = mysqli_connect("localhost","pma","","bg1");
	if (mysqli_connect_errno()) 
	{
		echo "Connect failed: %s\n".mysqli_connect_error();
		exit();
	}
	
	for ($i=2;$i<=5;$i++)
	{
		$query = 'SELECT count(*) from user_zd where zd_id='.$i.' and account_id='.$_SESSION['ID'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$zdcounts[$i] = $line[0];
	}

	$query = 'SELECT wood_c,gold_c,food_c,stone_c from user_pe where id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);	
	
	$iwood=2+3*$zdcounts[2]+4*$line[0]; $_SESSION['wood']+=$iwood;
	$igold=2+3*$zdcounts[3]+4*$line[1]; $_SESSION['gold']+=$igold;
	$ifood=2+3*$zdcounts[4]+4*$line[2]; $_SESSION['food']+=$ifood;
	$istone=2+3*$zdcounts[5]+4*$line[3];$_SESSION['stone']+=$istone;
	
	//Проверка лимитов
	$query = 'SELECT count(*) from user_zd where account_id = '.$_SESSION['ID'].' AND zd_id = 9';
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$co = 100+40*$line[0];
	
	if ($_SESSION['wood']>$co) $_SESSION['wood']=max($co,$_SESSION['wood']-$iwood);
	if ($_SESSION['gold']>$co) $_SESSION['gold']=max($co,$_SESSION['gold']-$igold);
	if ($_SESSION['food']>$co) $_SESSION['food']=max($co,$_SESSION['food']-$ifood);
	if ($_SESSION['stone']>$co) $_SESSION['stone']=max($co,$_SESSION['stone']-$istone);
	
	$query = "UPDATE t_accounts SET WOOD = ".$_SESSION['wood'].", GOLD = ".$_SESSION['gold'].", FOOD=".$_SESSION['food'].", STONE = ".$_SESSION['stone'].", ylimit = ".$_SESSION['ylimit']." WHERE ID=".$_SESSION['ID'];

	$result = mysqli_query($db,$query);
	header("Refresh:1 url=game.php");
}
?>