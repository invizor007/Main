<html>
 <head>
  <title>Тестируем PHP</title>
 </head>
 <body>
  <?php

  $a = array (1,2,3);
  echo $a[2];
  echo "<br>";
  $b = array (1=>"Яблоко",2=>"Груша");
  echo $b[1];
  echo "<br>";

  foreach ($b as $i => $value) {
    echo $i." ".$value."<br>";
  }
  ?>
 </body>
</html>