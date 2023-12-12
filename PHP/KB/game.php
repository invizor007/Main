<!DOCTYPE html>
<html>
<head><title>Текущая игра</title></head>
<script type="text/javascript" src="jquery.min.js"></script>
<link rel="stylesheet" href="css/mainstyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">

<?php
function uimgname($i,$j)
{
	return 'img/unit/u'.($i).($j-2).'.jpg';
}

function zimgname($i,$j)
{
	return 'img/zd/b'.($i).($j-1).'.jpg';
}

function oimgname($i)
{
	return 'img/obel/o0'.($i-1).'.jpg';
}

function cardimgname($tip,$subtip,$val)
{
	if ($tip==1) return 'img/unit/u'.($subtip).($val-2).'.jpg';
	if ($tip==2) return 'img/zd/b'.($subtip).($val-1).'.jpg';
	if ($tip==3) return 'img/obel/o0'.($val-1).'.jpg';
}

/////Получение данных о состоянии игры

session_start(); 
//$_SESSION['ID']=1;
//$_SESSION['GameId']=1;
if (!isset($_SESSION['plnum'])) $_SESSION['plnum']=1;
if (!isset($_SESSION['ID']))
{
	echo "<font color=red><b>Сначала войдите в игру <a href='login.php'>тут</a></b></font>";
	exit();
}
if (!isset($_SESSION['GameId']))
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

if (!isset($_SESSION['SeeID']))
{
	$_SESSION['SeeID'] = $_SESSION['ID'];
}



//карты которые есть у игрока в руке
$ycards = array();
for ($i=0;$i<4;$i++)
{
	$query = 'SELECT tip,subtip,val FROM t_cardpl t1,t_cardtypes t2 WHERE t1.crdtp_id = t2.id AND pl_id='.$_SESSION['plnum'].' AND num='.$i;
	$result1 = mysqli_query($db,$query);
	$line1 = mysqli_fetch_row($result1);

	for ($j=0;$j<=2;$j++)
		$ycards[$i][$j] = $line1[$j];
}


//карты, которые есть на поле
$query = 'SELECT tip,subtip,val,x,y FROM t_cardfront t1,t_cardtypes t2 where t1.crdtp_id = t2.id and gm_id='.$_SESSION['GameId'].' and pl_id='.$_SESSION['SeeID'];
$result = mysqli_query($db,$query);
while ($line = mysqli_fetch_row($result))
{
	$row = $line[3];
	$isup = $line[4];
	for ($i=0;$i<=2;$i++)
		$fcards[$row][$isup][$i] = $line[$i];
}

if (!isset($_SESSION['acttp']))
{
	$query = 'SELECT skipcard FROM t_gm_pl WHERE GM_ID='.$_SESSION['GameId'].' AND plnum='.$_SESSION['plnum'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$_SESSION['acttp'] = $line[0];
}

?>

<script language="javascript">
function ChooseCard(cardnum)
{
	$.ajax({
		type: "POST",
		url: 'ev_main.php',
		data:{action:'choose_card',cardnum:cardnum},
		success:function(html) {
			alert(html);
			location.reload();
		}
	});
	//alert("ChooseCard |"+cardnum);
	
}

function ChoosePlace(placenum)
{
	var placepl = <?php echo $_SESSION['SeeID']?>;
	$.ajax({
			type: "POST",
			url: 'ev_main.php',
			data:{action:'choose_place',placepl:placepl,placenum:placenum},
			success:function(html) {
				alert(html);
				//console.log(html);
				location.reload();
			}
	});
	//alert("ChoosePlace |"+placepl+"|"+placenum);
	
}

function ExitGame() 
{
	$.ajax({
			type: "POST",
			url: 'ev_main.php',
			data:{action:'exit_game'},
			success:function(html) {
				alert(html);
			}
		});
}

function SeePlayer()
{
	var v_seeid = 0;
	v_seeid = document.getElementById("inpplnum").value;
	if ((v_seeid<0)||(v_seeid>5))
	{
		v_seeid = 0;
		document.getElementById("inpplnum").value = 0;
	}
		
	$.ajax({
			type: "POST",
			url: 'ev_main.php',
			data:{action:'see_player',SeeID:v_seeid},
			success:function(html) {
				//alert(html);
				location.reload();
			}
		});
	
}

function ActN1()
{
	$.ajax({
			type: "POST",
			url: 'ev_main.php',
			data:{action:'change_acttp',acttp:1},
			success:function(html) {
				alert(html);
				location.reload();
			}
		});	
	
}

function ActN2()
{
	$.ajax({
			type: "POST",
			url: 'ev_main.php',
			data:{action:'change_acttp',acttp:2},
			success:function(html) {
				alert(html);
				location.reload();
			}
		});
	
}

function SkipCards()
{
	$.ajax({
			type: "POST",
			url: 'ev_main.php',
			data:{action:'skip_cards'},
			success:function(html) {
				alert(html);
				location.reload();
			}
		});	
}

function ChangePlnum()
{
	$.ajax({
			type: "POST",
			url: 'ev_main.php',
			data:{action:'change_plnum'},
			success:function(html) {
				alert(html);
				location.reload();
			}
		});	
	
}

function CompHod()
{
	$.ajax({
			type: "POST",
			url: 'ev_main_ai.php',
			data:{action:'comphod'},
			success:function(html) {
				alert(html);
				console.log(html);
				location.reload();
			}
		});	
	
}

//PanelInfo, PanelYouCard, PanelUsedCardArea, PanelCardList, PanelFrontCard

</script>

<body>

<div class = "PanelInfo">
<?php
//текущий игрок
$query = 'SELECT actflg FROM t_gm_pl where gm_id='.$_SESSION['GameId'].' AND plnum='.$_SESSION['plnum'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$actflg = $line[0];//if ($actflg == Y) текущий игрок ходит  if ($actflg == N) текущий игрок стоит


echo '<b>Выберите игрока: </b>';
echo '<input name="inpplnum" class="Inp1" id="inpplnum" type="number" value='.$_SESSION['SeeID'].'>';
echo '<input name="btnplnum" class="KBBTN" id="btnplnum" type="button" value="Смотреть" onclick=SeePlayer()>';
if ($actflg=="Y")
{
	if ($_SESSION['acttp']!=3)
	{
		echo '<b> Выберите действие: </b>';
		echo '<input name="btnhod" class="KBBTN" id="btnhod" type="button" value="Ходить" onclick=ActN1()>';
		echo ' или ';
		echo '<input name="btnesc" class="KBBTN" id="btnesc" type="button" value="Сброс" onclick=ActN2()>';
		echo '+';
		echo '<input name="btnesc" class="KBBTN" id="btnesc" type="button" value="Заменить" onclick=SkipCards()>';
		echo '<b> Определившись с картами нажмите </b>';
		echo '<input name="btnok" class="KBBTN" id="btnok" type="button" value="Переход хода" onclick=ChangePlnum()>';
	}
	else
	{
		echo '<b> Нажмите </b>';
		echo '<input name="btnok" class="KBBTN" id="btnok" type="button" value="Переход хода" onclick=ChangePlnum()>';
	}
}
else
{
	$query = 'SELECT val FROM t_gm_temp WHERE code="PLNUM" AND gm_id='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line1 = mysqli_fetch_row($result);
	$query = 'SELECT humflg FROM t_gm_pl WHERE gm_id='.$_SESSION['GameId'].' AND plnum='.$line1[0];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);	
	
	if ($line[0]=='Y')
	{
		echo '<b> Ждем хода другого игрока </b>';
	}
	else
	{
		echo '<input name="btnesc" class="KBBTN" id="btnesc" type="button" value="Ход компьютера" onclick=CompHod()>';
	}	
}

echo '<input name="btnesc" class="KBBTN" id="btnesc" type="button" value="Выход" onclick=ExitGame()>';

?>
</div>

<div class = "PanelYourCard">
<?php
for ($i=0;$i<4;$i++)
{
	$query = 'SELECT count(1) FROM t_gm_temp WHERE code = "SKIP" AND val='.$i.' AND GM_ID='.$_SESSION['GameId'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	$skip = $line[0];
	
	$str1 ="onclick='ChooseCard(".$i.")'";
	if (isset($ycards[$i][0]) and isset($ycards[$i][1]) and isset($ycards[$i][2]))
	{
		if ($skip==0)
			echo '<img src="'.cardimgname($ycards[$i][0],$ycards[$i][1],$ycards[$i][2]).'" '.$str1.'>';
		else
			echo '<img src=img/closed/C00.jpg '.$str1.'>';
	}
		
}
echo '<br>';
echo 'Игра №'.$_SESSION['GameId'].' началась! ';
echo 'Вы игрок №'.$_SESSION['plnum'].'! ';
echo 'Это ваши карты на руке. Используйте их.';
?>
</div>

<div class="PanelCardList">
<?php
$n=-1;
$query = 'SELECT val FROM t_gm_temp WHERE code="LASTCARD" AND gm_id='.$_SESSION['GameId'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$n = $line[0];

echo '<img src="img/closed/c00.jpg">';
echo '<br>';
echo 'В колоде осталось '.$n.' карт';
?>
</div>

<div class = "PanelUsedCardArea">
<?php
$n=-1;
$query = 'SELECT val FROM t_gm_temp WHERE code="USEDCARD" AND gm_id='.$_SESSION['GameId'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
$n = $line[0];

echo '<img src="img/closed/c00.jpg">';
echo '<br>';
echo 'Использовано карт: '.$n;
?>
</div>

<div class = "PanelFrontCard">
<?php
$query = 'SELECT count(1) FROM t_cardfront WHERE gm_id='.$_SESSION['GameId'].' AND pl_id='.$_SESSION['SeeID'];
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);	
	
if ($line[0]==0)
{
	echo '<div class="Subdiv1" onclick=ChoosePlace(0)></div>';
}

for ($j=0;$j<2;$j++)
{
	for ($i=0;$i<9;$i++)
	{
		$str1 = "onclick='ChoosePlace(".$i.")'";
		if (isset($fcards[$i][$j][0]) and isset($fcards[$i][$j][1]) and isset($fcards[$i][$j][2]))
			echo '<img src="'.cardimgname($fcards[$i][$j][0],$fcards[$i][$j][1],$fcards[$i][$j][2]).'" '.$str1.'>';
		if ($j==1)
			if ((isset($fcards[$i][0][0]))and(!isset($fcards[$i][1][0])))
				echo '<img src=img/closed/c00.jpg>';
	}
	echo '<br>';
}

?>
</div>

<div class = "PanelGotoButtons">
<?php
echo '<input name="btngogameview" class="KBBTN" id="btngogameview" type="button" value="Добавление игр и игроков" onclick=document.location.href="addpl.php">';
echo '<input name="btngogameview" class="KBBTN" id="btngogameview" type="button" value="Список игр" onclick=document.location.href="gameview.php">';
echo '<input name="btngoinfo" class="KBBTN" id="btngoinfo" type="button" value="Справка об игре" onclick=document.location.href="info.php">';
?>
</div>

</body>
</html>
