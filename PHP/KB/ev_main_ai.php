<?php
//Действия ИИ - использовать лучшего юнита, захватить лучшее здание
session_start();
if (!isset($_SESSION['ID']))
{
	echo "<font color=red><b>Сначала войдите в игру <a href='login.php'>тут</a></b></font>";
	exit();
}
if (!isset($_POST['action'])) $_POST['action']='NONE';
$GLOBALS['cardc'] = 46;

//choose card ai \then\ apply_card_ai
//if ($_POST['action']=='apply_card_ai')
function apply_card_ai()
{
	$db = mysqli_connect("localhost","KBRoot","","kgbnt");
	$query = 'SELECT val FROM t_gm_temp WHERE CODE="PLCO" AND GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);	
	$plco = $line[0];
	$query = 'SELECT val FROM t_gm_temp WHERE CODE="PLNUM" AND GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$aipl = $line[0];
	
	$priocurr = 0;
	$priomax = 0;
	$cardnum = 0;
	$placenum = 0;
	$placepl = 0;
	//priority 1 obel \ 2 buildingused \ 3 unitspecial \ 4 building not uses \5 unit notspecial
	for ($inum=0;$inum<4;$inum++)
	{
		$query = 'SELECT CRDTP_ID FROM t_cardpl WHERE GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$aipl.' AND num='.$inum;
		$result = mysqli_query($db,$query);
		if ($line = mysqli_fetch_row($result))
			$cardtypeid1 = $line[0];
		else $cardtypeid1 = -1;
		
		if (($cardtypeid1>=0)&&($cardtypeid1<=$GLOBALS['cardc']))
		{
			$query = 'SELECT tip,subtip,val FROM t_cardtypes WHERE id='.$cardtypeid1;
			$result = mysqli_query($db,$query);
			$line1 = mysqli_fetch_row($result);	

			//init prio
			if ($line1[0]==3)
				$priocurr = 1;
			if ($line1[0]==2)
			{
				//used or not for building -> prio=4 or prio=2
				$query = 'SELECT count(1) FROM t_cardpl t1,t_cardtypes t2 WHERE t1.CRDTP_ID = t2.id AND  t2.tip=2 AND t1.GM_ID='.$_SESSION['GameId'].' AND t1.PL_ID='.$aipl.' AND t2.subtip='.$line1[1];
				$result = mysqli_query($db,$query);
				$line = mysqli_fetch_row($result);	 
				if ($line[0]==0)
					$priocurr = 4;
				else
					$priocurr = 2;
			}
			if ($line1[0]==1)
			{
				if ($line1[2]>4)
					$priocurr = 3;
				else
					$priocurr = 5;
			}
			
			//Проверки	
			$placenum_tmp = 0;//defaut vars
			$placepl_tmp = $aipl;
			
			if (($line1[0]==2)||($line1[0]==3)) //always good plnum = aipl \ placepl = max(x)
			{
				$query = 'SELECT max(X) FROM t_cardfront WHERE GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$aipl;
				$result = mysqli_query($db,$query);
				$line = mysqli_fetch_row($result);	
				$placenum_tmp = $line[0]+1;
			}
			if ($line1[0]==1)
			{
				//1.has race zd
				$query = 'SELECT count(1) FROM t_cardfront t1,t_cardtypes t2 WHERE t1.CRDTP_ID=t2.ID AND  t1.GM_ID='.$_SESSION['GameId'].' AND t1.PL_ID='.$aipl.' AND t2.tip=2 AND t2.subtip='.$line1[1];
				$result = mysqli_query($db,$query);
				$line = mysqli_fetch_row($result);
				if (($line[0]==0)&&($line1[1]!=0))
					$priocurr =-1;
				
				//2.has purpose force<$line1[1]
				$endw=-1;
				$query = 'SELECT t1.X,t1.PL_ID FROM t_cardfront t1,t_cardtypes t2 WHERE  t1.CRDTP_ID=t2.ID AND  t1.Y=0  AND t1.GM_ID='.$_SESSION['GameId'].' AND t1.PL_ID<>'.$aipl.' AND t2.val<'.$line1[2];
				$result3 = mysqli_query($db,$query);
				while (($line3 = mysqli_fetch_row($result3))&&($endw==-1))
				{
					$query='SELECT count(1) FROM t_cardfront t1,t_cardtypes t2 WHERE t1.CRDTP_ID=t2.ID AND t1.Y=1 AND t1.GM_ID='.$_SESSION['GameId'].' AND t1.X='.$line3[0].' AND t1.PL_ID='.$line3[1].' AND t2.val>='.$line1[2];
					$result = mysqli_query($db,$query);
					$line = mysqli_fetch_row($result);
					if ($line[0]==0) 
					{
						$endw=0;
						$placenum_tmp = $line3[0];
						$placepl_tmp = $line3[1];
					}
				}
				
				if (($endw==-1)&&($line1[2]>=2)&&($line1[2]<=4))
				{
					$query = 'SELECT t1.X FROM t_cardfront t1,t_cardtypes t2 WHERE t1.CRDTP_ID=t2.ID AND  t1.Y=0  AND t1.GM_ID='.$_SESSION['GameId'].' AND t1.PL_ID='.$aipl.' AND t2.val<'.$line1[2];			
					$result3 = mysqli_query($db,$query);
					while (($line3 = mysqli_fetch_row($result3))&&($endw==-1))
					{
						$query='SELECT count(1) FROM t_cardfront t1,t_cardtypes t2 WHERE t1.CRDTP_ID=t2.ID AND t1.Y=1 AND t1.GM_ID='.$_SESSION['GameId'].' AND t1.X='.$line3[0].' AND t1.PL_ID='.$aipl.' AND t2.val>='.$line1[2];
						$result = mysqli_query($db,$query);
						$line = mysqli_fetch_row($result);
						if ($line[0]==0)
						{
							$endw=0;
							$placenum_tmp = $line3[0];
							$placepl_tmp = $aipl;
						}
							
					}
				}
				
				if ($endw==-1)
					$priocurr=-1;
			}
	
		
			if ($priocurr>$priomax)
			{
				$priomax = $priocurr;
				$cardnum = $inum;
				$placenum = $placenum_tmp;//1|0|1|1|   2|1|1|1|
				$placepl = $placepl_tmp; //echo $priocurr.'|'.$inum.'|'.$placenum_tmp.'|'.$placepl_tmp.'|';
			}
		}
	}

	if ($priomax == 0)
	{
		return "RET|Fail";
	}

	//Применение
	$query = 'SELECT CRDTP_ID FROM t_cardpl WHERE GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$aipl.' AND num='.$cardnum;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$cardtypeid1 = $line[0];
		
	if (($priomax==1)||($priomax==2)||($priomax==4))
	{
		$query = 'SELECT max(X) FROM t_cardfront WHERE PL_ID='.$aipl.' AND GM_ID='.$_SESSION['GameId'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$calcx = $line[0]+1;
		
		$query = 'SELECT count(1) FROM t_cardfront WHERE PL_ID='.$aipl.' AND GM_ID='.$_SESSION['GameId'];
		$result = mysqli_query($db,$query);//echo $query;
		$line = mysqli_fetch_row($result);
		if ($line[0]==0)
			$calcx = 1;		
		
		$query = 'INSERT INTO t_cardfront (GM_ID,PL_ID,CRDTP_ID,X,Y) VALUES ('.$_SESSION['GameId'].','.$aipl.','.$cardtypeid1.','.$calcx.',0)';
		mysqli_query($db,$query);
	}
	
	if (($priomax==3)||($priomax==5))
	{	
		if ($line1[2]==5)
		{
			$query = 'UPDATE t_gm_pl SET LASTMFLG="N" WHERE GM_ID='.$_SESSION['GameId'];
			mysqli_query($db,$query);
			$query = 'UPDATE t_gm_pl SET LASTMFLG="Y" WHERE PL_ID='.$aipl.' AND GM_ID='.$_SESSION['GameId'];
			mysqli_query($db,$query);			
		}
		if ($line1[2]==6)
		{
			$query = 'UPDATE t_gm_pl SET LASTHFLG="N" WHERE GM_ID='.$_SESSION['GameId'];
			mysqli_query($db,$query);
			$query = 'UPDATE t_gm_pl SET LASTHFLG="Y" WHERE PL_ID='.$aipl.' AND GM_ID='.$_SESSION['GameId'];
			mysqli_query($db,$query);			
		}		
		
		if ($line1[2]!=5)//not monstr
		{
			$query = 'SELECT max(X) FROM t_cardfront WHERE PL_ID='.$placepl.' AND GM_ID='.$_SESSION['GameId'];
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			$calcx = $line[0]+1;
			
			$query = 'SELECT CRDTP_ID FROM t_cardfront WHERE Y=0 AND GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$placepl.' AND x='.$placenum;
			$result = mysqli_query($db,$query);
			if ($result)
			{
				$line = mysqli_fetch_row($result);
				$cardtypeid2 = $line[0];
			}
			else
				$cardtypeid2 = -1;			
		
			if (($cardtypeid2>=0)&&($placepl!=$aipl))
			{
				$query = 'INSERT INTO t_cardfront (GM_ID,PL_ID,CRDTP_ID,X,Y) VALUES ('.$_SESSION['GameId'].','.$aipl.','.$cardtypeid2.','.$calcx.',0)';
				mysqli_query($db,$query); //echo $query;
			}
			
			if (($line1[2]>=2)&&($line1[2]<=4))
			{
				$query = 'INSERT INTO t_cardfront (GM_ID,PL_ID,CRDTP_ID,X,Y) VALUES ('.$_SESSION['GameId'].','.$aipl.','.$cardtypeid1.','.$calcx.',1)';
				mysqli_query($db,$query); //echo $query;
			}
		}
		
		if ($placepl!=$aipl)
		{
			$query = 'DELETE FROM t_cardfront WHERE GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$placepl.' AND X='.$placenum;
			mysqli_query($db,$query); //echo $query;
		
			$query = 'UPDATE t_cardfront SET x=x-1 WHERE GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$placepl.' AND X>'.$placenum;
			mysqli_query($db,$query);
		}
				
	}
	
	//Замена
	$query = 'DELETE FROM t_cardpl WHERE GM_ID='.$_SESSION['GameId'].' AND PL_ID= '.$aipl.' AND NUM='.$cardnum;
	mysqli_query($db,$query);
		
	$query = 'SELECT val FROM t_gm_temp WHERE code="USEDCARD" AND GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$usedcard = $line[0];		
		
	if ($usedcard<$GLOBALS['cardc'])//add cards
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

		$query = 'INSERT INTO t_cardpl (GM_ID,PL_ID,CRDTP_ID,NUM) VALUES ('.$_SESSION['GameId'].','.$aipl.','.$cardtypeid1.','.$cardnum.')';
		mysqli_query($db,$query);
	}
	
	//change player num
	$query = 'UPDATE t_gm_pl SET skipcard=1,actflg="N" WHERE GM_ID='.$_SESSION['GameId'].' AND plnum='.$aipl;
	mysqli_query($db,$query);	
	$newpl = $aipl+1;
	if ($newpl>$plco)
			$newpl = 1;
	$query = 'UPDATE t_gm_temp SET VAL='.$newpl.' WHERE CODE="PLNUM" AND GM_ID='.$_SESSION['GameId'];
	mysqli_query($db,$query);
	$query = 'UPDATE t_gm_pl SET skipcard=1,actflg="Y" WHERE GM_ID='.$_SESSION['GameId'].' AND plnum='.$newpl;
	mysqli_query($db,$query);		
}

//if ($_POST['action']=='skip_cards_ai')
function skip_cards_ai()
{  
	$db = mysqli_connect("localhost","KBRoot","","kgbnt"); //echo("skip_cards_ai");
	$query = 'SELECT val FROM t_gm_temp WHERE CODE="PLCO" AND GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$plco = $line[0];
	$query = 'SELECT val FROM t_gm_temp WHERE CODE="PLNUM" AND GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$aipl = $line[0];	
	$query = 'SELECT val FROM t_gm_temp WHERE code="USEDCARD" AND GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$usedcard = $line[0];	
	
	$query = 'SELECT count(1) FROM t_cardpl t1,t_cardtypes t2 WHERE t1.CRDTP_ID=t2.id AND t2.tip=1 AND t2.val<=3 AND t1.PL_ID='.$aipl.' AND t1.GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$co1 = $line[0];
	$query = 'SELECT count(1) FROM t_cardpl t1,t_cardtypes t2 WHERE t1.CRDTP_ID=t2.id AND t2.tip=1 AND t1.PL_ID='.$aipl.' AND t1.GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$co2 = $line[0];

	$query = 'SELECT t1.num FROM t_cardpl t1,t_cardtypes t2 WHERE t1.CRDTP_ID=t2.id AND t2.tip=1 AND t2.val<=3 AND t1.PL_ID='.$aipl.' AND t1.GM_ID='.$_SESSION['GameId'];	
	if ($co1==0)
		$query = 'SELECT t1.num FROM t_cardpl t1,t_cardtypes t2 WHERE t1.CRDTP_ID=t2.id AND t2.tip=1 AND t2.subtip<>0 AND t1.PL_ID='.$aipl.' AND t1.GM_ID='.$_SESSION['GameId'];
	if (($co1==0)&&($co2==0))
		$query = 'SELECT num FROM t_cardpl WHERE PL_ID='.$aipl.' AND GM_ID='.$_SESSION['GameId'].' limit 0,1';	
		
	$result1 = mysqli_query($db,$query);
	while ($line1 = mysqli_fetch_row($result1))
	{
		$query = 'DELETE FROM t_cardpl WHERE PL_ID='.$aipl.' AND GM_ID='.$_SESSION['GameId'].' AND num='.$line1[0];
		mysqli_query($db,$query);
	
		if ($usedcard<$GLOBALS['cardc'])//add cards
		{
			$query = 'UPDATE t_cardlist SET used=1 WHERE GM_ID='.$_SESSION['GameId'].' AND num='.$usedcard;
			mysqli_query($db,$query);
		
			$query = 'UPDATE t_gm_temp SET val=val+1 WHERE code="USEDCARD" AND GM_ID='.$_SESSION['GameId'];
			mysqli_query($db,$query);
			$query = 'UPDATE t_gm_temp SET val=val-sign(val) WHERE code="LASTCARD" AND GM_ID='.$_SESSION['GameId'];
			mysqli_query($db,$query);
			
			$query = 'SELECT CRDTP_ID FROM t_cardlist WHERE num='.$usedcard.' AND GM_ID='.$_SESSION['GameId'];
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			$cardtypeid1 = $line[0];		
		
			$query = 'INSERT INTO t_cardpl (GM_ID,PL_ID,CRDTP_ID,NUM) VALUES ('.$_SESSION['GameId'].','.$aipl.','.$cardtypeid1.','.$line1[0].')';
			mysqli_query($db,$query);
			$usedcard++;
		}
	}
	
	//change player num
	$query = 'UPDATE t_gm_pl SET skipcard=1,actflg="N" WHERE GM_ID='.$_SESSION['GameId'].' AND plnum='.$aipl;
	mysqli_query($db,$query);	
	$newpl = $aipl+1;
	if ($newpl>$plco)
			$newpl = 1;
	$query = 'UPDATE t_gm_temp SET VAL='.$newpl.' WHERE CODE="PLNUM" AND GM_ID='.$_SESSION['GameId'];
	mysqli_query($db,$query);
	$query = 'UPDATE t_gm_pl SET skipcard=1,actflg="Y" WHERE GM_ID='.$_SESSION['GameId'].' AND plnum='.$newpl;
	mysqli_query($db,$query);	
}

function checkexitgame()
{	
	$db = mysqli_connect("localhost","KBRoot","","kgbnt");
	$query = 'SELECT count(1) from t_cardpl WHERE GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	
	if ($line[0]==0)
	{
		$query = 'SELECT val FROM t_gm_temp WHERE CODE="PLNUM" AND GM_ID='.$_SESSION['GameId'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$aipl = $line[0];		
		$query = 'SELECT val FROM t_gm_temp WHERE CODE="PLCO" AND GM_ID='.$_SESSION['GameId'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$plco = $line[0];		
		//change player num
		$query = 'UPDATE t_gm_pl SET skipcard=1,actflg="N" WHERE GM_ID='.$_SESSION['GameId'].' AND plnum='.$aipl;
		mysqli_query($db,$query);	
		$newpl = $aipl+1;
		if ($newpl>$plco) $newpl = 1;
		$query = 'UPDATE t_gm_temp SET VAL='.$newpl.' WHERE CODE="PLNUM" AND GM_ID='.$_SESSION['GameId'];
		mysqli_query($db,$query);
		$query = 'UPDATE t_gm_pl SET skipcard=1,actflg="Y" WHERE GM_ID='.$_SESSION['GameId'].' AND plnum='.$newpl;
		mysqli_query($db,$query);		
		
		$query = 'UPDATE t_gm_temp SET VAL=3 WHERE CODE="STEP" AND GM_ID='.$_SESSION['GameId'];
		mysqli_query($db,$query);
		return 1;
	}
	return 0;
}

if ($_POST['action']=='comphod')
{
	if (checkexitgame()==1)
	{
		echo 'Игра завершена';
		exit;
	}
	if (apply_card_ai()=="RET|Fail")
		skip_cards_ai();
	//echo 'RET|Success';
	echo 'Ход сделан';
	
	//$_SESSION['plnum']++;//временно
	if ($_SESSION['plnum']>5) $_SESSION['plnum']=1;
}

?>

