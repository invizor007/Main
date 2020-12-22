<?php
$val = rand(1,200);
session_start();
$_SESSION['val'] = $val;
?>
   
   
  .you_hp {
    background: #ff0000;
    border: 1px solid #ff0000;
	width: 400px;	
    height: 30px;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
   }
   
   .you_hp::before{
    content: '';
    position: absolute;
    height: 30px; 
	width: <?php echo $val?>px;
    background: #30ff30;
    border: 1px solid #30ff30;
	box-shadow: 3px 0 3px rgba(0,0,0,0.5);
   }   

   