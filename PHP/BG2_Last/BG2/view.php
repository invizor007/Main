<?php
$db = mysqli_connect("localhost","bg2user","","bg2");		
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

session_start();
echo '<br>$_SESSION[arenaid] '.$_SESSION['arenaid'];
echo '<br>$_SESSION[battle_id] '.$_SESSION['battle_id'];
echo '<br>$_SESSION[query] '.$_SESSION['query'];
echo '<br>$_SESSION[zapros] '.$_SESSION['zapros'];

echo '<br>$_SESSION[youhp] '.$_SESSION['youhp'];
echo '<br>$_SESSION[youchp] '.$_SESSION['youchp'];

?>