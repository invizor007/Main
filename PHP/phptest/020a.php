<?php
echo '<a href="020.php">0</a><br>';
echo '<a href="020a.php">--</a><br>';
echo '<a href="020b.php">++</a><br>';
echo '<br>';
setcookie('a',$_COOKIE['a']-1);
echo 'a='.$_COOKIE['a'];
?>
