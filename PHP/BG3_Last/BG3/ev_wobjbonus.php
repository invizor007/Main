<?php

//include 'inc_algas.php';

//session_start();

function check_active_quest()
{
	$db = mysqli_connect("localhost","bg3user","","bg3");
	if (!isset($_SESSION['ID'])) {return;}

	$query = 'SELECT count(*) FROM t_active_quest WHERE plid='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);	
	$qcount = $line[0];
	
	$query = 'SELECT count(*) FROM t_active_quest WHERE currc>=goalc AND plid='.$_SESSION['ID'];
	$result = mysqli_query($db,$query);
	$line = mysqli_fetch_row($result);	
	$qfinish = $line[0];
	
	if ( ($qcount==$qfinish) and ($qcount>0) )
	{
		echo 'Вы получаете бонусы за выполненные задания. ';
		$query = 'SELECT qobj FROM t_main_plinfo WHERE id='.$_SESSION['ID'];
		$result = mysqli_query($db,$query);
		$line = mysqli_fetch_row($result);
		$qobj = $line[0];
		switch ($qobj) {
			case 1: $s = 'Координаты пяти других игроков: ';
					$query = 'SELECT count(*) FROM t_main_plinfo';
					$result = mysqli_query($db,$query);
					$line = mysqli_fetch_row($result);
					$maxnum=$line[0];
					
					for ($i=0;$i<5;$i++)
					{
						$r=rand(1,$maxnum);
						$query = 'SELECT sector,point FROM t_main_plinfo WHERE id='.$r;
						$result = mysqli_query($db,$query);
						$line = mysqli_fetch_row($result);
						$s=$s.'('.$line[0].','.$line[1].')';
					}
					
					$query = 'UDPATE t_message SET msg='.$s.' WHERE msgid=2 AND plid='.$_SESSION['ID'];
					mysqli_query($db,$query);
					echo $s;
					break;
			case 2: $query = 'UPDATE t_main_plinfo SET qbon=105 WHERE id='.$_SESSION['ID'];
					mysqli_query($db,$query);
					break;
			case 3: $query = 'UPDATE t_main_plinfo SET qbon=203 WHERE id='.$_SESSION['ID'];
					mysqli_query($db,$query);
					break;
			case 4: $query = 'UPDATE t_res SET gold=gold+200,meat=meat+200,stone=stone+200,bones=bones+200,energy=energy+200 WHERE id='.$_SESSION['ID'];
					mysqli_query($db,$query);
					break;
		}
	}
}

?>