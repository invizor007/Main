<html>
<head>
<title>Магическая арена</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/battlestyles.css">
<link rel="stylesheet" href="battlestylesadd.css.php" type="text/css">

<?php
clearstatcache();
session_start();
//временно
//$_SESSION['login']='Player1';
//$_SESSION['ID']=1;
/*
$enehp_pos = round(350*$_SESSION['enechp']/$_SESSION['enehp']);
$youhp_pos = round(350*$_SESSION['youchp']/$_SESSION['youhp']);
echo $enehp_pos.' '.$youhp_pos.'<br>';
echo $_SESSION['enechp'].' '.$_SESSION['enehp'].'<br>';
echo $_SESSION['youchp'].' '.$_SESSION['youhp'].'<br>';

$enemana_pos = round(350*$_SESSION['enemana']/($_SESSION['enemnm']+0.01));
$youmana_pos = round(350*$_SESSION['youmana']/($_SESSION['youmnm']+0.01));
echo $enemana_pos.' '.$youmana_pos.'<br>';
echo $_SESSION['enemana'].' '.$_SESSION['enemnm'].'<br>';
echo $_SESSION['youmana'].' '.$_SESSION['youmnm'].'<br>';
*/

if (!isset($_SESSION['login']))
{
	echo "Сначала войдите в игру <a href='login.php'>тут</a>";
	exit();
}

if (!isset($_SESSION['battle_id']))
{
	echo "Вы сейчас не сражаетесь. Перейдите в <a href='hero.php'>окно героя</a>";
	exit();
}

$db = mysqli_connect("localhost","bg2user","","bg2");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}
mysqli_set_charset($db, 'utf8');

$query = 'SELECT battime FROM t_accounts where id='.$_SESSION['ID'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$time = $line[0];
?>
<script>
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
 
function TimerTick() {
      $.ajax({
           type: "POST",
           url: 'ev_battle.php',
           data:{action:'timer'},
           success:function(data) {
		      $('#TimerDiv').html(data);
			  $(".you_hp::before").css("width","10px");
			  if (data<=0) AjaxBattleNextHod();
           }
      });	
	//$('#TimerDiv').html(<?php echo $time?>);

	setTimeout('TimerTick();',10000);
 }
 
function AjaxBattleNextHod() {
      $.ajax({
           type: "POST",
           url: 'ev_battle.php',
           data:{action:'battlenexthod'},
           success:function(html) { alert('Новый ход');
		     //$(".you_hp").css("background","#0000ff");
			 if (html=='endbattle')
			 {
				alert('Битва завершена');
				document.location.replace("hero.php");
			 }
			 else
			 {
				window.location.reload();
			 }
           }
      });
 }
 
function AjaxBattleSetCast(ind) {
      $.ajax({
           type: "POST",
           url: 'ev_battle.php',
           data:{action:'battlesetcast',id:ind},
           success:function(html) {
             //$("#AAA").val(html);
			 //alert(html);
			 if (html == 'Недостаточно маны для применения заклинания')
			 {
				 alert('Недостаточно маны для применения заклинания');
				 return;
			 }
			 switch (ind)
			 {
				case 0: $("#bc0").val(html);break;
				case 1: $("#bc1").val(html);break;
				case 2: $("#bc2").val(html);break;
			 }
			 //window.location.reload();
           }
      });
 }
 
function AjaxBattleSetRandom() {
      $.ajax({
           type: "POST",
           url: 'ev_battle.php',
           data:{action:'battlesetrandom'},
           success:function(html) {
			 //window.location.reload();
			 alert(html);
           }
      });
 }
 
function AjaxBattleSetOK() {
      $.ajax({
           type: "POST",
           url: 'ev_battle.php',
           data:{action:'battlesetok'},
           success:function(html) {
			 //window.location.reload();
			 alert('Выбор сделан');
           }
      });
 }
 
function AjaxBattleSetAtt(ind) {
      $.ajax({
           type: "POST",
           url: 'ev_battle.php',
           data:{action:'battlesetatt',id:ind},
           success:function(html) {
			 //window.location.reload();
           }
      });
 }
 
function AjaxBattleSetDef(ind) {
      $.ajax({
           type: "POST",
           url: 'ev_battle.php',
           data:{action:'battlesetdef',id:ind},
           success:function(html) {
			 //window.location.reload();
           }
      });
 }
</script>
<body onload="TimerTick()">

<div class="PanelBattleYou">
<?php
function init_battle()
{
	//Подготовка к битве
	$query = 'SELECT max(battle_id) from t_bat_stat';
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$new_battle_id = $line[0]+1;

	$query = 'SELECT pl1,pl2,stat from t_arena where id='.$_SESSION['arenaid'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$pl1 = $line[0];
	$pl2 = $line[1];
	if ($line[2]!=2)
	{
		exit();
	}

	//кверим pl1
	$query = 'SELECT s_all,a_all,i_all from t_accounts where id='.$pl1;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$hp = 100+5*$line[0];
	$dmg = 10+2*$line[1];
	$mana = $line[2];
	$_SESSION['youhp'] = $hp;
	$_SESSION['youchp'] = $hp;
	$_SESSION['youmana'] = $hp;
	$_SESSION['youmnm'] = $hp;	

	$query = 'INSERT INTO t_bat_stat (BATTLE_ID,ACTOR,CHP,HPM,DMG,MANA,MNM) VALUES ('.
		$new_battle_id.',1,'.$hp.','.$hp.','.$dmg.','.$mana.','.$mana.')';
	$result = mysqli_query($db,$query);
	
	//кверим pl2
	$query = 'SELECT s_all,a_all,i_all from t_accounts where id='.$pl1;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$hp = 100+5*$line[0];
	$dmg = 10+2*$line[1];
	$mana = 1*$line[2];
	$_SESSION['enechp'] = $hp;
	$_SESSION['enehp'] = $hp;

	$query = 'INSERT INTO t_bat_stat (BATTLE_ID,ACTOR,CHP,HPM,DMG,MANA,MNM) VALUES ('.
		$new_battle_id.',2,'.$hp.','.$hp.','.$dmg.','.$mana.','.$mana.')';

	$query = 'UPDATE t_arena set stat=3 where id='.$_SESSION['arenaid'];
	$result = mysqli_query($db,$query);
	
	$_SESSION['battle_id']=$new_battle_id;
	$used_cards = array();
	
	for ($j=1;$j<=2;$j++) 
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
			
			$query = 'INSERT INTO t_bat_cards (BATTLE_ID,ACTOR,NUM,PLACE) VALUES'.$_SESSION['battle_id'].','.$j.','.$r.','.$i.')';
			$result = mysqli_query($db,$query);
		}
	}
	
	for ($j=1;$j<=2;$j++) 
	{
		$query = 'INSERT INTO t_bat_choice (BATTLE_ID,ACTOR,T_ATT,T_DEF,SPELL1,SPELL2,SPELL3) VALUES ('.
			$_SESSION['battle_id'].','.$j.',-1,-1,-1,-1,-1,-1)';
		$result = mysqli_query($db,$query);
	}
}
/*
function prepare_bat_cards()
{
	for ($j=1;$j<=2;$j++) 
	{
		for ($i=0;$i<=2;$i++)
		{
			//Мы добавляем случайные карты игроку
			$r = rand(1,10);
			$query = 'UPDATE t_bat_cards set num ='.$r.' WHERE battle_id='.
				$_SESSION['battle_id'].' and actor='.$j.' and place='.$i;
			$result = mysqli_query($db,$query);
		}
	}
}
*/
$query = 'SELECT login,tip,bat,bata FROM t_accounts where id='.$_SESSION['ID'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$you_login = $line[0];
$you_tip = $line[1];
$_SESSION['battle_id']=$line[2];
$_SESSION['battle_a']=$line[3];

$query = 'SELECT chp,hpm,dmg,mana,mnm FROM t_bat_stat WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$_SESSION['youchp'] = $line[0];

echo '<div class="you_name">Ваше имя: '.$you_login.'</div>';
echo '<img src = img/person/'.$you_tip.'.jpg><br>';
echo '<br>';
echo '<div class="you_name">Количество здоровья '.$line[0].' из '.$line[1].'</div>';
echo '<div class="you_hp"></div>';
echo '<div class="you_name">Количество маны '.$line[3].' из '.$line[4].'</div>';
echo '<div class="you_mana"></div>';
echo '<div class="you_name">Базовый урон '.$line[2].'</div>';




?>
</div>

<div class = "PanelBattleAct">
<?php
echo 'Выберите куда<br>будете атаковать<br>';
echo '<p><input name="ch_att" type="radio" value="a_head" onclick=AjaxBattleSetAtt(1)> В голову</p>';
echo '<p><input name="ch_att" type="radio" value="a_body" onclick=AjaxBattleSetAtt(2)> В туловище</p>';
echo '<p><input name="ch_att" type="radio" value="a_legs" onclick=AjaxBattleSetAtt(3)> В ноги</p>';
//    <p><input type="submit" value="Выбрать"></p>

echo 'Выберите какую часть<br>тела будете защищать<br>';
echo '<p><input name="ch_def" type="radio" value="d_head" onclick=AjaxBattleSetDef(1)> Голову</p>';
echo '<p><input name="ch_def" type="radio" value="d_body" onclick=AjaxBattleSetDef(2)> Туловище</p>';
echo '<p><input name="ch_def" type="radio" value="d_legs" onclick=AjaxBattleSetDef(3)> Ноги</p>';

echo 'Ваши заклинания:<br>';

for ($i=0;$i<3;$i++)
{
	$query = 'SELECT num FROM t_bat_cards WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$_SESSION['battle_a'].' and place='.$i;
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	
	$query = 'SELECT name,mana FROM t_card_info WHERE id='.$line[0];
	$result = mysqli_query($db,$query);
	$line2 = mysqli_fetch_row($result);	
	echo '<img src = img/spell/'.$line[0].'.jpg title = '.$line2[0].'('.$line2[1].'_маны)'.'>';
}

echo '<br>';
echo '<input type=button id=bc0 value=Нет&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; onclick=AjaxBattleSetCast(0)>';
echo '<input type=button id=bc1 value=Нет&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; onclick=AjaxBattleSetCast(1)>';
echo '<input type=button id=bc2 value=Нет&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; onclick=AjaxBattleSetCast(2)>';
echo '<br>';

echo '<input type=button value=Случайно onclick=AjaxBattleSetRandom()>';
echo '<input type=button value=Применить onclick=AjaxBattleSetOK()>';
?>

<div class="PanelBattleEnemy">
<?php
$enemy_a = 3-$_SESSION['battle_a'];
$query = 'SELECT monstr,chp,hpm,dmg,mana,mnm FROM t_bat_stat WHERE battle_id='.$_SESSION['battle_id'].' and actor='.$enemy_a;
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
if ($line[0]>0)
{
	$query = 'SELECT name FROM t_monstrs WHERE id = '.$line[0];
	$result = mysqli_query($db,$query);
	$line2 = mysqli_fetch_row($result);
}
else
{
	$query = 'SELECT pl1+pl2 FROM t_arena WHERE battle_id = '.$_SESSION['battle_id'];
	$result = mysqli_query($db,$query);
	$line2 = mysqli_fetch_row($result);
	$enemy_id = $line2[0]-$_SESSION['ID'];
	
	$query = 'SELECT login,tip FROM t_accounts WHERE id = '.$enemy_id;
	$result = mysqli_query($db,$query);
	$line2 = mysqli_fetch_row($result);	
}

echo '<div class="ene_name">Ваш враг: '.$line2[0].'</div>';
if ($line[0]>0)
{
	echo '<img src = img/monstr/'.$line[0].'.jpg><br>';	
}
else
{
	echo '<img src = img/person/'.$line2[1].'.jpg><br>';
}
$_SESSION['enechp'] = $line[1];

echo '<br>';
echo '<div class="ene_name">Количество здоровья '.$line[1].' из '.$line[2].'</div>';
echo '<div class="ene_hp"></div>';
echo '<div class="ene_name">Количество маны '.$line[4].' из '.$line[5].'</div>';
echo '<div class="ene_mana"></div>';
echo '<div class="ene_name">Базовый урон '.$line[3].'</div>';

//echo '<div class="ene_name">Количество здоровья 110 из 135</div>';
//echo '<div class="ene_hp"></div>';
//echo '<div class="ene_name">Количество маны 2 из 5</div>';
//echo '<div class="ene_mana"></div>';
//<input type = "button" value = "100" id="TimerDiv">
?>
</div>


<div class="PanelBattleVS">
<h1>VS</h1>
</div>

<div class="PanelBattleTime">
<font color=red size=6><b>
<div id="TimerDiv">90</div>
</b></font>
</div>

<div class="PanelBattleDamage">
<font color=red size=4>
<?php
if (isset($_SESSION['dmgy']))
{
	echo 'Вы наносите:'.$_SESSION['dmgy'].'*'.$_SESSION['multy'].'='.$_SESSION['dhpy'];
	echo '<br><br>';
	echo 'Враг наносит:'.$_SESSION['dmge'].'*'.$_SESSION['multe'].'='.$_SESSION['dhpe'];
}
?>
</font>
</div>

</body>
</html>