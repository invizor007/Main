<?php
session_start();

function dblog($name,$val)
{
	$db = mysqli_connect("localhost","bg2user","","bg2");
	$query = "INSERT INTO T_LOG(NAME,VALUE,DT) VALUES ('".$name."',".$val.",NOW())";
	//$_SESSION['log']=$query;
	$result = mysqli_query($db,$query);
	return 0;
}

function nagrada($plwin)
{
	$query = 'UPDATE t_accounts SET exp=exp+1 WHERE id='.$plwin;
	$result = mysqli_query($db,$query);
	
	$query = 'SELECT exp from t_accounts WHERE id='.$plwin;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	
	//Добавить уровень
	$inclev = array(2,5,9,14,20,27,35,45,57,70,85,105,130,160,200);		
	if (in_array($line[0], $inclev))
	{
		//Условие на увеличение уровня сработало
		$query = 'UPDATE t_account SET lev=lev+1 where id='.plwin;
		$result = mysqli_query($db,$query);	

		$query = 'UPDATE t_account_stat SET free_max=free_max+1 where id='.plwin;
		$result = mysqli_query($db,$query);	
	}
	//Добавить артефакт
	if ($line[0] % 5==0)
	{
		$art_num = rand(1,10);
		$query = 'SELECT max(place) FROM t_user_arts WHERE login_id = '.$plwin;
		$result = mysqli_query($db,$query);	
		$line = mysqli_fetch_row($result);
		$place_num = $line[0];
		if ($place_num <> 15)
		{
			$query = 'INSERT INTO t_user_arts (LOGIN_ID,NUM,PLACE,QUAN) VALUES ('.$plwin.','.$art_num.','.$place_num.',4)';
			$result = mysqli_query($db,$query);
		}				
	}	
}

$db = mysqli_connect("localhost","bg2user","","bg2");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

if ($_POST['action']=='timer')
{
	$query = 'UPDATE t_accounts SET battime = battime-10 WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	
	$query = 'SELECT battime FROM t_accounts WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);	
	$line = mysqli_fetch_row($result);
	echo $line[0];
}
if ($_POST['action']=='battlenexthod')
{
	$query = 'UPDATE t_accounts SET battime = 90 WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	//exit();
	
	$query = 'SELECT chp,hpm,dmg,mana,mnm FROM t_bat_stat WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);
	$line1 = mysqli_fetch_row($result);
	
	$query = 'SELECT chp,hpm,dmg,mana,mnm,monstr FROM t_bat_stat WHERE battle_id='.$_SESSION['battle_id'].' and actor=3-'.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);
	$line2 = mysqli_fetch_row($result);
	
	$query = 'SELECT t_att,t_def,spell1,spell2,spell3 FROM t_bat_choice WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);
	$line3 = mysqli_fetch_row($result);	
	
	$query = 'SELECT t_att,t_def,spell1,spell2,spell3 FROM t_bat_choice WHERE battle_id='.$_SESSION['battle_id'].' and actor=3-'.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);
	$line4 = mysqli_fetch_row($result);

	$dmg_y = $line1[2];
	$dmg_e = $line2[2];
	$block_y = array (1=>1,2=>1,3=>1);
	$block_e = array (1=>1,2=>1,3=>1);
	
	//эффекты ледяная стрела,волшебный кулак, зыбучие пески +огненный шар
	$is_cast_13 = 0;
	if ((($line3[2]==1)||($line3[3]==1)||($line3[4]==1))&&($is_cast_13==0))
	{
		$is_cast_13=1;
		$dmg_y+=15;
		$line3[0]=2;//в туловище
	}
	if ((($line3[2]==2)||($line3[3]==2)||($line3[4]==2))&&($is_cast_13==0))
	{
		$is_cast_13=1;
		$dmg_y+=10;
		$line3[0]=1;//в голову
	}	
	if ((($line3[2]==3)||($line3[3]==3)||($line3[4]==3))&&($is_cast_13==0))
	{
		$is_cast_13=1;
		$dmg_y+=10;
		$line3[0]=3;//в ноги
	}
	if (  ($line3[2]==10)||($line3[3]==10)||($line3[4]==10) )
	{
		$dmg_y+=20;
	}	
	
	//эффекты ледяная стрела,волшебный кулак, зыбучие пески +огненный шар
	$is_cast_13 = 0;
	if ((($line4[2]==1)||($line4[3]==1)||($line4[4]==1))&&($is_cast_13==0))
	{
		$is_cast_13=1;
		$dmg_e+=15;
		$line4[0]=2;//в туловище
	}
	if ((($line4[2]==2)||($line4[3]==2)||($line4[4]==2))&&($is_cast_13==0))
	{
		$is_cast_13=1;
		$dmg_e+=10;
		$line4[0]=1;//в голову
	}	
	if ((($line4[2]==3)||($line4[3]==3)||($line4[4]==3))&&($is_cast_13==0))
	{
		$is_cast_13=1;
		$dmg_e+=10;
		$line4[0]=3;//в ноги
	}
	if (  ($line4[2]==10)||($line4[3]==10)||($line4[4]==10) )
	{
		$dmg_e+=20;
	}
	
	//Блокировки
	if ($line3[1]==1) $block_y[1]=0.5;
	if ($line3[1]==2) $block_y[2]=0.5;
	if ($line3[1]==3) $block_y[3]=0.5;
	
	$is_cast_45 = 0;
	if (($line3[2]==5)||($line3[3]==5)||($line3[4]==5))
	{
		$block_y[3]=0;
		$is_cast_45 = 1;
	}
	if ((($line3[2]==4)||($line3[3]==4)||($line3[4]==4))&&($is_cast_45==0))
	{
		$block_y[1]=0;
		$dmg_y+=5;
		$is_cast_45 = 1;
	}
	$is_cast_45 = 0;
	if (($line3[2]==5)||($line3[3]==5)||($line3[4]==5))
	{
		$block_y[3]=0;
		$is_cast_45 = 1;
	}
	if (($line3[2]==6)||($line3[3]==6)||($line3[4]==6))
	{
		$block_y[1]=0;
		$block_y[2]=0;
		$block_y[3]=0;
	}	
	if (($line3[2]==7)||($line3[3]==7)||($line3[4]==7))
	{
		$block_y[1]*=0.66;
		$block_y[2]*=0.66;
		$block_y[3]*=0.66;
	}
	if (($line3[2]==8)||($line3[3]==8)||($line3[4]==8))
	{
		if ($line3[1]==1) $block_y[1]=0;
		if ($line3[1]==2) $block_y[2]=0;
		if ($line3[1]==3) $block_y[3]=0;	
	}
	$oshy = 0;
	if (($line3[2]==8)||($line3[3]==8)||($line3[4]==8))
	{
		$oshy = 1;
	}
	//Блокировки для врага
	if ($line4[1]==1) $block_e[1]=0.5;
	if ($line4[1]==2) $block_e[2]=0.5;
	if ($line4[1]==3) $block_e[3]=0.5;
	
	$is_cast_45 = 0;
	if (($line4[2]==5)||($line4[3]==5)||($line4[4]==5))
	{
		$block_e[3]=0;
		$is_cast_45 = 1;
	}
	if ((($line4[2]==4)||($line4[3]==4)||($line4[4]==4))&&($is_cast_45==0))
	{
		$block_e[1]=0;
		$dmg_e+=5;
		$is_cast_45 = 1;
	}
	$is_cast_45 = 0;
	if (($line4[2]==5)||($line4[3]==5)||($line4[4]==5))
	{
		$block_e[3]=0;
		$is_cast_45 = 1;
	}
	if (($line4[2]==6)||($line4[3]==6)||($line4[4]==6))
	{
		$block_e[1]=0;
		$block_e[2]=0;
		$block_e[3]=0;
	}	
	if (($line4[2]==7)||($line4[3]==7)||($line4[4]==7))
	{
		$block_e[1]*=0.66;
		$block_e[2]*=0.66;
		$block_e[3]*=0.66;
	}
	if (($line4[2]==8)||($line4[3]==8)||($line4[4]==8))
	{
		if ($line4[1]==1) $block_e[1]=0;
		if ($line4[1]==2) $block_e[2]=0;
		if ($line4[1]==3) $block_e[3]=0;	
	}
	$oshe = 0;
	if (($line4[2]==8)||($line4[3]==8)||($line4[4]==8))
	{
		$oshe = 1;
	}
	//Случай если вы сражаетесь с монстрами
	if ($line2[5]>0)
	{
		$query = 'SELECT prh,prb,prl FROM t_monstrs WHERE id='.$line2[5];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$r = rand(0,99);
		if ($r<$line[0]) $t_att = 1;
		else if ($r<$line[0]+$line[1]) $t_att = 2;
		else $t_att = 3;
		$line3[0]=$t_att;
		
		if (($line2[5]==1)or($line2[5]==2))
		{
			$block_e[1]=0;
		}
		else if ($line[2]==3)
		{
			$block_e[1]=0;
			if (rand(1,2)==1) $block_e[2]=0;
			else $block_e[3]=0;
		}
		else if ($line[2]==4)
		{
			$r = rand(1,3);
			if ($r==1) {$block_e[1]=0;$block_e[2]=0;}
			else if ($r==2) {$block_e[1]=0;$block_e[3]=0;}
			else if ($r==3) {$block_e[2]=0;$block_e[3]=0;}
		}		
	}
	
	//Итоговый расчет уронов
	$_SESSION['dmgy'] = $dmg_y;
	$_SESSION['dmge'] = $dmg_e;
	
	$_SESSION['multe']=1;
	if ($line3[1]==1) $_SESSION['multe']=$block_y[1];
	if ($line3[1]==2) $_SESSION['multe']=$block_y[2];
	if ($line3[1]==3) $_SESSION['multe']=$block_y[3];
	
	$_SESSION['multy']=1;
	if ($line4[1]==1) $_SESSION['multy']=$block_e[1];
	if ($line4[1]==2) $_SESSION['multy']=$block_e[2];
	if ($line4[1]==3) $_SESSION['multy']=$block_e[3];	
	
	$_SESSION['dhpy'] = round($_SESSION['dmgy']*$_SESSION['multy']);
	$_SESSION['dhpe'] = round($_SESSION['dmge']*$_SESSION['multe']);
	
	for ($j=1;$j<=2;$j++) 
	{
		$temp_arr = array ();
		for ($i=0;$i<=2;$i++)
		{
			//Мы добавляем случайные карты игроку
			do
			{
				$r = rand(1,10);
			}
			while (in_array($r,$temp_arr));
			$temp_arr[$i] = $r;
			
			$query = 'UPDATE t_bat_cards set num ='.$r.' WHERE battle_id='.
				$_SESSION['battle_id'].' and actor='.$j.' and place='.$i;
			$result = mysqli_query($db,$query);
		}
	}
	
	//Восстановление маны
	$query = 'SELECT mana,mnr,mnm FROM t_bat_stat WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);
	$line=mysqli_fetch_row($result);
	$manares = 1;
	if ($line[1]<=1) $manares = 2;
	
	$newmana = $line[1]+$manares;
	if ($newmana>$line[2]) $newmana=$line[2];
	
	$query = 'UPDATE t_bat_stat SET mana = '.$newmana.' mnr='.$newmana.' WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);
	
	//Проверка на окончание битвы
	$newhp = $line1[0]-$_SESSION['dhpe'];
	$query = 'UPDATE t_bat_stat SET chp='.$newhp.' WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);
	
	$newhp2 = $line2[0]-$_SESSION['dhpy'];
	$query = 'UPDATE t_bat_stat SET chp='.$newhp2.' WHERE battle_id='.$_SESSION['battle_id'].' and actor=3-'.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);

	if ( ($newhp<=0)and($newhp2>0))
	{
		//выиграл второй игрок
		$query = 'SELECT monstr FROM t_bat_stat WHERE battle_id='.$_SESSION['battle_id'].' and actor=3-'.$_SESSION['battle_a'];
		$result = mysqli_query($db,$query);
		$line=mysqli_fetch_row($result);
		$plwin = -1;
		if ($line[0]==0)//игра была игрок против игрока
		{
			//добавляем игроку опыт, уровень
			$query = 'SELECT id FROM t_accounts WHERE bat='.$_SESSION['battle_id'].' and bata=3-'.$_SESSION['battle_a'];
			$result = mysqli_query($db,$query);
			$line[0]=mysqli_fetch_row($result);
			$plwin = $line[0];
			
			nagrada($plwin);
		}
		$query = 'UPDATE t_accounts SET bat=0,bata=0,battime=0 WHERE id='.$plwin;
		$result = mysqli_query($db,$query);
		echo 'endbattle';
		unset($_SESSION['battle_id']);unset($_SESSION['battle_a']);
		
		$query = 'UPDATE t_user_arts SET quan = quan - 1 WHERE place<10 and login_id IN ('.$plwin.','.$_SESSION['ID'].')';
		$result = mysqli_query($db,$query);
		$query = 'DELETE FROM t_user_arts WHERE place<10 and quan <=0 and login_id IN ('.$plwin.','.$_SESSION['ID'].')';
		$result = mysqli_query($db,$query);
	}
	
	if ( ($newhp2<=0)and($newhp>0))
	{
		//выиграл первый игрок
		$query = 'SELECT monstr FROM t_bat_stat WHERE battle_id='.$_SESSION['battle_id'].' and actor=3-'.$_SESSION['battle_a'];
		dblog('0',0);
		$result = mysqli_query($db,$query);
		$line=mysqli_fetch_row($result); dblog('1',1);
		if ($line[0]==0)//игра была между игроком и игроком
		{//награда с пвп и за пве может быть будут отличаться?
			//добавляем игроку опыт, уровень
			$query = 'SELECT id FROM t_accounts WHERE bat='.$_SESSION['battle_id'].' and bata='.$_SESSION['battle_a'];
			$result = mysqli_query($db,$query);
			$line[0]=mysqli_fetch_row($result);
			$plwin = $line[0]; //dblog('plwin',$plwin);
			nagrada($plwin);
		}
		else
		{ dblog('2',2);
			//добавляем игроку опыт, уровень
			$query = 'SELECT id FROM t_accounts WHERE bat='.$_SESSION['battle_id'].' and bata='.$_SESSION['battle_a'];
			$result = mysqli_query($db,$query);
			$line=mysqli_fetch_row($result);
			$plwin = $line[0];//dblog('plwin',$plwin);
			nagrada($plwin);
		}
		$query = 'UPDATE t_accounts SET bat=0,bata=0,battime=0 WHERE id='.$plwin;
		$result = mysqli_query($db,$query);
		echo 'endbattle';
		unset($_SESSION['battle_id']);unset($_SESSION['battle_a']);
		
		$query = 'UPDATE t_user_arts SET quan = quan - 1 WHERE place<10 and login_id IN ('.$plwin.','.$_SESSION['ID'].')';
		$result = mysqli_query($db,$query);
		$query = 'DELETE FROM t_user_arts WHERE place<10 and quan <=0 and login_id IN ('.$plwin.','.$_SESSION['ID'].')';
		$result = mysqli_query($db,$query);		
	}
	
	else if ( ($newhp<=0)and($newhp2<=0))
	{
		//никто не выиграл, просто битва завершается
		$query = 'UPDATE t_accounts SET bat=0,bata=0,battime=0 WHERE id='.$plwin;
		$result = mysqli_query($db,$query);
		echo 'endbattle';
		unset($_SESSION['battle_id']);unset($_SESSION['battle_a']);
		
		$query = 'UPDATE t_user_arts SET quan = quan - 1 WHERE place<10 and login_id IN ('.$plwin.','.$_SESSION['ID'].')';
		$result = mysqli_query($db,$query);
		$query = 'DELETE FROM t_user_arts WHERE place<10 and quan <=0 and login_id IN ('.$plwin.','.$_SESSION['ID'].')';
		$result = mysqli_query($db,$query);		
	}	
}

if ($_POST['action']=='battlesetcast')
{
	$ind = $_POST['id'];
	
	$query='SELECT spell1,spell2,spell3 FROM t_bat_choice WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$wasval = $line[$ind]; //echo $wasval;
	
	$query = 'SELECT num FROM t_bat_cards WHERE place='.$ind.' and battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	
	$query = 'SELECT mana FROM t_card_info WHERE id='.$line[0];
	$result = mysqli_query($db,$query);
	$line2 = mysqli_fetch_row($result);	
	
	$query = 'SELECT mnr FROM t_bat_stat WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);
	$line3 = mysqli_fetch_row($result);	
	//Проверка на количество маны
	if ( ($wasval==-1)and($line2[0]>$line3[0]) )
	{
		echo 'Недостаточно маны для применения заклинания';
		exit();
	}
	
	if ($wasval==-1)
	{
		$newnum = $line[0];
		echo 'Да';
		$query = 'UPDATE t_bat_stat SET mnr = '.($line3[0]-$line2[0]).' WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
		$result = mysqli_query($db,$query);
	}
	else
	{
		$newnum=-1;
		echo 'Нет';
		$query = 'UPDATE t_bat_stat SET mnr = '.($line3[0]+$line2[0]).' WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
		$result = mysqli_query($db,$query);		
	} //echo $newnum;
	switch ($ind)
	{
		case 0: $query = 'UPDATE t_bat_choice SET spell1 = '.$newnum.' WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];break;
		case 1: $query = 'UPDATE t_bat_choice SET spell2 = '.$newnum.' WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];break;
		case 2: $query = 'UPDATE t_bat_choice SET spell3 = '.$newnum.' WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];break;
	}
	$result = mysqli_query($db,$query);
}

if ($_POST['action']=='battlesetrandom')
{
	$t_att = rand(1,3);
	$t_def = rand(1,3);
	$t_spell_a = array (0=>-1,1=>-1,2=>-1);
	
	$query = 'SELECT mana FROM t_bat_stat WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$mana = $line[0];	
	
	for ($i=0;$i<3;$i++)
	{
		$r = rand(0,1); //echo $r;
		if ($r==1)
		{
			//Проверяем количество маны
			$query = 'SELECT num FROM t_bat_cards where place='.$i.' and battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			$castnum = $line[0];
			
			$query = 'SELECT mana FROM t_card_info WHERE id='.$castnum;
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			if ($mana>=$line[0])
			{
				$t_spell_a[$i] = $castnum;
				$mana-=$line[0];
			}
			else
			{
				$t_spell_a[$i]=-1;
			}
		}
		else
		{
			$t_spell_a[$i]=-1;
		}
		
	}
	
	$query = 'UPDATE t_bat_choice SET spell1='.$t_spell_a[0].',spell2='.$t_spell_a[1].',spell3='.$t_spell_a[2].
		',t_att='.$t_att.',t_def='.$t_def.' WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);
	
	$query = 'UPDATE t_bat_stat SET mnr='.$mana.
		' WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);	
	//echo $_SESSION['battle_a'].'<br>'.$query;
}

if ($_POST['action']=='battlesetatt')
{
	$ind = $_POST['id'];
	$query = 'UPDATE t_bat_choice SET t_att='.$ind.' WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);
}

if ($_POST['action']=='battlesetdef')
{
	$ind = $_POST['id'];
	$query = 'UPDATE t_bat_choice SET t_def='.$ind.' WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
	$result = mysqli_query($db,$query);
}
?>
