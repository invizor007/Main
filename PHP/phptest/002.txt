<html>
 <head>
  <title>Тестируем PHP</title>
 </head>
 <body>
  <?php

  $foo=25;
  while ($foo<=40)
  {
    echo $foo," ";
    $foo+=5;
  }

  echo "<br>";

  for ($foo = 25; $foo<=40; $foo+=5)
  {
    echo $foo," ";
  }

  echo "<br>";

  $foo = 25;
  do {
    echo $foo," ";
    $foo+=5;  
  } while ($foo <= 40);

  ?>
 </body>
</html>