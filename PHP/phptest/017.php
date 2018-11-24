<?php

if (file_exists('017.xml')) 
{
	$xml = simplexml_load_file('017.xml');
	var_dump($xml);
	echo "<br>";
	echo $xml->file[1];

}
else
{
	exit('Failed to open test.xml.');
}


?>

