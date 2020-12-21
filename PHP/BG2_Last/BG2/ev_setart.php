<?php
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

function calc_art_bonus()
{
	$db = mysqli_connect("localhost","bg2user","","bg2");	
	$query = 'UPDATE t_account_stat set s_all = s_nat,a_all=a_nat,i_all=i_nat where id = '.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	
	$query = 'SELECT num from t_user_arts where login_id = '.$_SESSION['ID'].' and place>=1 and place<=3';
	//echo $query;
	$result = mysqli_query($db,$query);
	while ($line = mysqli_fetch_row($result))
	{
		$query2 = 'SELECT bonus_s,bonus_a,bonus_i from t_art_info where id = '.$line[0];
		$result2 = mysqli_query($db,$query2);
		$line2 = mysqli_fetch_row($result2); 
		
		$query3 = 'UPDATE t_account_stat set s_all=s_all+'.$line2[0].', a_all=a_all+'.$line2[1].', i_all=i_all+'.$line2[2].' where id='.$_SESSION['ID'];
		$result3 = mysqli_query($db,$query3); echo $query3;
	}
}

if ($_POST['action']=='setart')
{
	$bagid = $_POST['id'];

	$query='SELECT id,num FROM t_user_arts WHERE login_id = '.$_SESSION['ID'].' AND place = 11+'.$bagid;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);

	$query = 'SELECT place FROM t_art_info WHERE id='.$line[1];
	$result = mysqli_query($db,$query);
	$line2 = mysqli_fetch_row($result);

	$query='SELECT id,num FROM t_user_arts WHERE login_id = '.$_SESSION['ID'].' AND place = '.$line2[0];
	$result = mysqli_query($db,$query);
	$line3 = mysqli_fetch_row($result);

	$query='update t_user_arts set place = '.$line2[0].' where id='.$line[0];
	$result = mysqli_query($db,$query);
	$query='update t_user_arts set place = 11+'.$bagid.' where id='.$line3[0];
	$result = mysqli_query($db,$query);
	
	calc_art_bonus();
}

if ($_POST['action']=='tobag')
{
	$plaid = $_POST['id'];

	//ищем первое место куда можно поставить артефакт
	$query='SELECT max(place) FROM t_user_arts WHERE login_id = '.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	
	if ($line[0]==16)
	{
		echo 'Инвернарь заполнен';
		exit();
	}
	
	$newpla = $line[0]+1;
	if ($newpla < 11) $newpla=11;

	$query='update t_user_arts set place = '.$newpla.' WHERE login_id = '.$_SESSION['ID'].' AND place = '.$plaid;
	//echo $query;
	$result = mysqli_query($db,$query);

	calc_art_bonus();
}

?>

