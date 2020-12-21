<?php
session_start();
if (!isset($_SESSION['ID']))
{
	echo "<font color=red><b>Сначала войдите в игру <a href='login.php'>тут</a></b></font>";
	exit();
}
$db = mysqli_connect("localhost","bg3user","","bg3");		
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

if ($_POST['action']=='move')
{	
	if (($_SESSION['MY']>0)&&($_POST['ind']==0))
	{
		$_SESSION['MY']-=5;
	}
	if (($_SESSION['MY']<25)&&($_POST['ind']==1))
	{
		$_SESSION['MY']+=5;
	}

	if (($_SESSION['MX']>0)&&($_POST['ind']==2))
	{
		$_SESSION['MX']-=5;
	}
	if (($_SESSION['MX']<15)&&($_POST['ind']==3))
	{
		$_SESSION['MX']+=5;
	}
}

if ($_POST['action']=='drill')
{
	echo 'Переходим на карту сектора';
	$_SESSION['sect']=$_SESSION['FMY']*40+$_SESSION['FMX'];
}

if ($_POST['action']=='setflag')
{
	$_SESSION['FMX']=$_SESSION['CMX'];
	$_SESSION['FMY']=$_SESSION['CMY'];
}

if ($_POST['action']=='clickxy')
{
	$_SESSION['CMX'] = $_POST['ind'] % 40;
	$_SESSION['CMY'] = ($_POST['ind']-$_SESSION['CMX']) / 40;
}

if ($_POST['action']=='visit')
{
	//Выдача заданий по квесту
	
	//Определение номера объекта
	$sectornum = $_SESSION['FMY']*40+$_SESSION['FMX'];
	$query = 'SELECT objnum FROM t_world WHERE sectornum = '.$sectornum;
	$result = mysqli_query($db,$query);
	
	if ($line = mysqli_fetch_row($result))//это значит что объект мира на данной клетке есть
	{
		$objid = $line[0]; echo $objid.'<br>';
		$query = 'SELECT name FROM t_info_globj WHERE id='.$objid;
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$s= 'Вы выполняете задания для объекта '.$line[0];
		$query = "UPDATE t_message SET msg='".$s."' WHERE msgid=2 AND plid".$_SESSION['ID'];
		mysqli_query($db,$query);
		
		//Очистка активных заданий у игрока
		$query = 'DELETE FROM t_active_quest WHERE plid='.$_SESSION['ID'];
		$result = mysqli_query($db,$query);
		
		$query = 'UPDATE t_main_plinfo SET qobj='.$objid.' WHERE id='.$_SESSION['ID'];
		$result = mysqli_query($db,$query);		
		
		$query  = 'SELECT info FROM t_info_globj WHERE id='.$objid;
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$quco = $line[0] % 100;//Количество заданий
		
		$usednum = array();
		$ind=0;
		
		while ($ind<$quco)
		{
			//Генерируем задания для игрока
			$number = rand(0,19);
			//Проверка что номера еще нет у игрока
			//$a = array(1,2,3,4,5,6);
			if(!in_array($number, $usednum))
			{
				$query = 'SELECT qtype,valc FROM t_info_quest WHERE id='.$number;
				$result = mysqli_query($db,$query);
				$line = mysqli_fetch_row($result);
				
				$goalc = $line[1];
				if ($line[0]==3)//если квест текстовый
				{
					$goalc = 1;
				}
				
				$query='INSERT INTO t_active_quest(PLID,QID,CURRC,GOALC) VALUES ('.$_SESSION['ID'].','.$number.',0,'.$goalc.')'; echo $query;
				$result = mysqli_query($db,$query);
				
				$dst_arr[] = $usednum;
				$ind++;
			}
			
		}
	echo 'Для вас появились новые задания';
	}
	else
	{
		echo 'Объекта в данном месте нет';
	}
}

if ($_POST['action']=='makecamp')
{
	$_SESSION['CampS'] = $_SESSION['FMY']*40+$_SESSION['FMX'];
	$_SESSION['CampP'] = rand(1,1600);
	
	$query = 'UPDATE t_main_plinfo SET CAMPP = '.$_SESSION['CampP'].', CAMPS='.$_SESSION['CampS'].' WHERE ID='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	echo 'Высадка произведена в точке '.$_SESSION['CampP'];
}


?>

