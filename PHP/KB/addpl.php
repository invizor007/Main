<html>
<head><title>Kings Bounty</title></head>
<script type="text/javascript" src="jquery.min.js"></script>
<link rel="stylesheet" href="css/loginstyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">

<?
session_start();
//$_SESSION['ID'] = 1;//временно
?>

<script language="javascript">
function ShowGameInfo()
{
	var gmnum = document.getElementById("choosegametext").value;
	if (gmnum=="undefined") gmnum = 0;
	var plid = <?php echo $_SESSION['ID']?>;
	$.ajax({
			type: "POST",
			url: 'ev_control.php',
			data:{action:'show_game_info',plid:plid,gmnum:gmnum},
			success:function(html) {
				alert(html);
			}
	});	
	alert("ShowGameInfo");
}

function ChooseGame()
{
	var gmnum = document.getElementById("choosegametext").value;
	var plnum = document.getElementById("chooseplnumtext").value;
	if (gmnum=="undefined") gmnum = 0;
	if (plnum=="undefined") plnum = 0;
	var plid = <?php echo $_SESSION['ID']?>;
	$.ajax({
			type: "POST",
			url: 'ev_control.php',
			data:{action:'choose_game',plid:plid,gmnum:gmnum,plnum:plnum},
			success:function(html) {
				alert(html);
			}
	});	
	alert("ChooseGame");
}

function CreateGame()
{
	var plid = <?php echo $_SESSION['ID']?>;
	var plco = document.getElementById("choosegameplco").value;
	if (plco=="undefined") {alert("Введите количество игроков от 2 до 5");return;}
	if ((plco<2)||(plco>5)) {alert("Введите количество игроков от 2 до 5");return;}
	$.ajax({
			type: "POST",
			url: 'ev_control.php',
			data:{action:'create_game',plid:plid,plco:plco},
			success:function(html) {
				alert(html);
			}
	});	
	alert("CreateGame");
}
</script>

<body>
<div class="PanelGameName">
Kings Bounty
</div>

<div class="PanelLogin">
<?php
$_SESSION['ID'] = 1;//временно
if (isset($_SESSION['ID']))
{
	echo 'Выберите игру:<br>';
	echo '<input type="number" id="choosegametext"><br><br>';
	echo '<input type="button" value="Посмотреть игроков" class="btn btn-success" onClick = "ShowGameInfo()"><br><br>';
	echo 'Выберите номер:<br>';	
	echo '<input type="number" id="chooseplnumtext"><br><br>';	
	echo '<input type="button" value="Присоединиться" class="btn btn-success" onClick = "ChooseGame()"><br><br>';
	echo '<input type="button" value="Создать игру" class="btn btn-success" onClick = "CreateGame()"><br>';
	echo 'Количество игроков:<br>';
	echo '<input type="number" id="choosegameplco" name="choosegameplco"><br><br>';
}
else
{
	echo '<input type="button" value="Войти" class="btn btn-success" onClick = "javascript:document.location.href=`login.php`">';
	echo '<input type="button" value="Зарегистрироваться" class="btn btn-success" onClick = "javascript:document.location.href=`registration.php`">';
}
?>
</div>

</body>

</html>