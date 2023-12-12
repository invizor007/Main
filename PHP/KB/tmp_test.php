<?php
//include 'tmp_fill_tabs.php';
$db = mysqli_connect("localhost","KBRoot","","kgbnt");		
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

session_start();
$_SESSION['ID']=1;
$GLOBALS['cardc']=46;

function fill_cardpl()
{
	$query = 'SELECT val FROM t_gm_temp WHERE code="PLNUM" AND GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$aipl = $line[0];
	$query = 'SELECT val FROM t_gm_temp WHERE code="USEDCARD" AND GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$usedcard = $line[0];	
	
	for ($i=0;$i<3;$i++)
	{
		$query = 'SELECT count(1) FROM t_cardpl WHERE GM_ID='.$_SESSION['GameId'].' AND PL_ID='.$aipl.'  AND NUM='.$i;
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$co = $line[0];
			
		if (($co==0)&&($usedcard<$GLOBALS['cardc']))//add cards
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

			$query = 'INSERT INTO t_cardpl (GM_ID,PL_ID,CRDTP_ID,NUM) VALUES ('.$_SESSION['GameId'].','.$aipl.','.$cardtypeid1.','.$i.')';
			mysqli_query($db,$query);
		}		
	}
}

//init_playercard(1);
//init_gametit(1);

//mysqli_query($db,'UPDATE t_gm_pl SET humflg="Y",actflg="N" WHERE GM_ID=1');
//mysqli_query($db,'UPDATE t_gm_pl SET humflg="Y",actflg="Y" WHERE GM_ID=1 AND PLNUM=2');
//unset($_SESSION['acttp']);

$_SESSION['acttp']=1;
$_SESSION['plnum']=1;

echo 'Выполнено';
?>
