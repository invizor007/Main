<?php
//$to  = "<mail@example.com>, " ; 
//$to .= "mail2@example.com>"; 

$to = "admin@localhost";

$subject = "��������� ������"; 

$message = ' <p>����� ������</p> </br> <b>1-�� ������� </b> </br><i>2-�� ������� </i> </br>';

$headers  = "Content-type: text/html; charset=windows-1251 \r\n"; 
$headers .= "From: �� ���� ������ <from@example.com>\r\n"; 
$headers .= "Reply-To: reply-to@example.com\r\n"; 

mail($to, $subject, $message, $headers);
echo 'Email was sent';

//https://habr.com/ru/post/444744/
//https://www.php.net/manual/ru/function.mail.php
//http://www.php.su/articles/?cat=email&page=001

?>