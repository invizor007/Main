<?php
session_start();

if (isset($_POST['action']) && $_POST['action']=='addu')
{
	$_SESSION['addu']=$_POST['id'];
	
	$db = mysqli_connect("localhost","pma","","bg1");
	if (mysqli_connect_errno()) 
	{
		echo "Connect failed: %s\n".mysqli_connect_error();
		exit();
	}
	mysqli_set_charset($db, 'utf8');
	
	//Проверка наличия необходимого количества домов
	$query = "SELECT count(*) from user_zd where account_id=".$_SESSION['ID'].' and zd_id=1';
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$tmp = $line[0];
	$query = "SELECT sum(co) from user_u where account_id=".$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result); $_SESSION['test1']=$line[0];$_SESSION['test2']=$tmp;
	if ($line[0]>=5*$tmp)
	{
		echo 'Постройте больше домов для найма юнитов';
		exit();
	}
	
	//Проверка соответствия уровня количеству зданий
	$query = "SELECT lev,zd_id FROM uinfo WHERE ID=".$_SESSION['addu'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$lev = $line[0];
	$zdid = $line[1];
	
	$query = 'SELECT count(*) from user_zd where account_id='.$_SESSION['ID'].' and zd_id='.$zdid;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	if ($lev>$line[0])
	{
		if ( ($_SESSION['addu']>=2)and($_SESSION['addu']<=4) ) {$s='казарм';}
		else if ( ($_SESSION['addu']>=5)and($_SESSION['addu']<=7) ) {$s='стрельбищ';}
		else if ( ($_SESSION['addu']>=8)and($_SESSION['addu']<=10) ) {$s='конюшень';}
		echo 'Недостаточное количество '.$s.' для найма юнитов. Необходимо '.$lev;
		exit();
	}

	//Проверка на количество ресурсов
	$query = "SELECT wood,gold,food,stone FROM uinfo WHERE ID=".$_SESSION['addu'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	
	if ( ($line[0]>$_SESSION['wood']) or ($line[1]>$_SESSION['gold']) or ($line[2]>$_SESSION['food']) or ($line[3]>$_SESSION['stone']) )
	{
		echo 'Недостаточно ресурсов для найма юнита';
		exit();
	}
	$_SESSION['wood']-=$line[0];
	$_SESSION['gold']-=$line[1];
	$_SESSION['food']-=$line[2];
	$_SESSION['stone']-=$line[3];
			
	$query = "UPDATE t_accounts SET WOOD = ".$_SESSION['wood'].", GOLD = ".$_SESSION['gold'].", FOOD=".$_SESSION['food'].", STONE = ".$_SESSION['stone'].", xlimit = ".$_SESSION['xlimit']." WHERE ID=".$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	
	$query = "SELECT count(*) FROM user_u where u_id=".$_SESSION['addu']." AND ACCOUNT_ID=".$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	
	if ($_SESSION['addu']==1)
	{
		//куплен крестьянин, его надо добавить в свободных крестьянин
		$query = 'UPDATE user_pe set free_c=free_c+1 where id='.$_SESSION['ID'];
		$result = mysqli_query($db,$query);
	}
	
	if ($line[0]==0)
	{//делаем инсерт
		$query = "INSERT INTO user_u (ACCOUNT_ID,U_ID,CO) VALUES (".$_SESSION['ID'].",".$_SESSION['addu'].",1)";
		$result = mysqli_query($db,$query);
	}
	else
	{//делаем апдейт
		$query = "UPDATE user_u SET co = co + 1 where u_id = ".$_SESSION['addu']." AND ACCOUNT_ID=".$_SESSION['ID'];
		$result = mysqli_query($db,$query);
	}
	echo 'Юнит куплен';	
	header("Refresh:1 url=game.php");
	exit();
}
?>