<html>
<head>
<title>Средневековое поселение</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/battlestyles.css">
<script>
function AjaxBattleGetXY() {
      $.ajax({
           type: "POST",
           url: 'battlehod.php',
           data:{action:'getxy'},
           success:function(html) {
		     var x=html % 6;
			 var y=(html - x)/6;
             $("#Ramka").css('left',x*80+200+20);
			 $("#Ramka").css('top',y*80+200+20);
           }
      });
 }

function AjaxBattleHod() {
      $.ajax({
           type: "POST",
           url: 'battlehod.php',
           data:{action:'battlehod'},
           success:function(html) {
			 if (html!='') {alert(html);}
			 window.location.reload();
           }
      });
	  
      $.ajax({
           type: "POST",
           url: 'battlehod.php',
           data:{action:'getxy'},
           success:function(html) {
		     var x=html % 6;
			 var y=(html - x)/6;
             $("#Ramka").css('left',x*80+110+20);
			 $("#Ramka").css('top',y*80+10+20);
			 
			 //$("#im14").attr("src","img/map/100.bmp");
			 window.location.reload();
           }
      });
 }
 
 function AjaxArmyClick(ind,v) {
      $.ajax({
           type: "POST",
           url: 'battlehod.php',
           data:{action:'armyclick',id:ind,val:v},
           success:function(data) {
             $("#pinfo").html(data);
			 //alert(data);
			 //window.location.reload();
           }

      });
 }
 
function AjaxBattleInfo() {
      $.ajax({
           type: "POST",
           url: 'battlehod.php',
           data:{action:'battleinfo'},
           success:function(html) {
             
			 alert(html);
			 window.location.reload();
           }

      });
 }
 
function AjaxBattleAttack() {
      $.ajax({
           type: "POST",
           url: 'battlehod.php',
           data:{action:'battleattack'},
           success:function(html) {
             //$("#AAA").val(html);
			 alert(html);
			 window.location.reload();
           }

      });
 }
 
function AjaxBattleEnd() {
      $.ajax({
           type: "POST",
           url: 'battlehod.php',
           data:{action:'battleend'},
           success:function(html) {
             //$("#AAA").val(html);
			 alert(html);
			 //window.location.reload();
			 document.location.href='game.php';
           }

      });
 }
</script>
<body onload="AjaxBattleGetXY()">

<div class="PanelBattleMain">
<?php
session_start();

if (!isset($_SESSION['login']))
{
	echo "<font color='red' size=8><b>Сначала войдите в игру <a href='login.php'>тут</a></b></font>";
	exit();
}

if (!isset($_GET['choice']))
{
	echo 'Некорректная ссылка битвы';
	exit();
}

$neunum = 1;
if ($_GET['choice']==1)
{
	$neunum = $_SESSION['Ne1'];
}
else if ($_GET['choice']==2)
{
	$neunum = $_SESSION['Ne2'];
}
else
{
	echo 'Некорректная ссылка битвы';
	exit();
}



$db = mysqli_connect("localhost","pma","","bg1");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

$query = 'SELECT res_n,res_v from t_neutral where id='.$neunum;
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$_SESSION['res_n'] = $line[0];
$_SESSION['res_v'] = $line[1];

if (!isset($_SESSION['battle_id']))
{
	//Инициализация битвы
	$query = 'SELECT max(battle_id) from t_bat_units';
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$battle_id = $line[0]+1;

	$query = 'INSERT INTO t_bat_units (battle_id,actor_id,m1,m2,m3,a1,a2,a3,c1,c2,t) '.
	'SELECT '.$battle_id.','.'1,m1,m2,m3,a1,a2,a3,c1,c2,t FROM t_account_army where id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	//echo $query;

	$query = 'INSERT INTO t_bat_units (battle_id,actor_id,m1,m2,m3,a1,a2,a3,c1,c2,t) '.
	'SELECT '.$battle_id.','.'2,m1,m2,m3,a1,a2,a3,c1,c2,t FROM t_neutral where id='.$neunum;
	$result = mysqli_query($db,$query);

	$_SESSION['battle_con'] = 0;
	$_SESSION['battle_hod'] = 0;

	//наличие храмов и оружейни а также количество башень
	$query = 'SELECT count(*) from user_zd where zd_id = 10 and account_id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$bonus_d = $line[0];

	$query = 'SELECT count(*) from user_zd where zd_id = 12 and account_id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$bonus_a = $line[0];
	
	$query = 'SELECT count(*) from user_zd where zd_id = 11 and account_id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$ytd = 5 + $line[0]*5;
	$query = 'UPDATE t_account_army set t='.$ytd.' where account_id='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$query = 'UPDATE t_bat_units set t='.$ytd.' where actor_id=1 and battle_id'.$battle_id;
	$result = mysqli_query($db,$query);

	//Занесение информации в таблице характеристик
	for ($i=1;$i<=2;$i++)
	{
		$query = 'SELECT m1,m2,m3,a1,a2,a3,c1,c2,t FROM t_bat_units where battle_id='.$battle_id.' and actor_id='.$i;
		$result = mysqli_query($db,$query);
		$line2 = mysqli_fetch_row($result);
		for ($j=0;$j<=8;$j++)
		{
			$u_tip = $line2[$j];
			if ($j==8) {$u_tip=99;}
			
			if ( ($j>=0)and($j<=2) )
			{
				if ($i==1) {$x=2;} else {$x=3;}
				$y = ($j-0)+1;
			}
			else if ( ($j>=3)and($j<=5) )
			{
				if ($i==1) {$x=1;} else {$x=4;}
				$y = ($j-3)+1;			
			}
			else if ( ($j>=6)and($j<=7) )
			{
				if ($i==1) {$x=2;} else {$x=3;}
				if ($j==6) {$y=0;} else {$y=4;}
			}
			else if ($j==8)
			{
				if ($i==1) {$x=0;} else {$x=5;}
				$y=2;
			}
			
			if ($u_tip !=0)
			{
				if ($j==8)
					{$query = 'SELECT 999,'.$line2[$j].' from uinfo where id=1';}
				else
					{$query = 'SELECT hp,dmg from uinfo where id='.$u_tip;}
				$result = mysqli_query($db,$query);
				$line = mysqli_fetch_row($result);
				$u_hp=$line[0];
			
				$query = 'INSERT INTO t_bat_ustat (BATTLE_ID,ACTOR_ID,U_NUM,HP,CHP,U_TIP,BONUS_A,BONUS_D,DMG,ACTION,X,Y) VALUES ('.$battle_id.
					','.$i.','.$j.','.$u_hp.','.$u_hp.','.$u_tip.','.$bonus_a.','.$bonus_d.','.$line[1].',0,'.$x.','.$y.')';
				$result = mysqli_query($db,$query);
			}
			
			else
			{
				$query = 'INSERT INTO t_bat_freepl (BATTLE_ID,X,Y) VALUES ('.$battle_id.','.$x.','.$y.')';
				$result = mysqli_query($db,$query);
			}
		}
		
		
		
	}

	//определение текущего юнита, который ходит
	do
	{
		$_SESSION['u_yoe'] = rand(1,2);
		$_SESSION['u_num'] = rand(0,8);
		$query = 'SELECT m1,m2,m3,a1,a2,a3,c1,c2,t from t_bat_units where battle_id='.$battle_id.' and actor_id='.$_SESSION['u_yoe'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$u_unit = $line[$_SESSION['u_num']];
	}
	while ($u_unit==0);
	
	$query = 'SELECT x,y,u_tip FROM t_bat_ustat where actor_id='.$_SESSION['u_yoe'].' and u_num='.$_SESSION['u_num'].' and battle_id='.$battle_id;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$_SESSION['cux']=$line[0];
	$_SESSION['cuy']=$line[1];
	$_SESSION['u_tip']=$line[2];
	
	$_SESSION['battleclicktype'] = 'info';
	$_SESSION['battleend']=0;
	$_SESSION['battle_id'] = $battle_id;
}


for ($Y = 0;$Y<5; $Y++)
{
	for ($X = 0;$X<3; $X++)
	{
		$s='img/map/0.bmp'; $v=0; $u=-1;
		if ( ($X==0) and ($Y!=2) ) $s='img/map/100.bmp';
		if ( ($X==1) and (($Y-2)*($Y-2)==4) ) $s='img/map/100.bmp';
		
		if ( ($X==2) and (($Y-2)*($Y-2)<4) ) {$s='img/map/101.bmp';$v=1;$u=$Y-1;}
		if ( ($X==1) and (($Y-2)*($Y-2)<4) ) {$s='img/map/102.bmp';$v=2;$u=$Y-1;}
		if ( ($X==2) and (($Y-2)*($Y-2)==4) ) {$s='img/map/103.bmp';$v=3;$u=$Y/4;}
		if ( ($X==0) and ($Y==2) ) {$s='img/map/104.bmp';$v=4;$u=0;}
		
		if ( ($v>=1)and($v<=3) )
		{
			switch ($v)
			{
				case 1: $query = 'SELECT m1,m2,m3 from t_bat_units where actor_id=1 and battle_id='.$_SESSION['battle_id']; break;//t_account_army
				case 2: $query = 'SELECT a1,a2,a3 from t_bat_units where actor_id=1 and battle_id='.$_SESSION['battle_id']; break;
				case 3: $query = 'SELECT c1,c2,0 from t_bat_units where actor_id=1 and battle_id='.$_SESSION['battle_id']; break;
			}
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			if ($line[$u]!=0)
			{
				$s='img/map/'.(200+$line[$u]).'.bmp';
			}
		}
		
		$ind = $Y*6+$X;
		echo "<img src = ".$s." title=".$ind." id=im".$ind." onClick = 'AjaxArmyClick(".$ind.",".$v.")'></img>";	
	}
	
	for ($X = 3;$X<6; $X++)
	{
		$s='img/map/0.bmp'; $v=0; $u=-1;
		if ( ($X==5) and ($Y!=2) ) $s='img/map/100.bmp';
		if ( ($X==4) and (($Y-2)*($Y-2)==4) ) $s='img/map/100.bmp';
		
		if ( ($X==3) and (($Y-2)*($Y-2)<4) ) {$s='img/map/101.bmp';$v=1;$u=$Y-1;}
		if ( ($X==4) and (($Y-2)*($Y-2)<4) ) {$s='img/map/102.bmp';$v=2;$u=$Y-1;}
		if ( ($X==3) and (($Y-2)*($Y-2)==4) ) {$s='img/map/103.bmp';$v=3;$u=$Y/4;}
		if ( ($X==5) and ($Y==2) ) {$s='img/map/104.bmp';$v=4;$u=0;}
		
		if ( ($v>=1)and($v<=3) )
		{
			switch ($v)
			{
				case 1: $query = 'SELECT m1,m2,m3 from t_bat_units where actor_id=2 and battle_id='.$_SESSION['battle_id']; break;
				case 2: $query = 'SELECT a1,a2,a3 from t_bat_units where actor_id=2 and battle_id='.$_SESSION['battle_id']; break;
				case 3: $query = 'SELECT c1,c2,0 from t_bat_units where actor_id=2 and battle_id='.$_SESSION['battle_id']; break;
			}
			$result = mysqli_query($db,$query);
			if (!$result)
			{
				echo 'Ошибка выполнения запроса в БД';
				exit();
			}
			$line = mysqli_fetch_row($result);
			if ($line[$u]!=0)
			{
				$s='img/map/'.(200+$line[$u]).'.bmp';
			}
		}
		
		$ind = $Y*6+$X;
		echo "<img src = ".$s." title=".$ind." id=im".$ind." onClick = 'AjaxArmyClick(".$ind.",".$v.")'></img>";	
	}	
	echo '<br>';
}

echo '&nbsp;&nbsp;<input type = button class="btn btn-success" value = "Информация" onClick = "AjaxBattleInfo()">';
echo '&nbsp;&nbsp;<input type = button class="btn btn-success" value = "Атаковать" onClick = "AjaxBattleAttack()">';
echo '&nbsp;&nbsp;<input type = button class="btn btn-success" value = "Ход" onClick = "AjaxBattleHod()">';
echo '&nbsp;&nbsp;<input type = button class="btn btn-success" value = "Завершить битву" onClick = "AjaxBattleEnd()"><br>&nbsp;&nbsp;';



//echo $_SESSION['battle_id'].'<br>';
if ($_SESSION['u_yoe']==1)
{
	echo '<font color = "red" size=5><b>'.'Сейчас ходит ваша армия №'.$_SESSION['u_num'].'</b></font>';
}
else
{
	echo '<font color = "red" size=5><b>'.'Сейчас ходит вражеская армия №'.$_SESSION['u_num'].'</b></font>';
}
//echo $_SESSION['u_num'].'<br>'.$_SESSION['u_yoe'].'<br>';
//echo '<input type = button class="btn btn-success" value = "Ход" onClick = "AjaxExtendClick()"><br>';

/*
<font color="red">
Копейшик<br>
Здоровье 34/50<br>
Урон 7+1<br>
Защита 2<br>
Тип пехота<br>
Скорость 1<br>
Атака ближняя<br>
</font>
*/

//<input type = "text" id="AAA" value = "2" /><br>
//<div id="BBB"></div>
?>
</div>

<div class="PanelUnitInfo" id="pinfo">

</div>

<div class = "Ramka" id="Ramka">

</div>

<div class="PanelInfo">

</div>

</body>
</html>