<?php
include 'ev_battle.php';

session_start(); //unset($_SESSION['arenaid']);
if (!isset($_SESSION['ID']))
{
	echo "Сначала войдите в игру <a href='login.php'>тут</a>";
	exit();
}
$db = mysqli_connect("localhost","bg2user","","bg2");		
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

if ($_POST['action']=='create')
{
	$query = 'INSERT INTO t_arena (PL1,PL2,STAT) VALUES ('.$_SESSION['ID'].',0,1)';
	$result = mysqli_query($db,$query);
	
	$query = 'SELECT id from t_arena where pl1='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$_SESSION['arenaid'] = $line[0];
}

if ($_POST['action']=='delete')
{
	$query = 'DELETE FROM t_arena WHERE pl1 = '.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	
	$query = 'UPDATE t_arena SET pl2 = null WHERE pl2 = '.$_SESSION['ID'];
	$result = mysqli_query($db,$query);	
	unset($_SESSION['arenaid']);
}

if ($_POST['action']=='join')
{
	$query = 'UPDATE t_arena SET pl2 = '.$_SESSION['ID'].' WHERE id='.$_POST['id'];
	$result = mysqli_query($db,$query);
	$_SESSION['arenaid'] = $_POST['id'];
}

if ($_POST['action']=='hunt')
{  dblog('11',11);
	if (isset($_SESSION['arenaid']))
	{
		echo 'Находясь в заявке на бой нельзя охотиться';
		exit();
	} //exit();
	dblog('9',9);
	//Подготовка к битве
	$query = 'SELECT max(battle_id) from t_bat_stat';
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$new_battle_id = $line[0]+1;dblog('8',8);

	//кверим pl1
	$query = 'SELECT s_all,a_all,i_all from t_account_stat where id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);dblog('7',7);
	$hp = 100+5*$line[0];
	$dmg = 10+2*$line[1];
	$mana = $line[2];
	$_SESSION['youhp'] = $hp;
	$_SESSION['youchp'] = $hp;
	$_SESSION['youmana'] = $mana;
	$_SESSION['youmnm'] = $mana;	

	$query = 'INSERT INTO t_bat_stat (BATTLE_ID,ACTOR,CHP,HPM,DMG,MANA,MNM,MONSTR) VALUES ('.
		$new_battle_id.',1,'.$hp.','.$hp.','.$dmg.','.$mana.','.$mana.',0)';
	$result = mysqli_query($db,$query);
	//кверим pl2
	$mon_tip = $_POST['id1']; echo '$mon_tip='.$mon_tip;dblog('0',0);
	$mon_lev = $_POST['id2']; echo '$mon_lev='.$mon_lev;
	$query = 'SELECT hpb,dmg from t_monstrs where id = '.$mon_tip;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$hp = $line[0]+5*$mon_lev;
	$dmg = $line[1]+2*$mon_lev;
	$_SESSION['enehp'] = $hp;
	$_SESSION['enechp'] = $hp;
	$_SESSION['enemana'] = 0;dblog('1',1);
	$_SESSION['enemnm'] = 0;	

	$query = 'INSERT INTO t_bat_stat (BATTLE_ID,ACTOR,CHP,HPM,DMG,MANA,MNM,MONSTR) VALUES ('.
		$new_battle_id.',2,'.$hp.','.$hp.','.$dmg.',0,0,'.$mon_tip.')';
	$result = mysqli_query($db,$query);
	$_SESSION['battle_id']=$new_battle_id;
	$_SESSION['battle_a'] = 1;dblog('2',2);
	$used_cards = array();
		
	for ($j=1;$j<=1;$j++) 
	{
		for ($i=0;$i<=2;$i++)
		{
			//Мы добавляем случайные карты игроку
			do
			{
				$r = rand(1,10);
			}		
			while (in_array($r, $used_cards));
			$used_cards[$i] = $r;
			
			$query = 'INSERT INTO t_bat_cards (BATTLE_ID,ACTOR,NUM,PLACE) VALUES ('.$_SESSION['battle_id'].','.$j.','.$r.','.$i.')';
			//echo $query;
			$result = mysqli_query($db,$query);
		}
	}
	
	for ($j=1;$j<=2;$j++) 
	{
		$query = 'INSERT INTO t_bat_choice (BATTLE_ID,ACTOR,T_ATT,T_DEF,SPELL1,SPELL2,SPELL3) VALUES ('.
			$_SESSION['battle_id'].','.$j.',-1,-1,-1,-1,-1)';
		$result = mysqli_query($db,$query);
	}
	
	$query = 'UPDATE t_accounts SET bata = 1, bat='.$new_battle_id.' WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);	
}


if ($_POST['action']=='batstart')
{
	if (! isset($_SESSION['arenaid']))
	{ dblog('100',100);
		echo 'У вас нет активной заявки на бой';
		exit();
	} //exit();
	
	$query = 'SELECT pl1 FROM t_arena WHERE pl1='.$_SESSION['arenaid'];
	$result = mysqli_query($db,$query);
	
	dblog('0',0);
	//Подготовка к битве
	$query = 'SELECT max(battle_id) from t_bat_stat';
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$new_battle_id = $line[0]+1;
dblog('1',1);
	//кверим pl1
	$query = 'SELECT s_all,a_all,i_all from t_account_stat where id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$hp = 100+5*$line[0];
	$dmg = 10+2*$line[1];
	$mana = 1*$line[2];dblog('2',2);
		
	$_SESSION['youhp'] = $hp;
	$_SESSION['youchp'] = $hp;
	$_SESSION['youmana'] = $mana;
	$_SESSION['youmnm'] = $mana;
		
	$query = 'INSERT INTO t_bat_stat (BATTLE_ID,ACTOR,CHP,HPM,DMG,MANA,MNM,MONSTR) VALUES ('.
		$new_battle_id.',1,'.$hp.','.$hp.','.$dmg.','.$mana.','.$mana.',0)';
	$result = mysqli_query($db,$query);
	//кверим pl2
	//ищем противника
	$query = 'SELECT pl2 FROM t_arena WHERE slat=1 and pl1 = '.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);	dblog('3',3);
	
	$query = 'SELECT s_all,a_all,i_all from t_account_stat where id='.$line[0];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$hp = 100+5*$line[0];
	$dmg = 10+2*$line[1];
	$mana = 1*$line[2];dblog('4',4);
	
	$_SESSION['enehp'] = $hp;
	$_SESSION['enechp'] = $hp;
	$_SESSION['enemana'] = $mana;
	$_SESSION['enemnm'] = $mana;	
	
	$query = 'INSERT INTO t_bat_stat (BATTLE_ID,ACTOR,CHP,HPM,DMG,MANA,MNM,MONSTR) VALUES ('.
		$new_battle_id.',2,'.$hp.','.$hp.','.$dmg.','.$mana.','.$mana.',0)'; $_SESSION['zapros'] = $query;
	$result = mysqli_query($db,$query);dblog('5',5);
	
	$_SESSION['battle_id']=$new_battle_id;
	$_SESSION['battle_a'] = 1;
	$used_cards = array();dblog('6',6);
	
	for ($j=1;$j<=2;$j++) 
	{
		for ($i=0;$i<=2;$i++)
		{
			//Мы добавляем случайные карты обоим игрокам
			do
			{
				$r = rand(1,10);
			}
			while (in_array($r, $used_cards));
			$used_cards[$i] = $r;
			
			$query = 'INSERT INTO t_bat_cards (BATTLE_ID,ACTOR,NUM,PLACE) VALUES ('.$_SESSION['battle_id'].','.$j.','.$r.','.$i.')';
			//echo $query;
			$result = mysqli_query($db,$query);
		}
	}dblog('7',7);
	
	for ($j=1;$j<=2;$j++) 
	{
		$query = 'INSERT INTO t_bat_choice (BATTLE_ID,ACTOR,T_ATT,T_DEF,SPELL1,SPELL2,SPELL3) VALUES ('.
			$_SESSION['battle_id'].','.$j.',-1,-1,-1,-1,-1)';
		$result = mysqli_query($db,$query);
	}
	
	$query = 'UPDATE t_accounts SET bata = 1, bat='.$new_battle_id.' WHERE id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);	
	
	$query = 'UPDATE t_arena SET battle_id='.$new_battle_id.' WHERE id='.$_SESSION['arenaid'];
	$result = mysqli_query($db,$query);	

}

?>

