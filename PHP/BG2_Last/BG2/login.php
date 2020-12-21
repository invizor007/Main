<html>
<head><title>Вход в игру</title></head>
<link rel="stylesheet" href="css/loginstyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
<body>

<div class="PanelGameName">
Магическая арена
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
			echo "Логин должен быть одним словом";
			exit();
		}
		
		if (stristr($passwd, ' '))
		{
			echo "Пароль должен быть одним словом";
			exit();
		}
	
		$db = mysqli_connect("localhost","bg2user","","bg2");
		
		if (mysqli_connect_errno()) 
		{
			echo "Connect failed: %s\n".mysqli_connect_error();
			exit();
		}		
		$query = "SELECT password,id FROM t_accounts WHERE login='".$login."'";
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
				echo "Вы вошли как ".$login.". Начинаем игру"."<br>";
				session_start();
				$_SESSION['login']=$login;
				$_SESSION['ID']=$line[1];
				echo '<input type="button" value="Играть" onClick = "javascript:document.location.href=`hero.php`">';
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
		echo '&nbsp;Логин &nbsp;<input type="text" class="text" name="login" value=""><br>';
		echo '&nbsp;Пароль<input type="text" class="text" name="passwd" value=""><br><br>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<input type="submit" class="btn btn-success" value="Войти">';
		echo '</form>';
	}
?>
</div>

</body>
</html>