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

function player_force($plid,$makerep,$battype)
{
	$db = mysqli_connect("localhost","bg3user","","bg3");
	$query = 'SELECT uid,co FROM t_army WHERE plid='.$plid;
	$result = mysqli_query($db,$query);	
	
	$force = 0;
	$stackforce = 0;
	while ($line = mysqli_fetch_row($result))
	{
		$uid = $line[0];
		$co = $line[1];
		$query2 = 'SELECT pwr,ef1,ef2,ef3 FROM t_info_unit WHERE id='.$uid;
		$result2 = mysqli_query($db,$query2);
		$line2 = mysqli_fetch_row($result2);

		if (!isset($_SESSION['batpl']))
		{
			$_SESSION['batpl']=$battype;
		}
		
		$stackforce = round($line2[0]*0.1*$line2[$_SESSION['batpl']]);
		$force += $stackforce*$co;
		
		if ($makerep>0)
		{
			$query2 = 'INSERT INTO t_report(PLID,RTYPE,RID,VAL) VALUES ('.$_SESSION['ID'].','.$makerep.','.$uid.','.$co.')';
			$result2 = mysqli_query($db,$query2);
		}
	}
	return $force;
}

function dec_pl_force($pl,$f1,$f2,$makerep)
{
	$db = mysqli_connect("localhost","bg3user","","bg3");
	$fc = $f1;
	$prio = 0;
	
	do {
		$prio++;
		if ($prio>7)
		{
			$prio=1;
		}
		$query2 = 'SELECT pwr,ef1,ef2,ef3,id FROM t_info_unit WHERE prio='.$prio;
		$result2 = mysqli_query($db,$query2);
		$line2 = mysqli_fetch_row($result2);
		$stackforce = round($line2[0]*0.1*$line2[$_SESSION['batpl']]);
		$fc -= $stackforce;
		
		if ($fc+0.5*$stackforce<$f2)
		{
			$query = 'UPDATE t_army SET co = co - 1 WHERE plid='.$pl.' AND uid='.$line2[4];
			$result = mysqli_query($db,$query);
		}
	}
	while ($fc >= $f2);
	
	$query = 'DELETE FROM t_army WHERE co=0 AND plid='.$pl;
	mysqli_query($db,$query);
	
	if ($makerep>0)
	{
		$query = 'SELECT uid,co FROM t_army WHERE plid='.$pl;
		$result = mysqli_query($db,$query);
		
		while ($line = mysqli_fetch_row($result))
		{
			$query2 = 'INSERT INTO t_report(PLID,RTYPE,RID,VAL) VALUES ('.$_SESSION['ID'].','.$makerep.','.$line[0].','.$line[1].')';
			mysqli_query($db,$query2);
		}
		
	}	
}

function add_town_force($pl)
{
	$res = 500;
	
	$query = 'SELECT co FROM t_buildings WHERE zdid=1 AND plid='.$pl;
	$result = mysqli_query($db,$query);
	if (mysqli_fetch_row($result)) { $res+=1000;}

	$query = 'SELECT co FROM t_buildings WHERE zdid=2 AND plid='.$pl;
	$result = mysqli_query($db,$query);
	if (mysqli_fetch_row($result)) { $res+=500;}
	
	return res;
}

function do_fight_guards($num_b)
{
	$db = mysqli_connect("localhost","bg3user","","bg3");
	$query = 'SELECT uid,co1,co2 FROM t_info_guards WHERE guid='.$num_b;
	$result = mysqli_query($db,$query);	
	
	$force = 0;
	$bonus_meat = 0;
	$bonus_bones = 0;
	while ($line = mysqli_fetch_row($result))
	{
		$uid = $line[0];
		$co =  $line[1];
		
		$query2 = 'INSERT INTO t_report(PLID,RTYPE,RID,VAL) VALUES ('.$_SESSION['ID'].',2,'.$uid.','.$co.')';
		$result2 = mysqli_query($db,$query2);
		
		$query2 = 'SELECT pwr,ef1,ef2,ef3,tmeat,tbones FROM t_info_unit WHERE id='.$uid;
		$result2 = mysqli_query($db,$query2);
		$line2 = mysqli_fetch_row($result2);

		if (!isset($_SESSION['batpl']))
		{
			$_SESSION['batpl']=2;
		}
		
		$stackforce = round($line2[0]*0.1*$line2[$_SESSION['batpl']]);
		$force += $stackforce*$co;
		$bonus_meat += $line2[4]*$co;
		$bonus_bones += $line2[5]*$co;
	}
	
	$_SESSION['BMEAT'] = $bonus_meat;
	$_SESSION['BBONES'] = $bonus_bones;
	$_SESSION['LEForce'] = $force;
	$_SESSION['YForce'] = player_force($_SESSION['ID'],1,2);
	
	$gbon100 = 0;
	$query = 'SELECT qbon FROM t_main_plinfo WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	if (($line[0]>=100)and($line[0]<150))
	{
		$newval = $line[0]-1;
		if ($newval==100) {$newval=0;}
		$query = 'UPDATE t_main_plinfo SET qbon='.$newval.' WHERE id='.$_SESSION['ID'];
		mysqli_query($db,$query);
		$gbon100=1;
	}
	
	if ($_SESSION['LEForce']<$_SESSION['YForce']) 
	{
		//битва выиграна - уменьшение армии согласно урону
		$dforce = sqrt($_SESSION['YForce']*$_SESSION['YForce']-$_SESSION['LEForce']*$_SESSION['LEForce']);
		if ($gbon100==1) {$dforce=round(($_SESSION['YForce']+$dforce)/2);}
		$_SESSION['NYForce'] = round(($_SESSION['YForce']+$dforce)/2);
		dec_pl_force($_SESSION['ID'],$_SESSION['YForce'],$_SESSION['NYForce'],3);
		
		//Квест на победу определенного количества существ - прогресс
		$query = 'SELECT t2.valt,t1.id,t1.currc,t1.goalc FROM t_active_quest t1,t_info_quest t2 WHERE t1.qid = t2.id AND t2.qtype=1 AND t1.plid='.$_SESSION['ID'];
		$result = mysqli_query($db,$query);
		while ($line = mysqli_fetch_row($result))
		{
			$uid = $line[0];
			$query2 = 'SELECT co1 FROM t_info_guards WHERE uid='.$uid.' AND guid='.$num_b;
			$result2 = mysqli_query($db,$query2);
			if ($line2 = mysqli_fetch_row($result2))
			{
				$newcurrc= $line[2]+$line2[0];
				if ($newcurrc>$line[3]) {$newcurrc=$line[3];}
				$query3= 'UPDATE t_active_quest SET currc='.$newcurrc.' WHERE id='.$line[1];
				mysqli_query($db,$query3);
				include 'ev_wobjbonus.php';
				check_active_quest();
			}
		}
		
		$_SESSION['RepStat']='Битва выиграна';
		return 1;
	}
	else
	{
		//уменьшение армии наполовину
		$_SESSION['NYForce'] = round($_SESSION['YForce'] / 2);
		dec_pl_force($_SESSION['ID'],$_SESSION['YForce'],$_SESSION['NYForce'],3);
		$_SESSION['RepStat']='Битва проиграна';
		$_SESSION['BMEAT'] = 0;
		$_SESSION['BBONES']	= 0;	
		return 0;
	}
}

function do_give_bonus($num_c)
{
	//сначала добавляем мясо и кости за битву
	$db = mysqli_connect("localhost","bg3user","","bg3");
	if (!isset ($_SESSION['BMEAT']) ) {$_SESSION['BMEAT']=0;}
	if (!isset ($_SESSION['BBONES']) ) {$_SESSION['BBONES']=0;}
	$query = 'UPDATE t_res SET meat=meat+'.$_SESSION['BMEAT'].' WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$query = 'UPDATE t_res SET bones=bones+'.$_SESSION['BBONES'].' WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	
	$query0 = 'SELECT tid,co1,co2 FROM t_info_bonus WHERE bid='.$num_c; 
	$result0 = mysqli_query($db,$query0);	
	//if (!isset($result)) return;
	while ($line0 = mysqli_fetch_row($result0))
	{
		$tid = $line0[0];
		$co = $line0[1];
		
		$query = 'INSERT INTO t_report(PLID,RTYPE,RID,VAL) VALUES ('.$_SESSION['ID'].',4,'.$tid.','.$co.')';
		$result = mysqli_query($db,$query);		
		
		switch ($tid) {
		case 1: $query = 'UPDATE t_res SET gold=gold+'.$co.' WHERE id='.$_SESSION['ID'];
				$result = mysqli_query($db,$query);
				break;
		case 2: $query = 'UPDATE t_res SET meat=meat+'.$co.' WHERE id='.$_SESSION['ID'];
				$result = mysqli_query($db,$query);
				break;
		case 3: $query = 'UPDATE t_res SET bones=bones+'.$co.' WHERE id='.$_SESSION['ID'];
				$result = mysqli_query($db,$query);				
				break;
		case 4: $query = 'UPDATE t_res SET energy=energy+'.$co.' WHERE id='.$_SESSION['ID'];
				$result = mysqli_query($db,$query);		
				break;
		case 5: $query = 'UPDATE t_res SET stone=stone+'.$co.' WHERE id='.$_SESSION['ID'];
				$result = mysqli_query($db,$query);		
				break;				
		}
		
	}
	
	return 1;
}

function do_visit_secobj($objid)
{
	//Очистка отчета
	$db = mysqli_connect("localhost","bg3user","","bg3");
	$query = 'DELETE FROM t_report WHERE PLID='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);	
	unset($_SESSION['RepStat']);
	unset($_SESSION['RepFight']);
	
	//определение армии которая защищает объект
	$query = 'SELECT info,name FROM t_info_secobj WHERE id='.$objid;
	$result = mysqli_query($db,$query);	
	$line = mysqli_fetch_row($result);
	$msg = 'Вы посетили '.$line[1].'. ';
	//Расчеты по сражению
	$num_a = floor($line[0]/10000);
	$num_b = floor( ($line[0]-10000*$num_a) / 100 );
	$num_c = $line[0] % 100;
	
	$givebonus = 1;
	if ($num_b>0)
	{
		$givebonus = do_fight_guards($num_b);
		$_SESSION['RepFight']=$givebonus;
	}
	else
	{
		unset($_SESSION['RepFight']);
		$_SESSION['RepStat'] = 'Вы получаете бонусы';
	}
	
	
	if ($givebonus==1)//определение бонуса игроку
	{
		do_give_bonus($num_c);
		echo 'Вы получаете бонусы. ';
		$msg=$msg.'Вы получаете бонусы. ';
		
		//Продвижение по квестам
		$query = 'SELECT t2.valt,t1.id,t1.currc,t1.goalc FROM t_active_quest t1,t_info_quest t2 WHERE t1.qid = t2.id AND t2.qtype=2 AND t2.valt='.$objid.' AND plid='.$_SESSION['ID'];
		$result = mysqli_query($db,$query);		
		if ($line = mysqli_fetch_row($result))
		{
			$newcurrc = $line[2]+1;
			if ($newcurrc>$line[3]) {$newcurrc=$line[3];}
			$query2 = 'UPDATE t_active_quest SET currc='.$newcurrc.' WHERE id='.$line[1];
			mysqli_query($db,$query2);
			include 'ev_wobjbonus.php';
			check_active_quest();			
		}
	}
	else
	{
		echo 'Вы не смогли победить стражей. ';
		$msg=$msg.'Вы не смогли победить стражей. ';
	}
	//echo '__'.$msg.'__';
	$query = 'UPDATE t_message SET msg="'.$msg.'" WHERE msgid=1 AND PLID='.$_SESSION['ID'];
	mysqli_query($db,$query);
	
}

if ($_POST['action']=='move')
{	
	if (($_SESSION['SY']>0)&&($_POST['ind']==0))
	{
		$_SESSION['SY']-=5;
	}
	if (($_SESSION['SY']<25)&&($_POST['ind']==1))
	{
		$_SESSION['SY']+=5;
	}

	if (($_SESSION['SX']>0)&&($_POST['ind']==2))
	{
		$_SESSION['SX']-=5;
	}
	if (($_SESSION['SX']<15)&&($_POST['ind']==3))
	{
		$_SESSION['SX']+=5;
	}
}

if ($_POST['action']=='drill')
{
	if (!isset($_SESSION['sect'])) 
	{
		$_SESSION['sect'] = -1;
	}
	/////////......
	echo 'Переходим в город';
}

if ($_POST['action']=='setflag')
{
	$_SESSION['FSX']=$_SESSION['CSX'];
	$_SESSION['FSY']=$_SESSION['CSY'];
}

if ($_POST['action']=='clickxy')
{
	$_SESSION['CSX'] = $_POST['ind'] % 40;
	$_SESSION['CSY'] = ($_POST['ind']-$_SESSION['CSX']) / 40;
}

if ($_POST['action']=='tomap')
{
	echo 'Переходим на карту мира';
}

if ($_POST['action']=='visit')
{
	$query = 'SELECT point,sector,campp,camps FROM t_main_plinfo WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);	
	$line = mysqli_fetch_row($result);
	//Проверка текущего сектора
	$pointnum = -1;
	if ($line[3]==$_SESSION['sect'])
	{
		$pointnum = $line[2];
	}
	if ($line[1]==$_SESSION['sect'])
	{
		$pointnum = $line[0];
	}
	if ($pointnum==-1)
	{
		echo 'У вас нет города и лагеря в этом секторе';
		exit;
	}
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

if ($_POST['action']=='timertick')
{
	$query = 'UPDATE t_main_plinfo SET movetime = movetime-10 WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	
	$query = 'SELECT movetime FROM t_main_plinfo WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);	
	$line = mysqli_fetch_row($result);
	echo $line[0];	

}

if ($_POST['action']=='sectoraction')
{
	$pnum = $_SESSION['CSY']*40+$_SESSION['CSX'];
	$query = 'UPDATE t_main_plinfo SET movetime = 0, actiontype = 0 WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	//определение есть ли сражение с игроком
	$query = 'SELECT id FROM t_main_plinfo WHERE sector='.$_SESSION['sect'].' AND point='.$pnum;
	$result = mysqli_query($db,$query);
	if ($line = mysqli_fetch_row($result))
	{
		$eplnum = $line[0];//Очистка отчета
		$query = 'DELETE FROM t_report WHERE PLID='.$_SESSION['ID'];
		$result = mysqli_query($db,$query);	
		unset($_SESSION['RepStat']);
		unset($_SESSION['RepFight']);
		$_SESSION['YForce'] = player_force($_SESSION['ID'],1,1);
		$_SESSION['LEForce'] = player_force($eplnum,2,3)+add_town_force($eplnum);//Дополнительная сила города
		
		$gbon100 = 0;
		$query = 'SELECT qbon FROM t_main_plinfo WHERE id='.$_SESSION['ID'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		if (($line[0]>=100)and($line[0]<150))
		{
			$newval = $line[0]-1;
			if ($newval==100) {$newval=0;}
			$query = 'UPDATE t_main_plinfo SET qbon='.$newval.' WHERE id='.$_SESSION['ID'];
			mysqli_query($db,$query);
			$gbon100=1;
		}		
		
		if ($_SESSION['LEForce']<$_SESSION['YForce']) 
		{
			//битва выиграна - уменьшение армии согласно урону
			$dforce = sqrt($_SESSION['YForce']*$_SESSION['YForce']-$_SESSION['LEForce']*$_SESSION['LEForce']);
			if ($gbon100==1) {$dforce=round(($_SESSION['YForce']+$dforce)/2);}
			$_SESSION['NYForce'] = round(($_SESSION['YForce']+$dforce)/2);
			dec_pl_force($_SESSION['ID'],$_SESSION['YForce'],$_SESSION['NYForce'],3);
		
			//Квест на победу определенного количества существ - прогресс
			$query = 'SELECT t2.valt,t1.id,t1.currc,t1.goalc FROM t_active_quest t1,t_info_quest t2 WHERE t1.qid = t2.id AND t2.qtype=1 AND t1.plid='.$_SESSION['ID'];
			$result = mysqli_query($db,$query);
			while ($line = mysqli_fetch_row($result))
			{
				$uid = $line[0];
				$query2 = 'SELECT co FROM t_army WHERE uid='.$uid.' AND plid='.$eplnum;
				$result2 = mysqli_query($db,$query2);
				if ($line2 = mysqli_fetch_row($result2))
				{
					$newcurrc= $line[2]+$line2[0];
					if ($newcurrc>$line[3]) {$newcurrc=$line[3];}
					$query3= 'UPDATE t_active_quest SET currc='.$newcurrc.' WHERE id='.$line[1];
					mysqli_query($db,$query3);
				}
			}
			
			$qbon200 = 0;
			$query = 'SELECT qbon FROM t_main_plinfo WHERE id='.$eplnum;
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			if (($line[0]>=200)and($line[0]<250))
			{
				$newval = $line[0]-1;
				if ($line[0]==200) {$newval=0;}
				$query = 'UPDATE t_main_plinfo SET qbon='.$newval.' WHERE id='.$_SESSION['ID'];
				mysqli_query($db,$query);
				$gbon200=1;
			}
			
			if ($gbon200==0)
			{
				//Получение цифры ключа
				$r1 = rand(1,3);
				$r2 = rand(1,2);
				$cif = -1;
				$query = 'SELECT keyv FROM t_keys WHERE keyt='.$r1.' AND plid='.$eplnum;
				$result = mysqli_query($db,$query);
				if ($line = mysqli_fetch_row($result))
				{
					if ($r2==1) {$cif = floor($line[0]/10);}
					else {$cif = $line[0] % 10;}
					$query2 = 'INSERT INTO t_key_digits (plid,eplid,keynum,dval) VALUES ('.$_SESSION['ID'].','.$eplnum.','.$r1.','.$cif.')';
					mysqli_query($db,$query2);
				}
			}
			else
			{
				echo 'У врага иммунитет на нападения';
			}
			
			
			$_SESSION['RepFight'] = 1;
			$_SESSION['RepStat']='Битва выиграна';
		}
		else
		{
			//уменьшение армии наполовину
			$_SESSION['NYForce'] = round($_SESSION['YForce'] / 2);
			dec_pl_force($_SESSION['ID'],$_SESSION['YForce'],$_SESSION['NYForce'],3);
			$_SESSION['RepFight'] = 0;
			$_SESSION['RepStat']='Битва проиграна';	
		}
		return;//больше в этой ветке ничего не делаем
	}
	
	//определение какой объект мы посещаем
	$query = 'SELECT objid FROM t_sector WHERE sectornum='.$_SESSION['sect'].' AND pointnum='.$pnum;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	
	if (isset($line))
	{
		do_visit_secobj($line[0]);
	}
	
	$query = 'DELETE FROM t_sector WHERE sectornum='.$_SESSION['sect'].' AND pointnum='.$pnum;
	$result = mysqli_query($db,$query);
	
	echo 'Объект посещен. ';
	
	require 'inc_obj_gen.php';
	update_objs();	
}

?>

