<html>
<head><title>Регистрация в игре</title></head>
<link rel="stylesheet" href="css/loginstyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">

<body>

<div class="PanelGameName">
Магическая арена
</div>

<div class="PanelRegistration">
<?php
$db = mysqli_connect("localhost","bg2user","","bg2");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}
mysqli_set_charset($db, 'utf8');
session_start();

if ( (isset($_POST['login']))&&(isset($_POST['passwd'])) )
{
	$login = $_POST['login'];
	$passwd = $_POST['passwd'];
	$herotip = $_SESSION['herotip'];
	
	if (stristr($login, ' '))
	{
		echo "Логин должен быть одним словом";
		exit();
	}
		
	if (stristr($passwd, ' '))
	{
		echo "Пароль должен быть одним словом";
		exit();
	}

	$query = "SELECT password FROM t_accounts WHERE login='".$login."'";
	$result = mysqli_query($db,$query);
	$co = mysqli_num_rows($result);

	if ($co == 0)
	{
		$query = "INSERT INTO t_accounts (LOGIN,PASSWORD,EXP,LEV,TIP,BAT,BATA,BATTIME) VALUES ('".$login."','".$passwd."',0,1,".$herotip.",0,0,0)";
		$result = mysqli_query($db,$query);
		if ($result)
		{
			echo "Пользователь создан. Можно начинать играть.";
		}
		else
		{
			echo $query;//"Ошибка добавления записи в БД";
			exit();
		}
		
		$query = 'SELECT s_s,s_a,s_i FROM t_person_info WHERE id='.$herotip;
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);		
		$query = "INSERT INTO t_account_stat (S_NAT,A_NAT,I_NAT,S_ALL,A_ALL,I_ALL,FREE,FREE_MAX) VALUES (".
			$line[0].",".$line[1].",".$line[2].",".$line[0].",".$line[1].",".$line[2].",1,1)";
		$result = mysqli_query($db,$query);		
	}
	else
	{
		echo "Указанный пользователь уже существует. Выберите другое имя.";
	}
}
else
{
	echo '&nbsp;<form method="POST" action="registration.php">';
	echo '&nbsp;Логин&nbsp;<input type="text" name="login" value=""><br>';
	echo 'Пароль<input type="text" name="passwd" value=""><br><br>';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<input type="submit" class="btn btn-success" value="Зарегистрироваться">';
	echo '</form>';
}
?>
</div>

<div class="PanelHeroChoose">
<?php
if ( (!isset($_POST['login'])) || (!isset($_POST['passwd'])) )
{
	if (!isset($_GET['herotip'])) $_GET['herotip'] = 1;
	$_SESSION['herotip'] = $_GET['herotip'];
	$query = 'SELECT name,s_s,s_a,s_i FROM t_person_info WHERE id='.$_SESSION['herotip'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);
	echo '<img src=img/person/'.$_SESSION['herotip'].'.bmp><br>';
}
?>
</div>

<div class="PanelHeroInfo">
<?php
if ( (!isset($_POST['login'])) || (!isset($_POST['passwd'])) )
{
	echo '<font color=red size=4>'.$line[0].'</font><br>';
	echo 'Сила '.$line[1].'<br>';
	echo 'Ловкость '.$line[2].'<br>';
	echo 'Интеллект '.$line[3].'<br>';

	echo '<br>';
	$h_next = $_GET['herotip']+1;
	if ($h_next == 7) $h_next=1;
	$h_prev = $_GET['herotip']-1;
	if ($h_prev == 0) $h_prev=6;

	echo '<input type=button class="btn btn-success" value=Следующий onClick="javascript:window.location.href=`registration.php?herotip='.$h_next.'`">';
	echo '<br><br>';
	echo '<input type=button class="btn btn-success" value=Предыдущий onClick="javascript:window.location.href=`registration.php?herotip='.$h_prev.'`">';
}		
?>
</div>

</body>

</html>