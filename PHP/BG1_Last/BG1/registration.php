<html>
<head><title>Регистрация в игре</title></head>
<link rel="stylesheet" href="css/loginstyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">

<body>

<div class="PanelGameName">
Средневековое поселение
</div>

<div class="PanelLogin">
<?php
	if ( (isset($_POST['login']))&&(isset($_POST['passwd'])) )
	{
		$login = $_POST['login'];
		$passwd = $_POST['passwd'];
		
		if (stristr($login, ' '))
		{
			echo "<font color='red'><b>Логин должен быть одним словом</b></font>";
			exit();
		}
		
		if (stristr($passwd, ' '))
		{
			echo "<font color='red'><b>Пароль должен быть одним словом</b></font>";
			exit();
		}
		
		$db = mysqli_connect("localhost","pma","","bg1");
		
		if (mysqli_connect_errno()) 
		{
			echo "<font color='red'><b>Connect failed: %s\n".mysqli_connect_error()."</b></font>";
			exit();
		}

		$query = "SELECT password FROM t_accounts WHERE login='".$login."'";
		$result = mysqli_query($db,$query);
		$co = mysqli_num_rows($result);

		if ($co == 0)
		{
			$query = "INSERT INTO t_accounts (LOGIN,PASSWORD,GOLD,FOOD,WOOD,STONE,XLIMIT,YLIMIT) VALUES ('".$login."','".$passwd."',80,80,80,80,3,3)";
			//echo "query=".$query."<br>";
			$result = mysqli_query($db,$query);
			if ($result)
			{
				echo "<font color='yellow'><b>Пользователь создан. Можно начинать играть.</b></font>";
			}
			else
			{
				echo "<font color='red'><b>Ошибка добавления записи в БД</b></font>";
				exit();
			}
			
			$query = 'select max(id) from t_accounts';
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			$query = "INSERT INTO t_account_army (ID,m1,m2,m3,a1,a2,a3,c1,c2,t) VALUES (".$line[0].",0,0,0, 0,0,0, 0,0,5)";
			$result = mysqli_query($db,$query);
			
		}
		else
		{
			echo "<font color='red'><b>Указанный пользователь уже существует. Выберите другое имя.</b></font>";
		}
	}
	else
	{
		echo '<b>';
		echo '&nbsp;<form method="POST" action="registration.php">';
		echo '&nbsp;<font color="yellow">Логин</font>&nbsp;<input type="text" name="login" value=""><br>';
		echo '<font color="yellow">Пароль</font><input type="text" name="passwd" value=""><br><br>';
		echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		echo '<input type="submit" class="btn btn-success" value="Зарегистрироваться">';
		echo '</form>';
		echo '</b>';
	}
?>
</div>

</body>

</html>