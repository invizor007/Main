<?php

$json_str = '{"one":1,"two":2,"three":3,"four":4,"five":5}';
$json = json_decode($json_str);
var_dump($json);
echo "<br>";
echo $json->one;

?>
