<?php
$db = mysqli_connect("localhost","bg3user","","bg3");		
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}


session_start();
echo '<br>$_SESSION[login] '.$_SESSION['login'];

echo '<br>$_SESSION[CMX] '.$_SESSION['CMX'];
echo '<br>$_SESSION[FMX] '.$_SESSION['FMX'];
echo '<br>$_SESSION[MX] '.$_SESSION['MX'];

echo '<br>$_SESSION[CMY] '.$_SESSION['CMY'];
echo '<br>$_SESSION[FMY] '.$_SESSION['FMY'];
echo '<br>$_SESSION[MY] '.$_SESSION['MY'];

?>