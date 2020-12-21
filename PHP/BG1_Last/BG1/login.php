<html>
<head><title>Вход в игру</title></head>
<link rel="stylesheet" href="css/loginstyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
<body>

<div class="PanelGameName">
Средневековое поселение
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
	
		$db = mysqli_connect("localhost","pma","","bg1");
		
		if (mysqli_connect_errno()) 
		{
			echo "Connect failed: %s\n".mysqli_connect_error();
			exit();
		}		
		$query = "SELECT password,gold,food,wood,stone,id,xlimit,ylimit FROM t_accounts WHERE login='".$login."'";
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
				echo '<font color="yellow"><b>';
				echo "Вы вошли как ".$login.". Начинаем игру"."<br>";
				echo "Ваши ресурсы: ".$line[1]." дерева  ".$line[2]." золота  ".$line[3]." еды  ".$line[4]." камня<br>";
				session_start();
				$_SESSION['login']=$login;
				$_SESSION['wood']=$line[1];
				$_SESSION['gold']=$line[2];
				$_SESSION['food']=$line[3];
				$_SESSION['stone']=$line[4];
				$_SESSION['ID']=$line[5];
				$_SESSION['xlimit']=$line[6];
				$_SESSION['ylimit']=$line[7];
				echo '</font></b>';
				
				if (isset($_SESSION['battle_id'])) {unset($_SESSION['battle_id']);}
				echo '<input type="button" value="Играть" onClick = "javascript:document.location.href=`game.php`">';
				
			}
			else
			{
				echo "Неверный пароль пользователя";
			}
		}
	}
	else
	{
		echo '<b>';
		echo '<br>';
		echo '<form method="POST" action="login.php">';
		echo '&nbsp;<font color="yellow">Логин </font>&nbsp;<input type="text" class="text" name="login" value=""><br>';
		echo '&nbsp;<font color="yellow">Пароль</font><input type="text" class="text" name="passwd" value=""><br><br>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<input type="submit" class="btn btn-success" value="Войти">';
		echo '</form>';
		echo '</b>';
	}
?>
</div>

</body>
</html>