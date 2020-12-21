<?php

//include 'inc_algas.php';

session_start();
$_SESSION['ID']=1;


$db = mysqli_connect("localhost","bg3user","","bg3");		
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}
//Охрана\\\\

//5-4,3-6,2-8 заброшенный особняк
/*
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (1,5,4,4)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (1,3,6,6)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (1,2,8,8)'; $result = mysqli_query($db,$query);

//6-5,4-6,2-8,7-9 утопия драконов
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (2,6,5,5)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (2,4,6,6)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (2,2,8,8)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (2,7,9,9)'; $result = mysqli_query($db,$query);

//2-9,5-5 идол
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (3,2,9,9)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (3,5,5,5)'; $result = mysqli_query($db,$query);

//1-7,7-7 скелет
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (4,1,7,7)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (4,7,7,7)'; $result = mysqli_query($db,$query);

//1-6,2-4 ветряная мельница
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (5,1,6,6)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (5,2,4,4)'; $result = mysqli_query($db,$query);

//1-6,3-4 водная мельница
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (6,1,6,6)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_guards(GUID,UID,CO1,CO2) VALUES (6,3,4,4)'; $result = mysqli_query($db,$query);
*/

//Бонусы\\\\

/*

$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (1,1,50,50)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (2,5,50,50)'; $result = mysqli_query($db,$query);

$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (3,1,80,80)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (3,2,80,80)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (3,5,80,80)'; $result = mysqli_query($db,$query);

$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (3,1,80,80)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (3,2,80,80)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (3,5,80,80)'; $result = mysqli_query($db,$query);

$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (4,1,100,100)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (4,2,100,100)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (4,3,100,100)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (4,4,100,100)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (4,5,100,100)'; $result = mysqli_query($db,$query);

$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (5,4,60,60)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (6,3,80,80)'; $result = mysqli_query($db,$query);

$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (7,4,50,50)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (7,5,50,50)'; $result = mysqli_query($db,$query);

$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (8,4,50,50)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_bonus(BID,TID,CO1,CO2) VALUES (8,1,50,50)'; $result = mysqli_query($db,$query);
*/
/*
//Квесты\\\\
//Боевые
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (1,1,10,"Победите 10 скелетов")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (1,2,8,"Победите 8 призраков")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (1,3,8,"Победите 8 зомби")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (1,4,5,"Победите 5 личей")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (1,5,5,"Победите 5 вампиров")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (1,6,2,"Победите 2 костяного дракона")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (1,7,7,"Победите 7 скелетов лучников")'; $result = mysqli_query($db,$query);

//Походные
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (2,1,3,"Найдите 3 слитка золота")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (2,2,3,"Найдите 3 груды камней")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (2,3,2,"Посетите 2 особняка вампиров")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (2,4,1,"Посетите 1 утопию драконов")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (2,5,2,"Посетите 2 идола")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (2,6,2,"Посетите 2 скелета")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (2,7,2,"Посетите 2 ветряных мельницы")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (2,8,2,"Посетите 2 водных мельницы")'; $result = mysqli_query($db,$query);

//Текстовые
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (3,1,0,"Сколько программистов нужно чтобы вкрутить лампочку")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (3,2,18,"В каком веке родился Пушкин")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (3,3,27,"Сколько будет 3 в кубе")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (3,4,5,"Сколько школ магии в замке оплот героев 3")'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_info_quest(qtype,valt,valc,msg) VALUES (3,5,4,"Сколько атомов водорода в молекуле метана")'; $result = mysqli_query($db,$query);
*/

 //временное
/*
$query = 'INSERT INTO t_keys(plid,keyt,keyv) VALUES (1,1,55)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_keys(plid,keyt,keyv) VALUES (1,2,55)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_keys(plid,keyt,keyv) VALUES (1,3,55)'; $result = mysqli_query($db,$query);
$query = 'INSERT INTO t_key_digits(plid,eplid,keynum,dval) VALUES (1,2,3,5)'; $result = mysqli_query($db,$query);
*/

echo 'Выполнено';
?>