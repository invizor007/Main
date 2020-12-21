<?php
session_start();

if (isset($_POST['action']) && $_POST['action']=='armysetclick')
{
	if (($_SESSION['AY']>=1)and($_SESSION['AY']<=3)) $index = $_SESSION['AY']-1;
	else if ($_SESSION['AY']==0) $index=0;
	else $index=1;
	
	$db = mysqli_connect("localhost","pma","","bg1");
	if (mysqli_connect_errno()) 
	{
		echo "Connect failed: %s\n".mysqli_connect_error();
		exit();
	}
	
	if ($_POST['id']==3)
	{
		switch ($_SESSION['ATip'])
		{
			case 1: switch ($index)
			{
				case 0: $query = 'UPDATE t_account_army set m1 = 0 where id='.$_SESSION['ID']; break;
				case 1: $query = 'UPDATE t_account_army set m2 = 0 where id='.$_SESSION['ID']; break;
				case 2: $query = 'UPDATE t_account_army set m3 = 0 where id='.$_SESSION['ID']; break;
			} break;
			
			case 2: switch ($index)
			{
				case 0: $query = 'UPDATE t_account_army set a1 = 0 where id='.$_SESSION['ID']; break;
				case 1: $query = 'UPDATE t_account_army set a2 = 0 where id='.$_SESSION['ID']; break;
				case 2: $query = 'UPDATE t_account_army set a3 = 0 where id='.$_SESSION['ID']; break;
			} break;

			case 3: switch ($index)
			{
				case 0: $query = 'UPDATE t_account_army set c1 = 0 where id='.$_SESSION['ID']; break;
				case 1: $query = 'UPDATE t_account_army set c2 = 0 where id='.$_SESSION['ID']; break;
			}		
		}
		$result = mysqli_query($db,$query);
		echo 'Армия снята с передовой';
	}
	
	else
	{
		$unum = ($_SESSION['ATip']-1)*3+$_POST['id']+2;
		$query = 'SELECT co from user_u where account_id = '.$_SESSION['ID'].' AND U_ID='.$unum;
		$result = mysqli_query($db,$query);
		if ($result)
		{
			$line = mysqli_fetch_row($result);
			if ($line[0]!='') $co = $line[0];
			else $co = 0;
		}
		else
		{
			$co = 0;
		}
		if ($co==0)
		{
			echo 'У вас нет юнитов указанного типа';
			exit();
		}
		
		switch ($_SESSION['ATip'])
		{
			case 1: $query = 'SELECT m1,m2,m3 from t_account_army where id='.$_SESSION['ID']; break;
			case 2: $query = 'SELECT a1,a2,a3 from t_account_army where id='.$_SESSION['ID']; break;
			case 3: $query = 'SELECT c1,c2,0 from t_account_army where id='.$_SESSION['ID']; break;
		} //echo $query; exit();
		$result = mysqli_query($db,$query);
		if (!$result)
		{
			echo 'Ошибка выполнения запроса в БД';
			exit();
		}
		$line = mysqli_fetch_row($result);
		for ($i=0;$i<2;$i++) 
		{
			if ($line[$i]==$unum) $co--;
		}
		if ($co<=0)
		{
			echo 'Все юниты указанного типа уже использованы';
			exit();
		}	
		
				
		switch ($_SESSION['ATip'])
		{
			case 1: switch ($index)
			{
				case 0: $query = 'UPDATE t_account_army set m1 = '.$unum.' where id='.$_SESSION['ID']; break;
				case 1: $query = 'UPDATE t_account_army set m2 = '.$unum.' where id='.$_SESSION['ID']; break;
				case 2: $query = 'UPDATE t_account_army set m3 = '.$unum.' where id='.$_SESSION['ID']; break;
			} break;
			
			case 2: switch ($index)
			{
				case 0: $query = 'UPDATE t_account_army set a1 = '.$unum.' where id='.$_SESSION['ID']; break;
				case 1: $query = 'UPDATE t_account_army set a2 = '.$unum.' where id='.$_SESSION['ID']; break;
				case 2: $query = 'UPDATE t_account_army set a3 = '.$unum.' where id='.$_SESSION['ID']; break;
			} break;	

			case 3: switch ($index)
			{
				case 0: $query = 'UPDATE t_account_army set c1 = '.$unum.' where id='.$_SESSION['ID']; break;
				case 1: $query = 'UPDATE t_account_army set c2 = '.$unum.' where id='.$_SESSION['ID']; break;
			}			
		}
		$result = mysqli_query($db,$query);
		echo 'Армия установлена на передовую';
	}
	
	header("Refresh:1 url=game.php");
}
?>