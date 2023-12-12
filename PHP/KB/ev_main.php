<?php
$GLOBALS['cardc'] = 46;
if (!isset($_POST['action'])) $_POST['action']='NONE';

//Функции
function apply_card($plnum,$cardnum,$placepl,$placenum)
{
	$db = mysqli_connect("localhost","KBRoot","","kgbnt");

	$query = 'SELECT CRDTP_ID FROM t_cardpl WHERE GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$plnum.' AND num='.$cardnum;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$cardtypeid1 = $line[0];
	
	$query = 'SELECT CRDTP_ID FROM t_cardfront WHERE Y=0 AND GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$placepl.' AND X='.$placenum;
	$cardtypeid2 = -1;
	$result = mysqli_query($db,$query);
	if ($result)
		if ($line = mysqli_fetch_row($result))
			$cardtypeid2 = $line[0];
		

	//Проверки
	$cardblockstr = array (1=>"Здание и обелиск выкладывается только на себя",2=>"Существо выкладывается на здание или обелиск", 3=>"Сила существа недостаточна");
	$cardblock = 0;
	$cardmove = 0;
	$query = 'SELECT tip,subtip,val FROM t_cardtypes WHERE id='.$cardtypeid1;
	$result = mysqli_query($db,$query);
	$line1 = mysqli_fetch_row($result);
	
	$query = 'SELECT tip,subtip,val FROM t_cardtypes WHERE id='.$cardtypeid2;
	$result = mysqli_query($db,$query);
	$line2 = mysqli_fetch_row($result);
	
	if (($line1[0]==2)||($line1[0]==3))
	{
		if ($placepl!=$plnum) $cardblock = 1;
		if (($placenum==0) && ($placepl==$plnum)) $cardmove = 1;
	}
	if ($line1[0]==1)
	{
		$query = 'SELECT count(1) FROM t_cardfront WHERE Y=0 AND GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$placepl.' AND X='.$placenum;
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);		
		if ($line[0]==0) $cardblock =2;
		if ($line1[2]<=$line2[2]) $cardblock =3;
		if (($placepl!=$plnum)&&($line1[2]>$line2[2])) $cardmove = 2;
	}
	
	if ($cardblock>0)
	{
		echo $cardblockstr[$cardblock];
		return;
	}
	//Применение
	if ($cardmove==1)
	{
		$query = 'SELECT max(X) FROM t_cardfront WHERE PL_ID='.$plnum.' AND GM_ID='.$_SESSION['GameId'];
		$result = mysqli_query($db,$query);//echo $query;
		$line = mysqli_fetch_row($result);
		$calcx = $line[0]+1;
		
		$query = 'SELECT count(1) FROM t_cardfront WHERE PL_ID='.$plnum.' AND GM_ID='.$_SESSION['GameId'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		if ($line[0]==0)
			$calcx = 1;
		
		$query = 'INSERT INTO t_cardfront (GM_ID,PL_ID,CRDTP_ID,X,Y) VALUES ('.$_SESSION['GameId'].','.$plnum.','.$cardtypeid1.','.$calcx.',0)';
		mysqli_query($db,$query);
	}
	
	if ($cardmove==2)
	{	
		if ($line1[2]==5)
		{
			$query = 'UPDATE t_gm_pl SET LASTMFLG="N" WHERE GM_ID='.$_SESSION['GameId'];
			mysqli_query($db,$query); 
			$query = 'UPDATE t_gm_pl SET LASTMFLG="Y" WHERE PL_ID='.$plnum.' AND GM_ID='.$_SESSION['GameId'];
			mysqli_query($db,$query);			
		}
		if ($line1[2]==6)
		{
			$query = 'UPDATE t_gm_pl SET LASTHFLG="N" WHERE GM_ID='.$_SESSION['GameId'];
			mysqli_query($db,$query); 
			$query = 'UPDATE t_gm_pl SET LASTHFLG="Y" WHERE PL_ID='.$plnum.' AND GM_ID='.$_SESSION['GameId'];
			mysqli_query($db,$query);		
		}
		
		if ($line1[2]!=5)//not monstr
		{
			$query = 'SELECT max(X) FROM t_cardfront WHERE PL_ID='.$plnum.' AND GM_ID='.$_SESSION['GameId'];
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			$calcx = $line[0]+1;
		
			if ($cardtypeid2>=0)
			{
				$query = 'INSERT INTO t_cardfront (GM_ID,PL_ID,CRDTP_ID,X,Y) VALUES ('.$_SESSION['GameId'].','.$_SESSION['plnum'].','.$cardtypeid2.','.$calcx.',0)';
				mysqli_query($db,$query);		
			}
			
			
			if (($line1[2]>=2)&&($line1[2]<=4))
			{
				$query = 'INSERT INTO t_cardfront (GM_ID,PL_ID,CRDTP_ID,X,Y) VALUES ('.$_SESSION['GameId'].','.$_SESSION['plnum'].','.$cardtypeid1.','.$calcx.',1)';
				mysqli_query($db,$query);
			}
		}
		
		if ($placepl!=$_SESSION['plnum'])
		{
			$query = 'DELETE FROM t_cardfront WHERE GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$placepl.' AND X='.$placenum;
			mysqli_query($db,$query); //echo $query;
		
			$query = 'UPDATE t_cardfront SET x=x-1 WHERE GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$placepl.' AND X>'.$placenum;
			mysqli_query($db,$query); //echo $query;
		}				
	}
	//Замена
	if ($cardblock==0)
	{
		$query = 'DELETE FROM t_cardpl WHERE PL_ID='.$_SESSION['plnum'].' AND GM_ID='.$_SESSION['GameId'].' AND num='.$cardnum;
		mysqli_query($db,$query);
		
		$query = 'SELECT val FROM t_gm_temp WHERE code="USEDCARD" AND GM_ID='.$_SESSION['GameId'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$usedcard = $line[0];		
		
		$query = 'UPDATE t_gm_pl SET skipcard=3 WHERE GM_ID='.$_SESSION['GameId'].' AND plnum='.$_SESSION['plnum'];
		mysqli_query($db,$query);
		$_SESSION['acttp'] = 3;
		
		if ($usedcard<$GLOBALS['cardc'])
		{
			$query = 'UPDATE t_cardlist SET used=1 WHERE GM_ID='.$_SESSION['GameId'].' AND NUM='.$usedcard;
			mysqli_query($db,$query);
		
			$query = 'UPDATE t_gm_temp SET val=val+1 WHERE code="USEDCARD" AND GM_ID='.$_SESSION['GameId'];
			mysqli_query($db,$query);
			$query = 'UPDATE t_gm_temp SET val=val-sign(val) WHERE code="LASTCARD" AND GM_ID='.$_SESSION['GameId'];
			mysqli_query($db,$query);
			
			$query = 'SELECT CRDTP_ID FROM t_cardlist WHERE num='.$usedcard.' AND GM_ID='.$_SESSION['GameId'];
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			$cardtypeid1 = $line[0];

			$query = 'INSERT INTO t_cardpl (GM_ID,PL_ID,CRDTP_ID,NUM) VALUES ('.$_SESSION['GameId'].','.$plnum.','.$cardtypeid1.','.$cardnum.')';
			mysqli_query($db,$query);
		}
		echo 'Карта применена';
	}	
}

function change_card($lastcardnum,$skipcardnum)//$lastcardnum , $skipcardnum
{
	$db = mysqli_connect("localhost","KBRoot","","kgbnt");
	
	$query = 'SELECT CRDTP_ID FROM t_cardlist WHERE GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$plnum.' AND num='.$lastcardnum;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$cardtypeid1 = $line[0];

	$query = 'UPDATE t_cardlist SET used = 1 WHERE GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$plnum.' AND num='.$lastcardnum;
	mysqli_query($db,$query);

	$query = 'UPDATE t_cardpl SET crdtp_id = '.$cardtypeid1.' WHERE GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$plnum.' AND num='.$skipcardnum;
	mysqli_query($db,$query);
	
	$query = 'UPDATE t_gm_temp SET val=val-sign(val) WHERE CODE="LASTCARD" AND GM_ID='.$_SESSION['GameId'];
	mysqli_query($db,$query);
	
	$query = 'UPDATE t_gm_temp SET VAL=VAL+1 WHERE CODE="USEDCARD" AND GM_ID='.$_SESSION['GameId'];
	mysqli_query($db,$query);	
	
	$query = 'UPDATE t_gm_pl SET skipcard = 0 WHERE GM_ID = '.$_SESSION['GameId'].' AND plnum = '.$plnum;
	mysqli_query($db,$query);
}


function calc_score()
{
	$db = mysqli_connect("localhost","KBRoot","","kgbnt");
	$score = array();
	for ($i=0;$i<5;$i++)
	{
		$query = 'SELECT t2.tip,t2.subtip,t2.val FROM t_cardfront t1, t_cardtypes t2 WHERE t1.crdtp_id = t2.id AND t1.gm_id = '.$_SESSION['GameId'].' AND t1.pl_id='.$i;
		$result = mysqli_query($db,$query);
		$score[$i] = 0;
		while ($line = mysqli_fetch_row($result))
		{
			if ($line[0] == 3) $score[$i]+=2;
			if ($line[0] == 2) $score[$i]+=1;
		}		
	}
	
	//tit
	$titnum = array();
	$query = 'SELECT num FROM t_gm_tit WHERE GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$i=0;
	while ($line = mysqli_fetch_row($result))
	{
		$titnum[$i] = $line[0];
		$i++;
	}
	$titcount = $i;
	
	$titplval = array();
	for ($i=0;$i<5;$i++)
		for ($j=0;$j<$titcount;$j++)
			$titplval[$i][$j]=0;
	
	$query = 'SELECT t1.pl_id,t2.tip,t2.subtip,t2.val FROM t_cardfront t1, t_cardtypes t2 WHERE  t1.crdtp_id = t2.id AND t1.gm_id = '.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	for ($i=0;$i<$titcount;$i++)
	{
		$currtit = $titnum[$i];
		while ($line = mysqli_fetch_row($result))
		{		
			if (($currtit>=0)&&($currtit<=4))
			{
				$temp1 = $currtit+1;
				if (($line[1]==1)&&($line[2]==$temp1)&&($line[3]>=2)&&($line[3]<=4))
					$titplval[$i][$line[0]]++;//tip = 1, subtip f(temp) , val 2-4
			}
			if (($currtit>=5)&&($currtit<=7))
			{
				$temp1 = $currtit-5;
				if (($line[1]==2)&&($line[2]==$temp1)&&($line[3]>=1)&&($line[3]<=3))
					$titplval[$i][$line[0]]++;//tip = 2, subtip f(temp) , val 1-3
			}
			if (($currtit>=8)&&($currtit<=10))
			{
				$temp1 = $currtit-8+2;
				if (($line[1]==2)&&($line[3]==$temp1))
					$titplval[$i][$line[0]]++;//tip = 2, subtip f(temp)
			}
			if (($currtit>=11)&&($currtit<=13))
			{
				$temp1 = $currtit-11;
				if (($line[1]==2)&&($line[3]==$temp1))
					$titplval[$i][$line[0]]++;//tip = 2, val f(temp)
			}
			if ($currtit==14)
			{
				if ($line[1]==2)
					$titplval[$i][$line[0]]++;
			}
			if ($currtit==15)
			{
				if ($line[1]==1)
					$titplval[$i][$line[0]]++;
			}
			if ($currtit==16)
			{
				$temparr = array();
				if ($line[1]==2)
				{
					if (isset($temparr[$line[2]]))
						$titplval[$i][$line[0]]++;
					else
						$temparr[$line[2]] = 1;
				}
			}
			if ($currtit==17)
			{
				if ($line[1]==3)
					$titplval[$i][$line[0]]++;
			}				
		}
	}
	
	for ($j=0;$j<$titcount;$j++)
	{
		$maxval = -1;
		for ($i=0;$i<5;$i++)
		{
			if (($titnum[$i]>=0)&&($titnum[$i]<=17))
				if ($titplval[$i][$j]>$maxval)
					$maxval = $titplval[$i];
		}
		
		for ($i=0;$i<5;$i++)
		{
			if ($titplval[$i][$j]==$maxval)
			{
				$score[$i]+=5;
			}
		}
	}
	
	//tit minus
	for ($i=0;$i<$titcount;$i++)
	{
		if ($titnum[$i]==18)
		{
			$query = "SELECT plnum FROM t_gm_pl WHERE gm_id=".$_SESSION['GameId']." AND lastmflg='Y'";
			$result = mysqli_query($db,$query);
			if ($result)
			{
				$line = mysqli_fetch_row($result);
				$score[$line[0]]-=3;
			}			
		}
		if ($titnum[$i]==19)
		{
			$query = "SELECT plnum FROM t_gm_pl WHERE gm_id=".$_SESSION['GameId']." AND lasthflg='Y'";
			$result = mysqli_query($db,$query);
			if ($result)
			{
				$line = mysqli_fetch_row($result);
				$score[$line[0]]-=3;
			}			
		}		
	}

	for ($i=0;$i<5;$i++)
	{
		$query = "UPDATE t_gm_pl SET score=".$score[$i]." WHERE gm_id=".$_SESSION['GameId']." AND plnum=".$i;
		mysqli_query($db,$query);
	}
}

function checkexitgame()
{	
	$db = mysqli_connect("localhost","KBRoot","","kgbnt");
	$query = 'SELECT count(1) FROM t_cardpl WHERE GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	
	if ($line[0]==0)
	{
		calc_score();
		$query = 'UPDATE t_gm_temp SET VAL=3 WHERE CODE="STEP" AND GM_ID='.$_SESSION['GameId'];
		mysqli_query($db,$query);
		echo 'Игра завершена';
		return 1;
	}
	return 0;
}


///////Основное

session_start();
if (!isset($_SESSION['ID']))
{
	echo "<font color=red><b>Сначала войдите в игру <a href='login.php'>тут</a></b></font>";
	exit();
}
$db = mysqli_connect("localhost","KBRoot","","kgbnt");		
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}
if (!isset($_SESSION['acttp']))
	$_SESSION['acttp'] = 0;


if ($_POST['action']=='choose_card')
{
	if ($_SESSION['acttp']==3)
	{
		echo 'Ход уже сделан. Нажмите переход хода';
		exit;
	}
	if ($_SESSION['acttp']==1)
	{
		$query = 'SELECT crdtp_id FROM t_cardpl WHERE num='.$_POST['cardnum'].' AND PL_ID='.$_SESSION['plnum'].' AND GM_ID='.$_SESSION['GameId'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$cardtypeid1 = $line[0];
		$query = 'SELECT tip,subtip FROM t_cardtypes WHERE id='.$cardtypeid1;
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		if (($line[0]==1)&&($line[1]!=0))			
		{
			$query = 'SELECT count(1) FROM t_cardfront t1, t_cardtypes t2 WHERE t1.crdtp_id = t2.id AND t1.Y=0 AND t2.tip=2 AND t1.gm_id = '.$_SESSION['GameId'].' AND t1.pl_id='.$_SESSION['plnum'].' AND t2.subtip='.$line[1];
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			if ($line[0]==0)
			{
				echo 'Нет возможности применить юнита. Нужно здание соответствующей фракции';
				exit;
			}
		}
		
		$_SESSION['choosecardnum'] = $_POST['cardnum'];
	}	
	if ($_SESSION['acttp']==2)
	{
		$query = 'SELECT count(1) FROM t_gm_temp WHERE CODE="SKIP" AND GM_ID='.$_SESSION['GameId'].' AND val='.$_POST['cardnum'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$co = $line[0];
		
		if ($co==0)
		{
			$query = 'INSERT INTO t_gm_temp (GM_ID,CODE,VAL) VALUES ('.$_SESSION['GameId'].',"SKIP",'.$_POST['cardnum'].')';
			mysqli_query($db,$query);
		}
		else
		{
			$query = 'DELETE FROM t_gm_temp WHERE CODE="SKIP" AND GM_ID='.$_SESSION['GameId'].' AND val='.$_POST['cardnum'];
			mysqli_query($db,$query);
		}		
	}
	echo "Карта выбрана";	
	//echo "[RET:Success]";
}

if ($_POST['action']=='choose_place')
{
	if ($_SESSION['acttp']==3)
	{
		echo 'Ход уже сделан. Нажмите переход хода';
		exit;
	}	
	if ($_SESSION['acttp']==2)
	{
		echo 'Сейчас вы выделяете ненужные карты чтобы сбросить';
		exit;
	}		
	$_SESSION['chooseplacepl'] = $_POST['placepl'];
	$_SESSION['chooseplacenum'] = $_POST['placenum'];
	if (isset($_SESSION['choosecardnum']))
		if ($_SESSION['choosecardnum']>=0)
		{
			echo '[RET:ApplyCard('.$_SESSION['plnum'].','.$_SESSION['choosecardnum'].','.$_SESSION['chooseplacepl'].','.$_SESSION['chooseplacenum'].')]';
			apply_card($_SESSION['plnum'],$_SESSION['choosecardnum'],$_SESSION['chooseplacepl'],$_SESSION['chooseplacenum']);
		}
}

/*if ($_POST['action']=='apply_card')
{
	$plnum = $_SESSION['plnum'];
	$cardnum = $_SESSION['choosecardnum'];
	$placepl = $_SESSION['chooseplacepl'];
	$placenum = $_SESSION['chooseplacenum'];
	apply_card($plnum,$cardnum,$placepl,$placenum);
}*/

if ($_POST['action']=='exit_game')
{
	calc_score();
	$query = 'UPDATE t_gm_temp SET VAL=3 WHERE CODE="STEP" AND GM_ID='.$_SESSION['GameId'];
	mysqli_query($db,$query);
	echo 'Игра завершена';
}


if ($_POST['action']=='see_player')
{
	$_SESSION['SeeID']=$_POST['SeeID'];
	//echo 'RET|Success';
}

if ($_POST['action']=='change_acttp')
{
	if ($_SESSION['acttp']==3)
	{
		echo 'Ход уже сделан. Нажмите переход хода';
		exit;
	}
	
	if ($_POST['acttp']==1)
	{
		$query = 'DELETE FROM t_gm_temp WHERE CODE="SKIP" AND GM_ID='.$_SESSION['GameId'];
		mysqli_query($db,$query);		
	}
	
	$_SESSION['acttp']=$_POST['acttp'];
	$skipcard = $_SESSION['acttp'] - 1;
	$query = 'UPDATE t_gm_pl SET skipcard='.$skipcard.' WHERE GM_ID='.$_SESSION['GameId'].' AND plnum='.$_SESSION['plnum'];
	mysqli_query($db,$query);
	
	if ($_SESSION['acttp']==1)
		echo 'Выберите карту, которой походить';
	if ($_SESSION['acttp']==2)
		echo 'Выберите карты, которые нужно заменить';	
	//echo 'RET|Success';
}

if ($_POST['action']=='change_plnum')
{	
	if (checkexitgame()==1)
	{
		echo 'Игра завершена';
		exit;
	}
	if ($_SESSION['acttp']!=3)
	{
		echo 'Ваш ход еще не завершен';
		exit;
	}	

	$query = 'SELECT val FROM t_gm_temp WHERE CODE="PLNUM" AND GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$plnum = $line[0];
	
	$query = 'UPDATE t_gm_pl SET skipcard=1,actflg="N" WHERE GM_ID='.$_SESSION['GameId'].' AND plnum='.$_SESSION['plnum'];
	mysqli_query($db,$query);
	$_SESSION['acttp'] = 1;	
	
	//change player num
	$newpl = $plnum+1;
	$query = 'SELECT val FROM t_gm_temp WHERE CODE="PLCO" AND GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$plco = $line[0];	
	if ($newpl>=$plco)
			$newpl = 0;
	$query = 'UPDATE t_gm_temp SET VAL='.$newpl.' WHERE CODE="PLNUM" AND GM_ID='.$_SESSION['GameId'];
	mysqli_query($db,$query);
	$query = 'UPDATE t_gm_pl SET skipcard=1,actflg="Y" WHERE GM_ID='.$_SESSION['GameId'].' AND plnum='.$newpl;
	mysqli_query($db,$query);	
	echo 'Ход передан следующему игроку';	
}

if ($_POST['action']=='skip_cards')
{
	if ($_SESSION['acttp']==3)
	{
		echo 'Ход уже сделан. Нажмите переход хода';
		exit;
	}
	
	$query = 'SELECT VAL FROM t_gm_temp WHERE CODE="SKIP" AND GM_ID='.$_SESSION['GameId'];
	$result1 = mysqli_query($db,$query);
	while ($line1 = mysqli_fetch_row($result1))
	{
		$cardnum = $line1[0];
		$query = 'SELECT CRDTP_ID FROM t_cardpl WHERE PL_ID='.$_SESSION['plnum'].' AND GM_ID='.$_SESSION['GameId'].' AND NUM='.$cardnum;
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$cardtypeid1 = $line[0];
		
		$query = 'DELETE FROM t_cardpl WHERE PL_ID='.$_SESSION['plnum'].' AND GM_ID='.$_SESSION['GameId'].' AND CRDTP_ID='.$cardtypeid1;
		mysqli_query($db,$query);
	
		$query = 'SELECT val FROM t_gm_temp WHERE code="USEDCARD" AND GM_ID='.$_SESSION['GameId'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$usedcard = $line[0];
		
		if ($usedcard<$GLOBALS['cardc'])
		{
			$query = 'UPDATE t_cardlist SET used=1 WHERE GM_ID='.$_SESSION['GameId'].' AND NUM='.$usedcard;
			mysqli_query($db,$query);
		
			$query = 'UPDATE t_gm_temp SET val=val+1 WHERE code="USEDCARD" AND GM_ID='.$_SESSION['GameId'];
			mysqli_query($db,$query);
			$query = 'UPDATE t_gm_temp SET val=val-sign(val) WHERE code="LASTCARD" AND GM_ID='.$_SESSION['GameId'];
			mysqli_query($db,$query);
			
			$query = 'SELECT CRDTP_ID FROM t_cardlist WHERE num='.$usedcard.' AND GM_ID='.$_SESSION['GameId'];
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			$cardtypeid1 = $line[0];
			
			$query = 'SELECT val FROM t_gm_temp WHERE CODE="PLNUM" AND GM_ID='.$_SESSION['GameId'];
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			$plnum = $line[0];

			$query = 'INSERT INTO t_cardpl (GM_ID,PL_ID,CRDTP_ID,NUM) VALUES ('.$_SESSION['GameId'].','.$plnum.','.$cardtypeid1.','.$cardnum.')';
			mysqli_query($db,$query);			
		}		
	}
	
	$query = 'DELETE FROM t_gm_temp WHERE CODE="SKIP" AND GM_ID='.$_SESSION['GameId'];
	mysqli_query($db,$query);

	
	$query = 'UPDATE t_gm_pl SET skipcard=3 WHERE GM_ID='.$_SESSION['GameId'].' AND plnum='.$_SESSION['plnum'];	
	mysqli_query($db,$query);
	$_SESSION['acttp'] = 3;
	//echo 'RET|Success';
}

?>

