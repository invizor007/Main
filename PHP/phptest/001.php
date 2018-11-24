<html>
 <head>
  <title>Тестируем PHP</title>
 </head>
 <body>
  <?php
  $a = 1;
  if ($a>0) 
  {
  	echo "a>0";
  }
  elseif ($a==0)
  {
  	echo "a=0";
  }
  else
  {
  	echo "a<0";
  }

  echo "<br>";
  
  switch ($a) {
    case 0:
        echo "a=0";
        break;
    case 1:
        echo "a=1";
        break;
    default:
        echo "a не 0 и не 1";
        break;
}
  ?>
 </body>
</html>