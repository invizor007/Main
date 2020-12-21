<?php
session_start();

$db = mysqli_connect("localhost","pma","","bg1");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}
mysqli_set_charset($db, 'utf8');

if ($_POST['action'] == 'getxy')
{
	$query = 'SELECT x,y FROM t_bat_ustat where actor_id='.$_SESSION['u_yoe'].' and u_num='.$_SESSION['u_num'].' and battle_id='.$_SESSION['battle_id'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	echo ($line[1]*6)+$line[0];
}

if ($_POST['action'] == 'battlehod')
{
	if ($_SESSION['battleend']!=0)
	{
		echo 'Битва уже завершена. Нажмите выход из битвы';
		exit();
	}

	if ($_SESSION['u_yoe']==1)//если вы ходите
	{
		//Проверяем атаковал ли наш юнит если нет то выходим
		$query = 'SELECT action FROM t_bat_ustat where actor_id='.$_SESSION['u_yoe'].' and u_num='.$_SESSION['u_num'].' and battle_id='.$_SESSION['battle_id'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		if (!isset($_SESSION['batyskip'])) $_SESSION['batyskip'] = 0;
		if ( ($line[0]==0)and($_SESSION['batyskip'] == 0) )
		{
			echo 'Ваш юнит еще не атаковал. Проведите атаку. Если хотите пропустить ход нажмите еще раз.';
			$_SESSION['batyskip'] = 1;
			exit();
		}
		if ( ($line[0]==0)and($_SESSION['batyskip'] == 1) )
		{
			echo 'Пропускаем ход.';
			$_SESSION['batyskip'] = 0;
		}
	}
	else//если ходит компьютер
	{
		$query = 'SELECT ms,tat,dmg FROM uinfo where id='.$_SESSION['u_tip'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$ms=$line[0];
		$tat=$line[1];
		$dmg=$line[2];
		//echo 'ms='.$ms.' tat='.$tat.' dmg='.$dmg;
		
		if ($tat==0)//Выбираем кого можно атаковать исходя из скорости - это условие заносим в cond
		{
			$arr_x[0]=$_SESSION['cux'];
			$arr_y[0]=$_SESSION['cuy'];
			$arr_i=1;		
			$query = 'SELECT x,y from t_bat_freepl where battle_id='.$_SESSION['battle_id'];
			$result = mysqli_query($db,$query);

			while ($line = mysqli_fetch_row($result)) 
			{
				if ( ($line[0]-$_SESSION['cux'])*($line[0]-$_SESSION['cux']) + ($line[1]-$_SESSION['cuy'])*($line[1]-$_SESSION['cuy']) <= $ms*$ms )
				{
					$arr_x[$arr_i] = $line[0];
					$arr_y[$arr_i] = $line[1];
					$arr_i++;
				}
			}
			
			$cond=' and u_num in (';
			for ($i=0;$i<=7;$i++)
			{
				if ( ($i>=3)and($i<=5) ) $x=1; else $x=2;
				
				if ( ($i>=0)and($i<=2) ) $y = ($i-0)+1;
				else if ( ($i>=3)and($i<=5) ) $y = ($i-3)+1;			
				else if ($i==6) $y=0;
				else if ($i==7) $y=4;

				for ($j=0;$j<$arr_i;$j++)
				{
					if ( (abs($arr_x[$j]-$x)<=1)and(abs($arr_y[$j]-$y)<=1) )
					{
						$cond = $cond.$i.',';
						break;
					}
				}
			}
			$cond=$cond.'100)';
			//echo ' cond'.$cond;
		}
		else $cond='';
		
		//селектим минимальное хп у существа
		$query = 'SELECT min(chp) from t_bat_ustat where actor_id=1 and battle_id='.$_SESSION['battle_id'].$cond;
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$mchp = $line[0];
		
		//выбираем существо с минимальным хп (первое попавшееся)
		$query = 'SELECT u_num,bonus_d,x,y,u_tip from t_bat_ustat where actor_id=1 and battle_id='.$_SESSION['battle_id'].' and chp='.$mchp.$cond;
		$result = mysqli_query($db,$query);
		if ($result) {
		$line = mysqli_fetch_row($result);
		$u_num = $line[0];
		$u_tip = $line[4];
		//Теперь производим атаку на юнит u_num
		$mchp-=($dmg-$line[1]);
		$query='UPDATE t_bat_ustat SET chp='.$mchp.' WHERE actor_id=1 and battle_id='.$_SESSION['battle_id'].' and u_num='.$u_num;
		$result = mysqli_query($db,$query);
		if ($mchp<=0)//Вы теряете юнита
		{
			$query = 'DELETE FROM t_bat_ustat where actor_id=1 and battle_id='.$_SESSION['battle_id'].' and u_num='.$u_num;
			$result = mysqli_query($db,$query);
			$query = 'INSERT INTO t_bat_freepl (BATTLE_ID,X,Y) VALUES ('.$_SESSION['battle_id'].','.$line[2].','.$line[3].')';
			$result = mysqli_query($db,$query);	
			switch ($u_num)
			{
				case 0: $query = 'UPDATE t_bat_units SET m1=0 where actor_id=1 and battle_id='.$_SESSION['battle_id']; break;
				case 1: $query = 'UPDATE t_bat_units SET m2=0 where actor_id=1 and battle_id='.$_SESSION['battle_id']; break;
				case 2: $query = 'UPDATE t_bat_units SET m3=0 where actor_id=1 and battle_id='.$_SESSION['battle_id']; break;
				case 3: $query = 'UPDATE t_bat_units SET a1=0 where actor_id=1 and battle_id='.$_SESSION['battle_id']; break;
				case 4: $query = 'UPDATE t_bat_units SET a2=0 where actor_id=1 and battle_id='.$_SESSION['battle_id']; break;
				case 5: $query = 'UPDATE t_bat_units SET a3=0 where actor_id=1 and battle_id='.$_SESSION['battle_id']; break;
				case 6: $query = 'UPDATE t_bat_units SET c1=0 where actor_id=1 and battle_id='.$_SESSION['battle_id']; break;
				case 7: $query = 'UPDATE t_bat_units SET c2=0 where actor_id=1 and battle_id='.$_SESSION['battle_id']; break;
			}
			$result = mysqli_query($db,$query);	
			
			
			switch ($u_num)
			{
				case 0: $query = 'UPDATE t_account_army SET m1=0 where actor_id=1 and account_id='.$_SESSION['ID']; break;
				case 1: $query = 'UPDATE t_account_army SET m2=0 where actor_id=1 and account_id='.$_SESSION['ID']; break;
				case 2: $query = 'UPDATE t_account_army SET m3=0 where actor_id=1 and account_id='.$_SESSION['ID']; break;
				case 3: $query = 'UPDATE t_account_army SET a1=0 where actor_id=1 and account_id='.$_SESSION['ID']; break;
				case 4: $query = 'UPDATE t_account_army SET a2=0 where actor_id=1 and account_id='.$_SESSION['ID']; break;
				case 5: $query = 'UPDATE t_account_army SET a3=0 where actor_id=1 and account_id='.$_SESSION['ID']; break;
				case 6: $query = 'UPDATE t_account_army SET c1=0 where actor_id=1 and account_id='.$_SESSION['ID']; break;
				case 7: $query = 'UPDATE t_account_army SET c2=0 where actor_id=1 and account_id='.$_SESSION['ID']; break;
			}
			$result = mysqli_query($db,$query);	
			$query = 'SELECT co FROM user_u where account_id='.$_SESSION[ID].' and u_id='.$u_tip;
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			if ($line[0]==1) {$query = 'DELETE FROM user_u where account_id='.$_SESSION[ID].' and u_id='.$u_tip;}
			else {$query = 'UPDATE user_u SET co=co-1 where account_id='.$_SESSION[ID].' and u_id='.$u_tip;}
			$result = mysqli_query($db,$query);
			
			
			//Нужно проверить не все ли потеряно
			$query = 'SELECT m1+m2+m3+a1+a2+a3+c1+c2 from t_bat_units where actor_id=1 and battle_id='.$_SESSION['battle_id'];
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			if ($line[0]==0)
			{
				echo ' К сожалению вам не удалось победить защитников. Нажмите "выход из битвы"';
				$_SESSION['battleend']=1;
			}
		}
		} //обновляем признак того что наш юнит уже сходил
		$query = 'UPDATE t_bat_ustat SET action=1 where actor=2 and battle_id='.$_SESSION['battle_id'].' and u_num='.$_SESSION['u_num'];
		$result = mysqli_query($db,$query);

	}

	//определение текущего игрока, который ходит
	$query = 'SELECT count(*) FROM t_bat_ustat where battle_id='.$_SESSION['battle_id'].' and action=0';
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	if ($line[0]==0)
	{
		$query='UPDATE t_bat_ustat SET action=0 where battle_id='.$_SESSION['battle_id'];
		$result = mysqli_query($db,$query);
		if (!$result) {echo 'Ошибка выполнения sql';}
	}
	
	do
	{
		$_SESSION['u_yoe'] = rand(1,2);
		$_SESSION['u_num'] = rand(0,8);
		$query = 'SELECT m1,m2,m3,a1,a2,a3,c1,c2,t from t_bat_units where battle_id='.$_SESSION['battle_id'].' and actor_id='.$_SESSION['u_yoe'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$u_unit = $line[$_SESSION['u_num']];
		//Проверка на то не походил ли еще наш юнит
		$query = 'SELECT action FROM t_bat_ustat WHERE actor_id='.$_SESSION['u_yoe'].' and u_num='.$_SESSION['u_num'].' and battle_id='.$_SESSION['battle_id'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		if ($line[0]==1) {$u_unit=0;}
	}
	while ($u_unit==0);
	
	$query = 'SELECT x,y,u_tip FROM t_bat_ustat where actor_id='.$_SESSION['u_yoe'].' and u_num='.$_SESSION['u_num'].' and battle_id='.$_SESSION['battle_id'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$_SESSION['cux']=$line[0];
	$_SESSION['cuy']=$line[1];
	$_SESSION['u_tip']=$line[2];	
}

if ($_POST['action'] == 'armyclick')
{
	$x=$_POST['id'] % 6;
	$y=floor($_POST['id'] / 6);

	if ($_SESSION['battleclicktype'] == 'info')
	{
		//показываем информацию о юните
		
		$query = 'SELECT u_tip,hp,chp,bonus_a,bonus_d,dmg FROM t_bat_ustat where x='.$x.' and y='.$y.' and battle_id='.$_SESSION['battle_id'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		
		if ($line[0]=='')
		{
			echo '<br>';
			exit();
		}
		
		if ($line[0]!=99)
		{
			$query = 'SELECT name,tip,ms,tat FROM uinfo where id='.$line[0];
			$result = mysqli_query($db,$query);
			$line2 = mysqli_fetch_row($result);
			$arr_ut = array(1=>'Пехота',2=>'Лучник',3=>'Конница');
			$arr_ua = array(0=>'Ближняя',1=>'Стрелковая');
		
			$s = '<font color="purple" size=4><b>'.$line2[0].'<br>Здоровье '.$line[2].'/'.$line[1].'<br>Урон '.$line[5].'+'.$line[3].'<br> Защита '.$line[4].
				'<br>Тип:'.$arr_ut[$line2[1]].'<br>Скорость '.$line2[2].'<br>Атака:'.$arr_ua[$line2[3]].'</b></font>';
		}
		else
		{
			$query = 'SELECT dmg from t_bat_ustat where x='.$x.' and y='.$y.' and battle_id='.$_SESSION['battle_id'];
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			$s = '<font color="red">'.'Башня. Урон '.$line[0].'</font>';
		}
		
		echo $s;
		
	}
	
	if ($_SESSION['battleclicktype'] == 'attack')
	{
		if ($_SESSION['u_yoe']==2)
		{
			echo 'Сейчас ходит компьютер. Нажмите кнопку "Ход".';
			exit();
		}
		$query = 'SELECT action from t_bat_ustat where actor_id=1 and battle_id='.$_SESSION['battle_id'].' and u_num='.$_SESSION['u_num'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		if ($line[0]==1)
		{
			echo 'Юнит уже походил. Нажмите "Ход" для продолжения';
			exit();
		}
		
		if ($x <=2)
		{	
			echo 'Необходимо выбрать врага';
			exit();
		}
		$query = 'SELECT count(*) from t_bat_ustat where battle_id='.$_SESSION['battle_id'].' and x='.$x.' and y='.$y;
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		if ($line[0]==0)
		{
			echo 'Необходимо выбрать врага';
			exit();			
		}
		
		$query = 'SELECT ms,tat,dmg FROM uinfo where id='.$_SESSION['u_tip'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$ms=$line[0];
		$tat=$line[1];
		$dmg=$line[2];
		//echo 'ms='.$ms.' tat='.$tat.' dmg='.$dmg;
		
		if ($tat==0)
		{
			$arr_x[0]=$_SESSION['cux'];
			$arr_y[0]=$_SESSION['cuy'];
			$arr_i=1;		
			$query = 'SELECT x,y from t_bat_freepl where battle_id='.$_SESSION['battle_id'];
			$result = mysqli_query($db,$query);

			while ($line = mysqli_fetch_row($result)) 
			{
				if ( ($line[0]-$_SESSION['cux'])*($line[0]-$_SESSION['cux']) + ($line[1]-$_SESSION['cuy'])*($line[1]-$_SESSION['cuy']) <= $ms*$ms )
				{//$arr_x[$arr_i]=2 $arr_y[$arr_i]=0 $arr_i=1$arr_x[$arr_i]=3 $arr_y[$arr_i]=1 $arr_i=2
					$arr_x[$arr_i] = $line[0];
					$arr_y[$arr_i] = $line[1];
					//echo ' $arr_x[$arr_i]='.$arr_x[$arr_i].' $arr_y[$arr_i]='.$arr_y[$arr_i].' $arr_i='.$arr_i; 
					$arr_i++;
				}
			}
			
			$cond=' and u_num in (';
			for ($i=0;$i<=7;$i++)
			{
				if ( ($i>=3)and($i<=5) ) $tx=1; else $tx=2;
				
				if ( ($i>=0)and($i<=2) ) $ty = ($i-0)+1;
				else if ( ($i>=3)and($i<=5) ) $ty = ($i-3)+1;			
				else if ($i==6) $ty=0;
				else if ($i==7) $ty=4;

				for ($j=0;$j<$arr_i;$j++)
				{
					if ( (abs($arr_x[$j]-$tx)<=1)and(abs($arr_y[$j]-$ty)<=1) )
					{
						$cond = $cond.$i.',';
						break;
					}
				}
			}
			$cond=$cond.'100)';			
		}
		else $cond='';
		
		//echo '$cond='.$cond;//and u_num in (0,1,3,4,6,100)
		
		
		$query = 'SELECT chp from t_bat_ustat where actor_id=2 and battle_id='.$_SESSION['battle_id'].$cond;
		$result = mysqli_query($db,$query);
		if (!$result)
		{
			echo 'Вы не достаете до указанного юнита';
			exit();
		}
		$line = mysqli_fetch_row($result);
		if ($line[0]=='')
		{
			echo 'Вы не достаете до указанного юнита!';
			exit();
		}
		
		//echo ' $x='.$x.' $y='.$y;
		$query = 'SELECT u_num,chp,bonus_a from t_bat_ustat where actor_id=2 and battle_id='.$_SESSION['battle_id'].' and X='.$x.' and Y='.$y;
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$u_num = $line[0];
		$chp = $line[1];
		//echo ' $u_num='.$u_num.'$chp='.$chp;
		//Теперь производим атаку на юнит u_num
		$chp-=($dmg+$line[2]);
		$query='UPDATE t_bat_ustat SET chp='.$chp.' WHERE actor_id=2 and battle_id='.$_SESSION['battle_id'].' and u_num='.$u_num;
		$result = mysqli_query($db,$query);
		if ($chp<=0)
		{
			$query = 'DELETE FROM t_bat_ustat where actor_id=2 and battle_id='.$_SESSION['battle_id'].' and u_num='.$u_num;
			$result = mysqli_query($db,$query);
			$query = 'INSERT INTO t_bat_freepl (BATTLE_ID,X,Y) VALUES ('.$_SESSION['battle_id'].','.$x.','.$y.')';
			$result = mysqli_query($db,$query);	
			switch ($u_num)
			{
				case 0: $query = 'UPDATE t_bat_units SET m1=0 where actor_id=2 and battle_id='.$_SESSION['battle_id']; break;
				case 1: $query = 'UPDATE t_bat_units SET m2=0 where actor_id=2 and battle_id='.$_SESSION['battle_id']; break;
				case 2: $query = 'UPDATE t_bat_units SET m3=0 where actor_id=2 and battle_id='.$_SESSION['battle_id']; break;
				case 3: $query = 'UPDATE t_bat_units SET a1=0 where actor_id=2 and battle_id='.$_SESSION['battle_id']; break;
				case 4: $query = 'UPDATE t_bat_units SET a2=0 where actor_id=2 and battle_id='.$_SESSION['battle_id']; break;
				case 5: $query = 'UPDATE t_bat_units SET a3=0 where actor_id=2 and battle_id='.$_SESSION['battle_id']; break;
				case 6: $query = 'UPDATE t_bat_units SET c1=0 where actor_id=2 and battle_id='.$_SESSION['battle_id']; break;
				case 7: $query = 'UPDATE t_bat_units SET c2=0 where actor_id=2 and battle_id='.$_SESSION['battle_id']; break;
			}
			$result = mysqli_query($db,$query);	
			//Нужно проверить не все ли потеряно
			$query = 'SELECT m1+m2+m3+a1+a2+a3+c1+c2 from t_bat_units where actor_id=2 and battle_id='.$_SESSION['battle_id'];
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			if ($line[0]==0)
			{
				echo 'Вы победили. Нажмите "выход из битвы"';
				$_SESSION['battleend']=2;
			}
		}
		$query = 'UPDATE t_bat_ustat SET action=1 where actor_id=1 and battle_id='.$_SESSION['battle_id'].' and u_num='.$_SESSION['u_num'];
		$result = mysqli_query($db,$query);
		//echo $query;
		
		echo 'Успешная атака на противника';
	}
}

if ($_POST['action'] == 'battleinfo')
{
	$_SESSION['battleclicktype'] = 'info';
	echo 'Смотрим информацию о юните, который вы выделите';
}

if ($_POST['action'] == 'battleattack')
{
	if ($_SESSION['battleend']!=0)
	{
		echo 'Битва уже завершена. Нажмите выход из битвы';
		exit();
	}

	$_SESSION['battleclicktype'] = 'attack';
	echo 'Выберите юнита который атаковать';
}

if ($_POST['action'] == 'battleend')
{
	
	if ($_SESSION['battleend']==2)//Если вы победили то добавляется бонус
	{
		echo 'Вы получаете ресурсы. ';
		switch ($_SESSION['res_n'])
		{
			case 1: { $_SESSION['wood']+=$_SESSION['res_v']; $query = 'UPDATE t_account SET wood=wood+'.$_SESSION['res_v'].' where id='.$_SESSION['ID']; break;}
			case 2: { $_SESSION['gold']+=$_SESSION['res_v']; $query = 'UPDATE t_account SET gold=gold+'.$_SESSION['res_v'].' where id='.$_SESSION['ID']; break;}
			case 3: { $_SESSION['food']+=$_SESSION['res_v']; $query = 'UPDATE t_account SET food=food+'.$_SESSION['res_v'].' where id='.$_SESSION['ID']; break;}
			case 4: { $_SESSION['stone']+=$_SESSION['res_v'];$query = 'UPDATE t_account SET stone=stone+'.$_SESSION['res_v'].' where id='.$_SESSION['ID']; break;}
		}
		$result = mysqli_query($db,$query);
		
		$query = 'UPDATE t_account SET exp=exp+1 where id='.$_SESSION['ID'];
		$result = mysqli_query($db,$query);
		$query = 'SELECT exp from t_account where id = '.$_SESSION['ID'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		
		$inclev = array(1,3,5,8,11,15,20,25,30,36,43,50);		
		if(in_array($line[0], $inclev))
		{
			//Условие на увеличение уровня сработало
			$query = 'UPDATE t_account SET lev=lev+1,wood=wood+50,gold=gold+50,food=food+50,stone=stone+50 where id='.$_SESSION['ID'];
			$result = mysqli_query($db,$query);			
			$_SESSION['wood']+=50;$_SESSION['gold']+=50;$_SESSION['food']+=50;$_SESSION['stone']+=50;
			echo 'А также вы получаете один уровень и ресурсы.';
		}
		
	}
	else
	{
		echo 'Выходим из битвы';
	}
}
?>
