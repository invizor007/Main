<html>
<head><title>Регистрация в игре</title></head>
<link rel="stylesheet" href="css/loginstyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">

<body>

<div class="PanelGameName">
Мир призраков
</div>

<div class="PanelLogin">
<?php
$db = mysqli_connect("localhost","bg3user","","bg3");
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

	$query = "SELECT password FROM t_accounts WHERE login='".$login."'";
	$result = mysqli_query($db,$query);
	$co = mysqli_num_rows($result);

	if ($co == 0)
	{
		$query = "INSERT INTO t_accounts (LOGIN,PASSWORD) VALUES ('".$login."','".$passwd."')";
		$result = mysqli_query($db,$query);
		if ($result)
		{
			echo "<font color=red><b>Пользователь создан. Можно начинать <a href ='login.php'>играть</a>.</b></font>";
		}
		else
		{
			echo $query;//"Ошибка добавления записи в БД";
			exit();
		}
		
		$query = "SELECT max(ID) FROM t_accounts";
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$plnum = $line[0];
		
		$query = "INSERT INTO t_res (ID,GOLD,MEAT,BONES,ENERGY,STONE) VALUES ('".$plnum."',100,100,200,150,200)";
		$result = mysqli_query($db,$query);
		
		$query = "INSERT INTO t_army (PLID,UID,CO) VALUES ('".$plnum."',1,7)";
		$result = mysqli_query($db,$query);

		$query = "INSERT INTO t_army (PLID,UID,CO) VALUES ('".$plnum."',2,3)";
		$result = mysqli_query($db,$query);
		
		//keys
		for ($i=1;$i<=3;$i++)
		{
			$r=rand(0,99);
			$query = 'INSERT INTO t_keys (PLID,KEYT,KEYV) VALUES ('.$plnum.','.$i.','.$r.')';
			$result = mysqli_query($db,$query);
		}
		
		$b=false;$r1=0;$r2=0;
		do
		{
			$r1=rand(1,1600);
			$r2=rand(1,1600);
			$b=false;
			$query = 'SELECT count(*) FROM t_main_plinfo WHERE sector='.$r1.' AND point='.$r2;
			$result = mysqli_query($db,$query);
			$line = mysqli_fetch_row($result);
			if ($line[0]>0) {b=true;}
		}
		while ($b)
		
		$query = 'INSERT INTO t_main_plinfo (id,qobj,qbon,sector,point,movetime,actiontype,camps,campp) VALUES ('.$plnum.',0,0,'.$r1.','.$r2.'0,0,0,0)';
		mysqli_query($db,$query);

		$query = 'DELETE FROM t_sector WHERE sectornum='.$r1.' AND pointnum='.$r2;
		mysqli_query($db,$query);	

		$query = "INSERT INTO t_message (msgid,plid,msg) VALUES (1,".$plnum.",".",'Вы находитесь на карте сектора')";
		mysqli_query($db,$query);
		
		$query = "INSERT INTO t_message (msgid,plid,msg) VALUES (2,".$plnum.",".",'Вы находитесь на карте мира')";
		mysqli_query($db,$query);		
	}
	else
	{
		echo "<font color=red><b>Указанный пользователь уже существует. Выберите другое имя.</b></font>";
	}
}
else
{
	echo '&nbsp;<form method="POST" action="registration.php">';
	echo '&nbsp;<font color=red><b>Логин</b></font>&nbsp;&nbsp;&nbsp;<input type="text" name="login" value=""><br>';
	echo '<font color=red><b>Пароль</b></font>&nbsp;<input type="text" name="passwd" value=""><br><br>';
	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<input type="submit" class="btn btn-success" value="Зарегистрироваться">';
	echo '</form>';
}
?>
</div>


</body>

</html>