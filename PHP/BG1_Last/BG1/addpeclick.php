<?php
session_start();

if (isset($_POST['action']) && $_POST['action']=='addpeclick')
{
	//echo "addpeclick";
	$db = mysqli_connect("localhost","pma","","bg1");
	if (mysqli_connect_errno()) 
	{
		echo "Connect failed: %s\n".mysqli_connect_error();
		exit();
	}

	if ($_SESSION['pe_m']>0)
	{
		$_SESSION['pe_c']++;
		$_SESSION['pe_m']--;
		$query = 'UPDATE user_pe set wood_c='.$_SESSION['pe_c'].', free_c='.$_SESSION['pe_m'].' WHERE ID='.$_SESSION['ID'];
		switch ($_SESSION['pe_t'])
		{
			case 1: $query='UPDATE user_pe set wood_c='.$_SESSION['pe_c'].', free_c='.$_SESSION['pe_m'].' WHERE ID='.$_SESSION['ID']; break;
			case 2: $query='UPDATE user_pe set gold_c='.$_SESSION['pe_c'].', free_c='.$_SESSION['pe_m'].' WHERE ID='.$_SESSION['ID']; break;
			case 3: $query='UPDATE user_pe set food_c='.$_SESSION['pe_c'].', free_c='.$_SESSION['pe_m'].' WHERE ID='.$_SESSION['ID']; break;
			case 4: $query='UPDATE user_pe set stone_c='.$_SESSION['pe_c'].', free_c='.$_SESSION['pe_m'].' WHERE ID='.$_SESSION['ID']; break;		
		}
		echo 'Крестьянин добавлен';//$query;
		$result = mysqli_query($db,$query);
		header("Refresh:1 url=game.php");
	}
	else
	{
		echo 'Свободных крестьян нет';
	}
	
}
?>