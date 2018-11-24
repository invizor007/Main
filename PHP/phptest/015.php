<?php
$file = fopen ("015t.txt", "r");
if (!$file) {
    echo "<p>Unable to open remote file.\n";
    exit;
}
while (!feof ($file)) 
{
    $line = fgets ($file, 1024);
	echo str_replace("<","&lt;",$line)."<br>";
}
fclose($file);
?>