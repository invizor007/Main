<html>
<head><title>Регистрация в игре</title></head>
<link rel="stylesheet" href="css/loginstyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">

<body>

<div class="PanelGameName">
Kings bounty
</div>

<div class="PanelLogin">
<?php

/*
Ввод логина-> если (логина нет в БД ) {Генерация кода; Отправка его пользователю; Ожидание старта игры}
*/
function generate_code()
{
	$rescode = "";
	for ($i = 0;$i<8; $i++)
	{
		$r = rand(0,9);
		$rescode .= (string)$r;
	}
	return $rescode;
}


$db = mysqli_connect("localhost","KBRoot","","kgbnt");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}
mysqli_set_charset($db, 'utf8');
session_start();

if ( (isset($_POST['login'])) )
{
	$login = $_POST['login'];
	$mail_addr_to = $_POST['email'];
	$passwd = generate_code();
	//echo $_POST['showcodeflg'];
	
	if ($login=='')
	{
		echo "<font color=red><b>Логин не должен быть пустым</b></font>";
		exit();
	}	
	
	if (stristr($login, ' '))
	{
		echo "<font color=red><b>Логин должен быть одним словом</b></font>";
		exit();
	}
	
	$pattern = "|"."^[A-Za-z0-9]{5,20}"."|";
	$match = "";
	if (preg_match_all($pattern, $login,$match)==0)
	{
		echo "<font color=red><b>Логин должен содержать только латинские буквы или цифры от 5 до 20 штук</b></font>";
		exit();
	}	

	$query = "SELECT * FROM t_accounts WHERE name='".$login."'";
	$result = mysqli_query($db,$query);
	$co = mysqli_num_rows($result);

	if ($co == 0)
	{
		$query = "INSERT INTO t_accounts (NAME,CODE) VALUES ('".$login."','".$passwd."')";
		mysqli_query($db,$query);
		
		$query = 'SELECT MAX(id) FROM t_accounts WHERE 1=1';
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$_SESSION['ID'] = $line[0];
		
		$query = 'SELECT MAX(gm_id) FROM t_gm_pl WHERE 1=1';
		$result = mysqli_query($db,$query);
		if ($result)
		{
			$line = mysqli_fetch_row($result);
			$gmnum = $line[0]+1;
		}
		else
			$gmnum = 1;
		
		mysqli_query($db, 'UPDATE t_accounts SET gm_id='.$gmnum.' WHERE ID='.$_SESSION['ID']);
		
		mysqli_query($db, 'INSERT INTO t_gm_pl (acc_id,gm_id,plnum,humflg,actflg,skipcard,score,lasthflg,lastmflg) VALUES ('.$_SESSION['ID'].','.$gmnum.',1,"Y","Y",0,0,"N","N")');
		
		$plco = 5;	
		$ca1 = 46-4*$plco;
		$ca2 = 4*$plco;
		for ($i=2;$i<=$plco;$i++)
			mysqli_query($db, 'INSERT INTO t_gm_pl (acc_id,gm_id,plnum,humflg,actflg,skipcard,score,lasthflg,lastmflg) VALUES ('.$_SESSION['ID'].','.$gmnum.','.$i.',"N","N",0,0,"N","N")');
		
		mysqli_query($db,'INSERT INTO t_gm_temp (GM_ID,CODE,VAL) VALUES ('.$gmnum.',"PLCO",'.$plco.')');
		mysqli_query($db,'INSERT INTO t_gm_temp (GM_ID,CODE,VAL) VALUES ('.$gmnum.',"STEP",1)');
		mysqli_query($db,'INSERT INTO t_gm_temp (GM_ID,CODE,VAL) VALUES ('.$gmnum.',"PLNUM",1)');
		mysqli_query($db,'INSERT INTO t_gm_temp (GM_ID,CODE,VAL) VALUES ('.$gmnum.',"LASTCARD",'.$ca1.')');
		mysqli_query($db,'INSERT INTO t_gm_temp (GM_ID,CODE,VAL) VALUES ('.$gmnum.',"USEDCARD",'.$ca2.')');		
		
		//Отправка email
		$mail_addr_from = "admin@localhost";
		$mail_subject = "Регистрация в игре King Bounty"; 
		$mail_message = ' <p>Добрый день!</p></br>Вы зарегистрированы в игре Kings Bounty</br>Ваш логин '.$login.' </br>Ваш пароль '.$passwd.'</br>';
		$mail_headers  = "Content-type: text/html; charset=windows-1251 \r\n"; 
		$mail_headers .= "From: От кого письмо <admin@localhost>\r\n"; 
		$mail_headers .= "Reply-To: admin@localhost\r\n"; 
		mail($mail_addr_to, $mail_subject, $mail_message, $mail_headers);		

		if (isset($_POST['showcodeflg']))
			if ($_POST['showcodeflg']=="on")
				echo '<font color=red><b>Код: '.$passwd.'</b></font><br>';
		echo "<font color=red><b>Пользователь создан. Можно начинать <a href ='login.php'>играть</a>.</b></font>";
		
	}
	else
	{
		echo "<font color=red><b>Указанный пользователь уже существует. Выберите другое имя.</b></font>";
	}
}
else
{
	echo '&nbsp;<form method="POST" action="registration.php">';
	echo '&nbsp;<font color=red><b>Логин</b></font>&nbsp;&nbsp;&nbsp;';
	echo '<input type="text" name="login" value=""><br><br>';
	echo '&nbsp;<font color=red><b>Email</b></font>&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<input type="text" name="email" value=""><br><br>';
	echo 'Показать код&nbsp;';
	echo '<input type="checkbox" name="showcodeflg" checked="true"><br><br>';	
	echo '<input type="submit" class="btn btn-success" value="Регистрация"><br><br>';

	
	echo '<font color=red><b>Код</b></font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	echo '<input type="text" name="passwd" value=""><br>';	
	echo '</form>';
}
?>
</div>


</body>

</html>