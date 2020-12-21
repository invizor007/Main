<html>
<head>
<title>Мир призраков</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/loginstyles.css">

<body>
<div class="PanelGameName">
Мир призраков
</div>

<div class="PanelInfo">
<?php
$db = mysqli_connect("localhost","bg3user","","bg3");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}
mysqli_set_charset($db, 'utf8');


echo 'Информация об игре "Мир призраков:"';
echo '<br><br>';

if (!isset($_GET['page'])) $_GET['page']=0;
if ($_GET['page']==0)
{
	echo 'Мир призраков  - третья демонстрационная браузерная игра на PHP<br>';
	echo '<h4>Коротко об игре:</h4>';
	echo '<p>';
	echo 'Основная идея игры - развитие своего некрополиса со скелетами, вампирами, призраками и прочей нежитью. ';
	echo 'По программерской задумке - реализация трехуровневой карты, обновление ресурсов, набеги на нейтралов и других игроков. ';
	echo 'В игре посещение объектов на карте мира и карте секторов, собирать ресурсы, строить здания, выполнять задания. ';
	echo '</p>';
}

if ($_GET['page']==1)
{
	echo 'Каждый игрок владеет одним городом расположенным в определенном секторе определенной точки. В городе есть определенный набор зданий. <br>';
	echo 'Здания в игре:';
	$query = 'SELECT id,name,gold,stone FROM t_info_zd';
	$result = mysqli_query($db,$query);
	echo '<table border = 1>';
	echo '<tr><td>Id</td><td>Название</td><td>Золото</td><td>Камень</td></tr>';
	while ($line = mysqli_fetch_row($result))
	{
		echo '<tr>';
		for ($i=0;$i<=3;$i++)
		{
			echo '<td>'.$line[$i].'</td>';
		}		
		echo '</tr>';
	}
	echo '</table>';
	

}

if ($_GET['page']==2)
{
	echo 'Здания позволяют нанимать армию с которой игрок ходит по карте. Для многих найма большинства юнитов требуются определенные здания <br>';
	$query = 'SELECT u.name,z.name FROM t_info_requzd r,t_info_unit u,t_info_zd z WHERE r.uid=u.id AND r.zdid=z.id';
	$result = mysqli_query($db,$query);
	echo '<ul>';
	while ($line = mysqli_fetch_row($result))
	{
		echo '<li>Для <b>'.$line[0].'</b> требуется <b>'.$line[1].'</b><br>';
	}
	echo '</ul>';
	
}

if ($_GET['page']==3)
{
	echo 'Найм юнитов требует определенного числа ресурсов: ';
	
	$query = 'SELECT id,name,gold,meat,bones,energy FROM t_info_unit';
	$result = mysqli_query($db,$query);
	echo '<table border = 1>';
	echo '<tr><td>Id</td><td>Название</td><td>Золото</td><td>Мясо</td><td>Кости</td><td>Энергия</td></tr>';
	while ($line = mysqli_fetch_row($result))
	{
		echo '<tr>';
		for ($i=0;$i<=5;$i++)
		{
			echo '<td>'.$line[$i].'</td>';
		}		
		echo '</tr>';
	}
	echo '</table>';
}

if ($_GET['page']==4)
{
	echo 'Ресурсы можно найти на карте сектора посещая объекты или же на карте мира выполняя задания. Вот полный список ресурсов в игре:';
	echo '<ul>';
	echo '<li>Золото - основной ресурс в игре, требуется как для постройки зданий, так и для найма юнитов';
	echo '<li>Камень - дополнительный ресурс для постройки зданий';
	echo '<li>Мясо - ресурс для найма юнитов, восполняемый за посещения зданий и за битву';
	echo '<li>Кости - еще один ресурс для найма юнитов, восполняемый за посещения зданий и за битву';
	echo '<li>Энергия - также ресурс для найма юнитов и для подбора ключей';
	echo '</ul>';
}

if ($_GET['page']==5)
{
	echo 'Посещая объекты на карте сектора вы получаете восполняете ресурсы, необходимые для строительства и найма. Вот список объектов:';
	echo '<ol>';
	echo '<li>Золото - посещение дает немного золота';
	echo '<li>Камень - посещение дает немного камня';
	echo '<li>Заброшенный особняк - сражаетесь с вампирами и их помощниками и получаете разные ресурсы';
	echo '<li>Утопия драконов - сражаетесь с вампирами и их помощниками и получаете много разных ресурсов';
	echo '<li>Идол - сражаетесь с духами и их помощниками и получаете энергию';
	echo '<li>Скелет - сражаетесь со скелетами и их помощниками и получаете кости';
	echo '<li>Ветряная мельница- получаете камень и энергию сражаясь с небольшой армией нежити';
	echo '<li>Водная мельница- получаете золото и энергию сражаясь с небольшой армией нежити';
	echo '</ol>';	
}

if ($_GET['page']==6)
{
	echo 'На карте мира тоже есть объекты. Для получения бонуса вам нужно выполнить несколько заданий:';
	echo '<ol>';
	echo '<li>Обелиск-показывает координаты 5 случайных игроков';
	echo '<li>Знамя победы- бонусы для битвы';
	echo '<li>Иммунитет- иммунитет на нападения';
	echo '<li>Эльдорадо - дает 200 каждого ресурса';
	echo '</ol>';
	echo '<br><br>';
	echo 'Исходный код игры открыт, вы можете использовать его в своих проектах. Желаю успеха во всех начинаниях. ';
}

?>
</div>

<div class="PanelNav">

<?php
$num = $_GET['page'];
if ($num==0)
	{ echo '<input type = button value = "Предыдущее" class="btn">'; }
else
{
	$s = "info.php?page=".($num-1);
	echo '<input type = button value = "Предыдущее" class="btn btn-success" onClick = javascript:document.location.href="'.$s.'">';
}

echo '&nbsp;&nbsp;&nbsp;';

$s = 'town.php';
echo '<input type = button value = "Назад к игре" class="btn btn-success" onClick = javascript:document.location.href="'.$s.'">';

echo '&nbsp;&nbsp;&nbsp;';

if ($num==6)
	{ echo '<input type = button value = "Следующее" class="btn">'; }
else
{
	$s = "info.php?page=".($num+1);
	echo '<input type = button value = "Следующее" class="btn btn-success" onClick = javascript:document.location.href="'.$s.'">';
}
?>

</div>

</body>

</html>