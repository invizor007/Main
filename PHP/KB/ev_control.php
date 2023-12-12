<?php
session_start();
$GLOBALS['cardc'] = 46;
if (!isset($_POST['action'])) $_POST['action']='NONE';
$db = mysqli_connect("localhost","KBRoot","","kgbnt");

if ($_POST['action']=='show_game_info')
{
	$query = 'SELECT plnum,humflg,actflg FROM t_gm_pl WHERE GM_ID='.$_POST['gmnum'];
	$result = mysqli_query($db,$query);
	if ($result)
	{
		while ($line = mysqli_fetch_row($result))
		{
			echo 'Игрок '.$line[0].' humflg='.$line[1].' actflg='.$line[2]."  ";
		}		
	}
	else
	{
		echo 'Информация об игре с таким номером отсутствует';
	}
	//echo "[RET:Success]";
}

if ($_POST['action']=='choose_game')
{
	$cando = 0;
	$query = 'SELECT humflg,actflg,step,plco FROM t_gm_pl WHERE plnum='.$_POST['plnum'].' AND GM_ID='.$_POST['gmnum'];
	$result = mysqli_query($db,$query);
	if ($result)
	{
		$line = mysqli_fetch_row($result);
		if ($line[0]=="N") $cando = 2;
		if ($line[1]=="N") $cando = 2;
	}
		else $cando = 1;
	//-1 - номер не соответствует диапозону, -2 - игра не инициализирована
	$query = 'SELECT count(1) FROM t_gm_pl WHERE GM_ID='.$_POST['gmnum'];
	$result = mysqli_query($db,$query);
	if ($result)
	{
		$line = mysqli_fetch_row($result);
		if ($line[0]==0) $cando = -2;
	}
	else
		$cando = -2;
	
	if ($plnum < 0) $cando = -1;
	if ($plnum > 5) $cando = -1;
	
	if ($cando==1)
	{
		//ok - insert
		$query = 'INSERT INTO t_gm_pl (acc_id,gm_id,plnum,humflg,actflg,skipcard,score,lasthflg,lastmflg) VALUES ('.$_SESSION['ID'].','.$_POST['gmnum'].','.$_POST['plnum'].',"Y","Y",0,0,"N","N")';
		mysqli_query($db,$query);
		$query = 'UPDATE t_accounts SET GM_ID='.$_POST['gmnum'].' WHERE id='.$_SESSION['ID'];
		mysqli_query($db,$query);
		$_SESSION['GameId'] = $_POST['gmnum'];
		echo "Игрок добавлен в игру";
	}
	else if ($cando==2)
	{
		//ok - update
		$query = 'UPDATE t_gm_pl SET humflg=Y,actflg=Y,acc_id='.$_POST['plid'].' WHERE plnum='.$_POST['plnum'].' AND GM_ID='.$_POST['gmnum'];
		mysqli_query($db,$query);
		$query = 'UPDATE t_accounts SET GM_ID='.$_POST['gmnum'].' WHERE id='.$_SESSION['ID'];
		mysqli_query($db,$query);	
		$_SESSION['GameId'] = $_POST['gmnum'];		
		echo "Игрок добавлен в игру";
	}
	else if ($cando == -2)
	{
		echo 'Игра с таким номером не существует';
	}
	else if ($cando == -1)
	{
		echo 'Номер игрока выходит за рамки диапозона';
	}
	else if ($cando == 0)
	{
		echo 'Игрок не может быть добавлен под таким номером';
	}
	//echo "[RET:Success]";
}

if ($_POST['action']=='create_game')
{
	$query = 'SELECT MAX(gm_id) FROM t_gm_pl WHERE 1=1';
	$result = mysqli_query($db,$query);
	if ($result)
	{
		$line = mysqli_fetch_row($result);
		$gmnum = $line[0]+1;
	}
	else
		$gmnum = 1;
	
	mysqli_query($db, 'UPDATE t_accounts SET gm_id='.$gmnum.' WHERE ID='.$_SESSION['ID']);
	
	mysqli_query($db, 'INSERT INTO t_gm_pl (acc_id,gm_id,plnum,humflg,actflg,skipcard,score,lasthflg,lastmflg) VALUES ('.$_POST['plid'].','.$gmnum.',1,"Y","Y",0,0,"N","N")');
	
	$plco = $_POST['plco'];
	if ($plco<2) $plco = 2;
	if ($plco>5) $plco = 5;	
	$ca1 = 46-4*$plco;
	$ca2 = 4*$plco;
	for ($i=2;$i<=$plco;$i++)
		mysqli_query($db, 'INSERT INTO t_gm_pl (acc_id,gm_id,plnum,humflg,actflg,skipcard,score,lasthflg,lastmflg) VALUES ('.$_POST['plid'].','.$gmnum.','.$i.',"N","N",0,0,"N","N")');
	
	mysqli_query($db,'INSERT INTO t_gm_temp (GM_ID,CODE,VAL) VALUES ('.$gmnum.',"PLCO",'.$plco.')');
	mysqli_query($db,'INSERT INTO t_gm_temp (GM_ID,CODE,VAL) VALUES ('.$gmnum.',"STEP",1)');
	mysqli_query($db,'INSERT INTO t_gm_temp (GM_ID,CODE,VAL) VALUES ('.$gmnum.',"PLNUM",1)');
	mysqli_query($db,'INSERT INTO t_gm_temp (GM_ID,CODE,VAL) VALUES ('.$gmnum.',"LASTCARD",'.$ca1.')');
	mysqli_query($db,'INSERT INTO t_gm_temp (GM_ID,CODE,VAL) VALUES ('.$gmnum.',"USEDCARD",'.$ca2.')');
	
	echo "Игра создана";
	//echo "[RET:Success]";
}

if ($_POST['action']=='start_game')
{
	$query = 'UPDATE t_gm_temp SET VAL=2 WHERE CODE="STEP" AND GM_ID='.$_SESSION['SeeGameId'];
	mysqli_query($db,$query);
	
	$query = 'SELECT val FROM t_gm_temp WHERE code="PLCO" AND gm_id='.$_SESSION['SeeGameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);	
	$plco = $line[0];
	
	$usedcard = 0;
	$lastcard = $GLOBALS['cardc'];
	$usedcardarr = array ();
	
	for ($i=0;$i<6;$i++)
	{
		$usedval = array ();
		do 
		{
			$titnum = rand(0,19);
		}
		while (isset($usedval[$titnum]));
		$usedval[$titnum] = $i;
		$query = 'INSERT INTO t_gm_tit (GM_ID,NUM) VALUES ('.$_SESSION['SeeGameId'].','.$titnum.')';
		mysqli_query($db,$query);
	}
	
	for ($i=0;$i<$GLOBALS['cardc'];$i++)
	{
		do	
		$j = rand(0,$lastcard-1);
		while (isset($usedcardarr[$j]));
		$usedcardarr[$j]=1;
	
		$query = 'INSERT INTO t_cardlist (GM_ID,CRDTP_ID,USED,NUM) VALUES ('.$_SESSION['SeeGameId'].','.$i.','.'0'.','.$j.')';
		mysqli_query($db,$query);
	}	
	
	for ($i=0;$i<$plco;$i++) for ($j=0;$j<4;$j++)
	{
		$query = 'SELECT CRDTP_ID FROM t_cardlist WHERE gm_id='.$_SESSION['SeeGameId'].' AND num='.$usedcard;
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$cardtpid = $line[0];
		
		$query = 'INSERT INTO t_card_pl (GM_ID,PL_ID,CRDTP_ID,NUM) VALUES ('.$_SESSION['SeeGameId'].','.$i.','.$cardtpid.','.$j.')';
		mysqli_query($db,$query);
		
		$query = 'UPDATE t_cardlist SET used = 1 WHERE gm_id='.$_SESSION['SeeGameId'].' AND num='.$usedcard;
		mysqli_query($db,$query);

		$usedcard++;
		$lastcard--;
	}
	$query = 'UPDATE t_gm_temp SET val = '.$usedcard.' WHERE CODE="USEDCARD" AND GM_ID='.$_SESSION['SeeGameId'];
	mysqli_query($db,$query);
	$query = 'UPDATE t_gm_temp SET val = '.$lastcard.' WHERE CODE="LASTCARD" AND GM_ID='.$_SESSION['SeeGameId'];
	mysqli_query($db,$query);
	
	echo 'Начинаем игру';
	//echo 'RET|Success';
}

if ($_POST['action']=='see_game')
{
	$_SESSION['SeeGameId'] = $_POST['SeeGameId'];
	//echo 'RET|Success';
}

?>

