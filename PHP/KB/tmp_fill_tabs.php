<?php
session_start();$_SESSION['ID']=1;

function fill_names()
{
	$db = mysqli_connect("localhost","KBRoot","","kgbnt");		
	$arrfname = array("Люди","Эльфы","Гномы","Орки","Нежить");
	$arrbname = array(array("Таверна здоровый дух","Замок Телион","Замок Далоэр"),
		array("Колесная мастерская","Фабрика","Замок Монтор"),
		array("Палатка утряски","Таверна сытый орк","Замок Хезерхем"),
		array("Храм костей","Замок Олум","Замок Некроком"));
	$arruname = array(array("Лучник","Мечник","Архимаг","Красный дракон","Томас Торкве"),
		array("Эльф","Оборотень","Друид","Древний Энт","Дриада Бюлла"),
		array("Дройд механик","Гном","Алхимик","Гигант","Безумный рудокоп"),
		array("Гоблин","Орк","Шаман","Огр","Багуд"),
		array("Скелет лучник","Зомби","Некромант","Костяной Дракон","Фон Краков"));

	//1. Names
	$query = 'DELETE FROM t_info_fname WHERE 1=1'; mysqli_query($db,$query);
	$query = 'DELETE FROM t_info_bname WHERE 1=1'; mysqli_query($db,$query);
	$query = 'DELETE FROM t_info_uname WHERE 1=1'; mysqli_query($db,$query);

	for ($i=0;$i<=4;$i++)
	{
		$query = 'INSERT INTO t_info_fname(ID,NAME) VALUES ('.$i.',"'.$arrfname[$i].'")'; 
		mysqli_query($db,$query);
	}

	for ($i=1;$i<=4;$i++) for ($j=1;$j<=3;$j++)
	{
		$query = 'INSERT INTO t_info_bname(FID,FVAL,NAME) VALUES ('.$i.",".$j.',"'.$arrbname[$i-1][$j-1].'")'; 
		mysqli_query($db,$query);
	}

	for ($i=0;$i<=4;$i++) for ($j=2;$j<=6;$j++)
	{
		$query = 'INSERT INTO t_info_uname(FID,FVAL,NAME) VALUES ('.$i.",".$j.',"'.$arruname[$i][$j-2].'")'; 
		mysqli_query($db,$query);
	}
}

//2.
function fill_cardtype()
{
	$db = mysqli_connect("localhost","KBRoot","","kgbnt");			
	$query = 'DELETE FROM t_cardtypes WHERE 1=1';
	mysqli_query($db,$query);
	for ($i=0;$i<=4;$i++) for ($j=2;$j<=6;$j++)//5*5=25
	{
		$query = 'INSERT INTO t_cardtypes (TIP,SUBTIP,VAL) VALUES (1,'.$i.','.$j.')';
		mysqli_query($db,$query);
	}
	for ($i=1;$i<=4;$i++) for ($j=1;$j<=3;$j++)//4*3=12
	{
		$query = 'INSERT INTO t_cardtypes (TIP,SUBTIP,VAL) VALUES (2,'.$i.','.$j.')';
		mysqli_query($db,$query);
	}
	for ($i=0;$i<=2;$i++) for ($j=1;$j<=3;$j++)//3*3=9
	{
		$query = 'INSERT INTO t_cardtypes (TIP,SUBTIP,VAL) VALUES (3,'.$i.','.$j.')';
		mysqli_query($db,$query);
	}	
}

//3.
function fill_cardlist($gameid)
{
	$db = mysqli_connect("localhost","KBRoot","","kgbnt");		
	$query = 'SELECT count(1) FROM t_cardtypes WHERE 1=1';
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$cardco = $line[0];
	$usedcardarr = array ();
	for ($i=0;$i<$cardco;$i++)
	{
		do	
		$j = rand(0,$cardco-1);
		while (isset($usedcardarr[$j]));
		$usedcardarr[$j]=1;
	
		$query = 'INSERT INTO t_cardlist (GM_ID,CRDTP_ID,USED,NUM) VALUES ('.$gameid.','.$i.','.'0'.','.$j.')';
		mysqli_query($db,$query);
	}
}

function init_gamepl($gameid)
{
	$db = mysqli_connect("localhost","KBRoot","","kgbnt");		
	$plco = 5;	
	for ($i=1;$i<=$plco;$i++)
	{
		$query = 'SELECT count(1) FROM t_gm_pl WHERE gm_id='.$gameid.' AND plnum='.$i;
		$result = mysqli_query($db,$query); 
		$line = mysqli_fetch_row($result);
		$co = $line[0];
		if ($co == 0)
		{
			$query = 'INSERT INTO t_gm_pl (acc_id,gm_id,plnum,humflg,actflg,skipcard,score,lasthflg,lastmflg) VALUES ('.$_SESSION['ID'].','.$gameid.','.$i.',"N","N",0,0,"N","N")';
			mysqli_query($db,$query);
		}
	}	
}

function init_playercard($gameid)
{
	$db = mysqli_connect("localhost","KBRoot","","kgbnt");		
	$plco = 5;	
	$tmpnum = 1;
	for ($i=1;$i<=$plco;$i++)//player
	{
		for ($j=0;$j<4;$j++)//num
		{
			$query = 'SELECT CRDTP_ID FROM t_cardlist WHERE GM_ID='.$gameid.' AND num='.$tmpnum;
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			$cardtypeid1 = $line[0];
			
			$query = 'UPDATE t_cardtypes SET used = 1 WHERE GM_ID='.$gameid.' AND num='.$tmpnum;
			mysqli_query($db,$query);
			
			$query = 'INSERT INTO t_cardpl (GM_ID,PL_ID,CRDTP_ID,NUM) VALUES ('.$gameid.','.$i.','.$cardtypeid1.','.$j.')';
			mysqli_query($db,$query);
			$tmpnum++;
		}
	}
}

function init_gametit($gameid)
{
	$db = mysqli_connect("localhost","KBRoot","","kgbnt");
	for ($i=0;$i<6;$i++)
	{
		$usedval = array ();
		do 
		{
			$titnum = rand(0,19);
		}
		while (isset($usedval[$titnum]));
		$usedval[$titnum] = $i;
		$query = 'INSERT INTO t_gm_tit (GM_ID,NUM) VALUES ('.$gameid.','.$titnum.')';
		mysqli_query($db,$query);
	}
}

function clear_gamecard($gameid)
{
	$db = mysqli_connect("localhost","KBRoot","","kgbnt");
	mysqli_query($db,'delete FROM t_cardpl WHERE GM_ID='.$gameid);
	mysqli_query($db,'delete FROM t_cardfront WHERE GM_ID='.$gameid);
	mysqli_query($db,'UPDATE t_cardlist SET used=0 WHERE GM_ID='.$gameid);
	mysqli_query($db,'UPDATE t_gm_temp SET VAL=26 WHERE CODE="LASTCARD" AND GM_ID='.$gameid);
	mysqli_query($db,'UPDATE t_gm_temp SET VAL=20 WHERE CODE="USEDCARD" AND GM_ID='.$gameid);
	mysqli_query($db,'UPDATE t_gm_temp SET VAL=1 WHERE CODE="PLNUM" AND GM_ID='.$gameid);
	$_SESSION['plnum']=1;
}

clear_gamecard(1);
init_playercard(1);
echo 'Выполнено';
//fill_names();

?>
