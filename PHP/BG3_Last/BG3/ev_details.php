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


if ($_POST['action']=='ChooseEPL')
{
	if ( (!isset($_POST['epli1'])) || (!isset($_POST['epli2'])) ) {echo 'Не выбраны параметры поиска'; return;}
	if ( ($_POST['epli1']=='') || ($_POST['epli2']=='')) {echo 'Не выбраны параметры поиска'; return;}
	
	$query = 'SELECT id FROM t_main_plinfo WHERE id<>'.$_SESSION['ID'].' AND sector='.$_POST['epli1'].' AND point='.$_POST['epli2'];
	$result = mysqli_query($db,$query);
	if (!$result) {echo 'Ошибка поиска '; return;}
	if ($line = mysqli_fetch_row($result))
	{
		$_SESSION['EPLID']=$line[0];
		echo 'Игрок найден';
	}
	else
	{
		$_SESSION['EPLID']=-1;
		echo 'Игрок не найден';
	}
	
}

if ($_POST['action']=='SetKey')
{
	$query='UPDATE t_keys SET keyv='.$_POST['ind1'].' WHERE keyt=1 AND plid='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$query='UPDATE t_keys SET keyv='.$_POST['ind2'].' WHERE keyt=2 AND plid='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$query='UPDATE t_keys SET keyv='.$_POST['ind3'].' WHERE keyt=3 AND plid='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);	
}

if ($_POST['action']=='SolveQuest')
{
	//$query='SELECT qid FROM t_active_quest WHERE id='.$_POST['ind1'].' AND plid='.$_SESSION['ID'].' ORDER BY qid LIMIT 3';
	$query='SELECT t1.qid FROM (SELECT qid FROM t_active_quest WHERE plid='.$_SESSION['ID'].' order by qid limit '.$_POST['ind'].') t1 ORDER BY qid desc';
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$qid = $line[0]; //echo 'qid='.$qid;
	
	$query='SELECT qtype,valt,valc FROM t_info_quest WHERE id='.$qid;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);

	if ($line[0]!=3)//проверка на то что квест текстовый
	{
		echo 'Указанный квест не текстовый';
		return;
	}
	
	if ($line[2]==$_POST['sol'])
	{
		echo 'Правильный ответ. ';
		$query='UPDATE t_active_quest SET currc=1 WHERE qid='.$qid.' AND plid='.$_SESSION['ID'];
		$result = mysqli_query($db,$query);	
		include 'ev_wobjbonus.php';
		check_active_quest();
	}
	else
	{
		echo 'Неправильный ответ. ';
	}
}

if ($_POST['action']=='HackEnemy')
{
	if (!isset($_SESSION['EPLID'])) {echo 'Не выбран вражеский игрок'; return;}
	if ($_SESSION['EPLID']==-1) {echo 'Не выбран вражеский игрок'; return;}
	//определяем возможность действия
	$query = 'SELECT count(*) FROM t_key_digits WHERE PLID='.$_SESSION['ID'].' AND EPLID='.$_SESSION['EPLID'].' AND keynum='.$_POST['ind'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	if ($line[0]==0) {echo 'Для подбора кода необходимо знать хотя бы одну цифру'; return;}
	
	$query = 'SELECT energy FROM t_res WHERE ID='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	if ($line[0]<5) {echo 'Недостаточно энергии для выполения действия';return;}
	
	//уменьшаем количество энергии
	$query='UPDATE t_res SET energy=energy-5 WHERE ID='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	
	//Определяем код вражеского игрока
	$query='SELECT keyv FROM t_keys WHERE keyt='.$_POST['ind'].' AND plid='.$_SESSION['EPLID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$truekey=$line[0];
	
	if ($truekey==$_POST['sol'])
	{
		echo 'Вы подобрали пароль';
		//Награда за сокровищницу
		if ($_POST['ind']==1)
		{
			$query='SELECT gold,meat,bones,energy,stone FROM t_res WHERE ID='.$_SESSION['EPLID'];
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			for ($i=0;$i<=4;$i++)
			{
				$line[$i]=floor($line[$i]/2);
			}
			
			$query = 'UPDATE t_res SET gold=gold+'.$line[0].', meat=meat+'.$line[1].', bones=bones+'.$line[2].', energy=energy+'.$line[3].', stone=stone+'.$line[4].' WHERE ID='.$_SESSION['ID'];
			mysqli_query($db,$query);
			$query = 'UPDATE t_res SET gold=gold-'.$line[0].', meat=meat-'.$line[1].', bones=bones-'.$line[2].', energy=energy-'.$line[3].', stone=stone-'.$line[4].' WHERE ID='.$_SESSION['EPLID'];
			mysqli_query($db,$query);
		}
		//Награда за казармы
		if ($_POST['ind']==2)
		{
			$query = 'SELECT uid,co FROM t_army WHERE plid='.$_SESSION['EPLID'];
			$result = mysqli_query($db,$query);
			while ($line = mysqli_fetch_row($result))
			{
				$uid = $line[0];
				$co1 = $line[1];
				$co2=0;
				$d = round($co1/3);
				
				$query = 'SELECT co FROM t_army WHERE uid='.$uid.' AND plid='.$_SESSION['ID'];
				$result = mysqli_query($db,$query);
				if ($line = mysqli_fetch_row($result))
				{
					$co2 = $line[0];
				}
				
				if ($co2==0)
				{
					$query = 'INSERT INTO t_army (plid,uid,co) VALUES ('.$_SESSION['ID'].','.$uid.','.$d.')';
					$result = mysqli_query($db,$query);
				}
				else
				{
					$query = 'UPDATE t_army SET co=co+'.$d.' WHERE uid='.$uid.' AND plid='.$_SESSION['ID'];
					$result = mysqli_query($db,$query);
				}
				
				if ($co1-$d>=0)
				{
					$query = 'UPDATE t_army SET co=co-'.$d.' WHERE uid='.$uid.' AND plid='.$_SESSION['EPLID'];
					$result = mysqli_query($db,$query);					
				}
				else
				{
					$query = 'DELETE FROM t_army WHERE uid='.$uid.' AND plid='.$_SESSION['ID'];
					$result = mysqli_query($db,$query);					
				}
			}
		}
		//Награда за подземелье
		if ($_POST['ind']==3)
		{
			$query = 'SELECT count(*) FROM t_buildings WHERE plid='.$_SESSION['EPLID'];
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			if ($line[0]>0)
			{
				do
				{
					$r=rand(1,8);
					$query = 'SELECT zd FROM t_buildings WHERE plid='.$_SESSION['EPLID'].' AND zdid='.$r;
					$result = mysqli_query($db,$query);				
				}
				while (!mysqli_fetch_row($result));
				
				$query = 'DELETE FROM t_buildings WHERE plid='.$_SESSION['EPLID'].' AND zdid='.$r;
				$result = mysqli_query($db,$query);					
			
			}
		}
		//Сброс паролей
		for ($i=1;$i<=3;$i++)
		{
			$r=rand(0,99);
			$query = 'UPDATE t_keys SET keyv='.$r.' WHERE keyt='.$i.' AND plid='.$_SESSION['EPLID'];
			$result = mysqli_query($db,$query);			
		}
	}
	else
	{
		echo 'Вы ошиблись';
	}
}



if ($_POST['action']=='visit')
{
	$query = 'SELECT point FROM t_main_plinfo WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);	
	$line = mysqli_fetch_row($result);	
	$pointnum = $line[0];
	//алгоритм определения времени перемещения
	require 'inc_algas.php';
	$obj = new AlgAS();
	$obj->sx = $pointnum % 40;
	$obj->sy = floor($pointnum / 40);
	$obj->ex = $_SESSION['FSX'];
	$obj->ey = $_SESSION['FSY'];	
	$distance =  floor($obj->alg_calc()/100);
	echo $distance;
	
	$query = 'UPDATE t_main_plinfo SET movetime = '.$distance.',actiontype = 1 WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	
}

?>

