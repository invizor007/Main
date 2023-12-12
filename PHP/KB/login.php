<html>
<head><title>Вход в игру</title></head>
<link rel="stylesheet" href="css/loginstyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
<body>

<div class="PanelGameName">
Kings Bounty
</div>

<div class="PanelLogin">
<?php
	$login;$passwd;

	if (isset($_POST['login']))
	{
		$login = $_POST['login'];
		$passwd = $_POST['passwd'];
		
		if (stristr($login, ' '))
		{
			echo "<font color=red><b>Логин должен быть одним словом</b></font>";
			exit();
		}
		
		if (stristr($passwd, ' '))
		{
			echo "<font color=red><b>Пароль должен быть одним словом</b></font>";
			exit();
		}
	
		$db = mysqli_connect("localhost","KBRoot","","kgbnt");
		
		if (mysqli_connect_errno()) 
		{
			echo "Connect failed: %s\n".mysqli_connect_error();
			exit();
		}		
		$query = "SELECT code,id,gm_id FROM t_accounts WHERE name='".$login."'";
		$result = mysqli_query($db,$query);
		$co = mysqli_num_rows($result);
	
		if ($co == 0)
		{
			echo "Пользователь не существует";
		}
		else
		{
			$line = mysqli_fetch_row($result);
			if ($line[0]==$_POST['passwd'])
			{
				echo "<font color=red><b>Вы вошли как ".$login.".<br> Начинаем игру"."</b></font><br>";
				session_start();
				$_SESSION['login']=$login;
				$_SESSION['ID']=$line[1];
				$_SESSION['GameId']=$line[2];
				echo '<input type="button" class="btn btn-success" value="Играть" onClick = "javascript:document.location.href=`game.php`">';
			}
			else
			{
				echo "Неверный пароль пользователя";
			}
		}
	}
	else
	{
		echo '<br>';
		echo '<form method="POST" action="login.php">';
		echo '&nbsp;<font color=red><b>Логин</b></font>&nbsp;&nbsp;&nbsp;<input type="text" name="login" value=""><br>';
		echo '<font color=red><b>Пароль</b></font>&nbsp;<input type="text" name="passwd" value=""><br><br>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<input type="submit" class="btn btn-success" value="Войти">';
		echo '</form>';
	}
?>
</div>

</body>
</html>