<?php
clearstatcache();
session_start();
$enehp_pos = round(350*$_SESSION['enechp']/$_SESSION['enehp']);
$youhp_pos = round(350*$_SESSION['youchp']/$_SESSION['youhp']);

$enemana_pos = round(350*$_SESSION['enemana']/($_SESSION['enemnm']+0.01));
$youmana_pos = round(350*$_SESSION['youmana']/($_SESSION['youmnm']+0.01));
?>

  .ene_hp {
    background: #ff0000;
    border: 1px solid #ff0000;
    height: 30px;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
   }
   
   .ene_hp::before{
    content: '';
    position: absolute; 
    height: 30px; 
	width: <?php echo $enehp_pos?>px;
    background: #30ff30;
    border: 1px solid #30ff30;
	box-shadow: 3px 0 3px rgba(0,0,0,0.5);
   }    
   
  .you_hp {
    background: #ff0000;
    border: 1px solid #ff0000;
    height: 30px;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
   }
   
   .you_hp::before{
    content: '';
    position: absolute;
    height: 30px; 
	width: <?php echo $youhp_pos?>px;
    background: #30ff30;
    border: 1px solid #30ff30;
	box-shadow: 3px 0 3px rgba(0,0,0,0.5);
   }   

   

  .ene_mana {
    background: #c0c0ff;
    border: 1px solid #c0c0ff;
    height: 30px;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
   }
   
  .ene_mana::before {
    content: '';
    position: absolute;
    height: 30px; 
	width: <?php echo $enemana_pos?>px;
    background: #3030ff;
    border: 1px solid #3030ff;
	box-shadow: 3px 0 3px rgba(0,0,0,0.5);
   }     
   
  .you_mana {
    background: #c0c0ff;
    border: 1px solid #c0c0ff;
    height: 30px;
    border-radius: 10px;
    position: relative;
    overflow: hidden;
   }
   
  .you_mana::before {
    content: '';
    position: absolute;
    height: 30px; 
	width: <?php echo $youmana_pos?>px;
    background: #3030ff;
    border: 1px solid #3030ff;
	box-shadow: 3px 0 3px rgba(0,0,0,0.5);
   }      