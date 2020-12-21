<?php
session_start();

if (isset($_POST['action']) && $_POST['action']=='mapclick')
{
	$_SESSION['X']=$_POST['id'] % 6;
	$_SESSION['Y']=floor($_POST['id'] / 6);
	$db = mysqli_connect("localhost","pma","","bg1");
	if (mysqli_connect_errno()) 
	{
		echo "Connect failed: %s\n".mysqli_connect_error();
		exit();
	}		
	
	if ($_SESSION['MAPCMODE']=='info')
	{
		if ( ($_SESSION['X']>=$_SESSION['xlimit']) || ($_SESSION['Y']>=$_SESSION['ylimit']) )
		{
			echo "Неисследованная территория. ";
		}
			
		$query = "SELECT zd_id FROM user_zd WHERE ACCOUNT_ID=".$_SESSION['ID']." AND X=".$_SESSION['X']." AND Y=".$_SESSION['Y'];
		//echo $query;
		$result = mysqli_query($db,$query);
		//mysql_query("SET NAMES utf8");
		mysqli_set_charset($db, 'utf8');
			
		if ($result)
		{
			$line = mysqli_fetch_row($result);
			if ($line[0]!='')
			{
				$zdnum = $line[0];
				$_SESSION['zdmap']=$zdnum;
				$query = "SELECT name FROM zdinfo WHERE ID='".$zdnum."'";
				//echo $query;
				$result = mysqli_query($db,$query);
				if ($result)
				{
					$line = mysqli_fetch_row($result);
					echo $line[0];
				}
			}
			else
			{
				echo "Территория свободна для строительства";
			}
			
		}
		
	}
	
	if ($_SESSION['MAPCMODE']=='zdbuild')
	{
		if ( ($_SESSION['X']>=$_SESSION['xlimit']) || ($_SESSION['Y']>=$_SESSION['ylimit']) )
		{
			echo "Неисследованная территория. Строить тут нельзя.";
			exit();
		}		
		//Проверка на то что мы кликаем на пустую клетку
	
		$query = "SELECT zd_id FROM user_zd WHERE ACCOUNT_ID=".$_SESSION['ID']." AND X=".$_SESSION['X']." AND Y=".$_SESSION['Y'];
		$result = mysqli_query($db,$query);
		mysqli_set_charset($db, 'utf8');
		
		if ($result)
		{
			$line = mysqli_fetch_row($result);
			if ($line[0]!='')
			{
				echo "На этой территории уже есть здание. Выберите другое место.";
			}
			else
			{
				//Проверяем что количество зданий указанного типа не достигло лимита
				$query = "SELECT lim from zdinfo WHERE id = ".$_SESSION['zdbuild'];
				$result = mysqli_query($db,$query);
				$line = mysqli_fetch_row($result);
				$lim = $line[0];
				$query = "SELECT count(*) from user_zd WHERE account_id = ".$_SESSION['ID']." and zd_id=".$_SESSION['zdbuild'];
				$result = mysqli_query($db,$query);
				$line = mysqli_fetch_row($result);
				if ($line[0]>=$lim)
				{
					echo 'Достигнут предел по количеству зданий указанного типа';
					exit();
				}
				
				//Проверяем наличие ресурсов для постройки здания
				$query="SELECT wood,gold,food,stone from zdinfo WHERE id = ".$_SESSION['zdbuild'];
				$result = mysqli_query($db,$query);
				if ($result)
				{
					$line = mysqli_fetch_row($result);
					$zd_wood = $line[0];
					$zd_gold = $line[1];
					$zd_food = $line[2];
					$zd_stone = $line[3];
					
					if ( ($zd_wood>$_SESSION['wood']) || ($zd_gold>$_SESSION['gold']) || ($zd_food>$_SESSION['food']) || ($zd_stone>$_SESSION['stone']) )
					{
						echo 'Недостаточно ресурсов для строительства.';
						exit();
					}
				}
				else
				{
					echo "Ошибка выборки из БД";
					exit();
				}
				
				$query = "INSERT INTO user_zd (ACCOUNT_ID,ZD_ID,X,Y) VALUES (".$_SESSION['ID'].",".$_SESSION['zdbuild'].",".$_SESSION['X'].",".$_SESSION['Y'].");";
				//echo $query;
				$result = mysqli_query($db,$query);
				//Вычитаем ресурсы
				$_SESSION['wood']-=$zd_wood;
				$_SESSION['gold']-=$zd_gold;
				$_SESSION['food']-=$zd_food;
				$_SESSION['stone']-=$zd_stone;
				//Записываем изменения в базу данных
				
				$query = "UPDATE t_accounts SET WOOD = ".$_SESSION['wood'].", GOLD = ".$_SESSION['gold'].", FOOD=".$_SESSION['food'].", STONE = ".$_SESSION['stone']." WHERE ID=".$_SESSION['ID'];
				$result = mysqli_query($db,$query);
				header("Refresh:1 url=game.php");
			}
			
		}		
		
	}
	
	if ($_SESSION['MAPCMODE']=='extend')
	{
		if ( ( $_SESSION['X'] >= $_SESSION['xlimit'] ) and ( $_SESSION['Y'] >= $_SESSION['ylimit'] ) )
		{
			echo "Нужно выбрать либо вправо либо вниз";
			exit();
		}
		
		if ( ( $_SESSION['X'] >= $_SESSION['xlimit'] ) and ( $_SESSION['Y'] < $_SESSION['ylimit'] ) )
		{
			//расширение по иксу - вправо
			$co = 50*$_SESSION['ylimit'];
			if ( ($_SESSION['wood']<$co) || ($_SESSION['gold']<$co) || ($_SESSION['food']<$co) || ($_SESSION['stone']<$co) )
			{
				echo "Для строительства накопите ".$co." каждого ресурса";
				exit();
			}
			$_SESSION['wood']-=$co;
			$_SESSION['gold']-=$co;
			$_SESSION['food']-=$co;
			$_SESSION['stone']-=$co;
			$_SESSION['xlimit']++;
			
			$query = "UPDATE t_accounts SET WOOD = ".$_SESSION['wood'].", GOLD = ".$_SESSION['gold'].", FOOD=".$_SESSION['food'].", STONE = ".$_SESSION['stone'].", xlimit = ".$_SESSION['xlimit']." WHERE ID=".$_SESSION['ID'];
			$result = mysqli_query($db,$query);
			
			
			header("Refresh:1 url=game.php");
			exit();
		}
		
		if ( ( $_SESSION['X'] < $_SESSION['xlimit'] ) and ( $_SESSION['Y'] >= $_SESSION['ylimit'] ) )
		{
			//расширение по игреку - вниз
			$co = 50*$_SESSION['xlimit'];
			if ( ($_SESSION['wood']<$co) || ($_SESSION['gold']<$co) || ($_SESSION['food']<$co) || ($_SESSION['stone']<$co) )
			{
				echo "Для строительства накопите ".$co." каждого ресурса";
				exit();
			}
			$_SESSION['wood']-=$co;
			$_SESSION['gold']-=$co;
			$_SESSION['food']-=$co;
			$_SESSION['stone']-=$co;
			$_SESSION['ylimit']++;
			
			$query = "UPDATE t_accounts SET WOOD = ".$_SESSION['wood'].", GOLD = ".$_SESSION['gold'].", FOOD=".$_SESSION['food'].", STONE = ".$_SESSION['stone'].", ylimit = ".$_SESSION['ylimit']." WHERE ID=".$_SESSION['ID'];
			$result = mysqli_query($db,$query);
			
			header("Refresh:1 url=game.php");
			exit();
		}
		
	}
	
		if ($_SESSION['MAPCMODE']=='zddel')
		{
			$query = "DELETE FROM user_zd WHERE  ACCOUNT_ID=".$_SESSION['ID']." AND X=".$_SESSION['X']." AND Y=".$_SESSION['Y'];
			$result = mysqli_query($db,$query);
			
			$_SESSION['MAPCMODE']='info';
			header("Refresh:1 url=game.php");
		}
}
?>