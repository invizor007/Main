<?php
session_start();

if (isset($_POST['action']) && $_POST['action']=='forestclick')
{
	if ( ($_SESSION['forest_visited'] & (1 << $_POST['id'] ) ) != 0 )
	{
		echo 'Вы уже посещали это место. Ничего нового тут нет.';
	}
	else if ($_SESSION['forest_trap'] == $_POST['id'])
	{
		echo 'На вас нападают бандиты. Хорошо что вам удается убежать';
	}
	else if ($_SESSION['forest_klad'] == $_POST['id'])
	{		
		$_SESSION['klad_n'] = rand(1,4);
		$_SESSION['klad_v'] = rand(10,30);
		switch ($_SESSION['klad_n'])
		{
			case 1: $s = $_SESSION['klad_v'].' дерева';break;
			case 2: $s = $_SESSION['klad_v'].' золота';break;
			case 3: $s = $_SESSION['klad_v'].' еды';break;
			case 4: $s = $_SESSION['klad_v'].' камня';break;
		}
		echo 'Вы находите клад: '.$s.'. Возвращайтесь домой';
		
		$_SESSION['forest_visited']+=(1 << $_POST['id'] );
	}
	else
	{
		echo 'Вы ничего не находите';
		$_SESSION['forest_visited']+=(1 << $_POST['id'] );
	}
}
if (isset($_POST['action']) && $_POST['action']=='homeclick')
{
	$db = mysqli_connect("localhost","pma","","bg1");
	if (mysqli_connect_errno()) 
	{
		echo "Connect failed: %s\n".mysqli_connect_error();
		exit();
	}

	if ($_SESSION['klad_v']==0)
	{
		echo 'Вы возвращаетесь домой';
	}
	else
	{
		switch ($_SESSION['klad_n'])
		{
			case 1: $_SESSION['wood']+=$_SESSION['klad_v'];$query = 'UPDATE t_accounts set wood='.$_SESSION['wood'].' where id='.$_SESSION['ID'];break;
			case 2: $_SESSION['gold']+=$_SESSION['klad_v'];$query = 'UPDATE t_accounts set gold='.$_SESSION['gold'].' where id='.$_SESSION['ID'];break;
			case 3: $_SESSION['food']+=$_SESSION['klad_v'];$query = 'UPDATE t_accounts set food='.$_SESSION['food'].' where id='.$_SESSION['ID'];break;
			case 4: $_SESSION['stone']+=$_SESSION['klad_v'];$query = 'UPDATE t_accounts set stone='.$_SESSION['stone'].' where id='.$_SESSION['ID'];break;
		}
		$result = mysqli_query($db,$query);
		echo 'Вы возвращаетесь домой с кладом';
	}
}
?>