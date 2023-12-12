<?php
$db = mysqli_connect("localhost","KBRoot","","kgbnt");		
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

session_start();
echo '<br>$_SESSION[ID] '.$_SESSION['ID'];
echo '<br>$_SESSION[plnum] '.$_SESSION['plnum'];
echo '<br>$_SESSION[GameId] '.$_SESSION['GameId'];
echo '<br>$_SESSION[acttp] '.$_SESSION['acttp'];



?>