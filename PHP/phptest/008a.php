<?php

if (!empty($_GET["page"])&&!empty($_GET["item"])) 
{ 
	echo " Page =".$_GET["page"].", item = ".$_GET["item"];
} 
else 
{ 
	echo "Error"; 
}
 
?>