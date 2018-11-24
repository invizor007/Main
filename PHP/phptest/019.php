<?php
session_start();
echo '<a href="019.php">0</a><br>';
echo '<a href="019a.php">--</a><br>';
echo '<a href="019b.php">++</a><br>';
echo '<br>';
$_SESSION['a']=0;
echo 'a='.$_SESSION['a'];
?>
