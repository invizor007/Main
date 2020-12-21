<?php
$val = 10;
?>
   
   
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
    position: absolute; /* Абсолютное позиционирование */
    height: 30px; 
	width: 200px;
    background: #30ff30;
    border: 1px solid #30ff30; /* Рамка */
	box-shadow: 3px 0 3px rgba(0,0,0,0.5); /* Тень справа */
   }   

   