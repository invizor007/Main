<?php
$db = mysqli_connect("localhost","pma","","bg1");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}

$query = 'select max(id) from t_accounts';
$result = mysqli_query($db,$query);
$line = mysqli_fetch_row($result);
echo 'селект '.$line[0];

session_start();
echo '<br>$_SESSION[ID] '.$_SESSION['ID'];
echo '<br>$_SESSION[cux] '.$_SESSION['cux'];
echo '<br>$_SESSION[u_tip] '.$_SESSION['u_tip'];
echo '<br>$_SESSION[u_num] '.$_SESSION['u_num'];
echo '<br>$_SESSION[u_yoe] '.$_SESSION['u_yoe'];
echo '<br>$_SESSION[Ne1] '.$_SESSION['Ne1'];

echo '<br>$_SESSION[test1] '.$_SESSION['test1'];
echo '<br>$_SESSION[test2] '.$_SESSION['test2'];

echo '<br>$_SESSION[pe_c] '.$_SESSION['pe_c'];
echo '<br>$_SESSION[pe_m] '.$_SESSION['pe_m'];
?>