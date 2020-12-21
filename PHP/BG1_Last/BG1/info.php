<html>
<head><title>Средневековое поселение</title></head>
<link rel="stylesheet" href="css/loginstyles.css">
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">

<body>
<div class="PanelGameName">
Средневековое поселение
</div>

<div class="PanelInfo">
<?php
$db = mysqli_connect("localhost","pma","","bg1");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}	
mysqli_set_charset($db, 'utf8');


echo 'Информация об игре "Средневековое поселение:"';
echo '<br><br>';

if (!isset($_GET['page'])) $_GET['page']=0;
if ($_GET['page']==0)
{
	echo 'Игра жанра стратегия. Стройте здания, нанимайте отряды и сражайтесь. <br>';
	echo '<h4>Основные здания:</h4>';
	echo '<ul>';
	echo '<li>Дом - дает 5 населения. Необходим по сути для всех юнитов';
	echo '<li>Ресурсные здания: (лесопилка, золотая шахта, ферма, камелоломня) дают прирост определенного ресурса 3 за каждое здание. А еще туда можно заводить крестьян и каждый повышает прирост на 4. (А базовый прирост= 2). Максимальное количество зданий этого типа 3.';
	echo '<li>Здания для найма существ: казармы, стрельбище, конюшня. Позволяют нанимать пехоту, стрелков и кавалерию. У каждого юнита есть уровень. Например мечник уровень=2 то для найма необходимо 2 здания казармы. Максимальное количество 3.';
	echo '</ul>';
}

if ($_GET['page']==1)
{
	echo '<ul>';
	echo '<li>Склад - добавляет 40 к лимиту ресурсов для ежеминутного прироста. Прирост ресурсов другими способами не ограничивается. Можно строить до 10 складов.';
	echo '<li>Башня - добавляет 5 урона к урону вашей башни. Можно строить 3 башни.';	
	echo '<li>Храм - каждый храм дает бонус урона 2 для каждого юнита. Можно построить 2 храма';
	echo '<li>Оружейня - враги по вам наносят меньше урона на 1 за каждую оружейню. Можно строить 3 оружейни';
	echo '</ul>';
	echo 'Здания строят определенное количество ресурсов - дерева, золота, еды и камней, цены представлены на следующем слайде<br>';
}

if ($_GET['page']==2)
{
	$query = 'SELECT id,name,wood,gold,food,stone from zdinfo';
	$result = mysqli_query($db,$query);
	echo '<table border=1>';
	echo '<tr> <td>№</td> <td>Название</td> <td>Дерево</td> <td>Золото</td> <td>Еда</td> <td>Камень</td> </tr>';
	while ($line = mysqli_fetch_row($result))
	{
		echo '<tr>';
		for ($i=0;$i<6;$i++)
		{
			echo '<td>'.$line[$i].'</td>';
		}
		echo '</tr>';		
	}
	echo '</table>';
	echo 'Далее перейдем к разбору юнитов. Их может быть сколько угодно но для боя нужно выбрать лучших- трех из пехоты, трех из стрелков и двух из кавалерии. На следующем слайде указана стоимость юнитов.';
}

if ($_GET['page']==3)
{
	$query = 'SELECT id,name,wood,gold,food,stone from uinfo';
	$result = mysqli_query($db,$query);
	echo '<table border=1>';
	echo '<tr> <td>№</td> <td>Название</td> <td>Дерево</td> <td>Золото</td> <td>Еда</td> <td>Камень</td> </tr>';
	while ($line = mysqli_fetch_row($result))
	{
		echo '<tr>';
		for ($i=0;$i<6;$i++)
		{
			echo '<td>'.$line[$i].'</td>';
		}
		echo '</tr>';		
	}
	echo '</table>';
	echo 'Начнем с крестьян. Тут все просто - используется на шахтах для повышения дохода. Остальные юниты - военные. На следующем слайде сравним военные юниты по характеристикам.';
}

if ($_GET['page']==4)
{
	$query = "SELECT lev,name,hp,dmg,ms,case when tat=0 then 'Нет' else 'Да' end from uinfo where id<>1";
	$result = mysqli_query($db,$query);
	echo '<table border=1>';
	echo '<tr> <td>Уровень</td> <td>Название</td> <td>ХП</td> <td>Урон</td> <td>Скорость</td> <td>Стреляет</td> </tr>';
	while ($line = mysqli_fetch_row($result))
	{
		echo '<tr>';
		for ($i=0;$i<6;$i++)
		{
			echo '<td>'.$line[$i].'</td>';
		}
		echo '</tr>';		
	}
	echo '</table>';
	echo 'Есть еще башня - она тоже наносит урон от 5 до 20, но ее нельзя атаковать.';
}

if ($_GET['page']==5)
{
	echo 'Боевые юниты применяются в битве. Битва - это возможность заработать ресурсы и боевой опыт за который тоже дают ресурсы. Ход в битве распределяется случайным образом. Компьютер атакует юнита у которого на текущий момент меньше всего здоровья. <br><br>';
	echo 'Ресурсы можно получить блуждая по лесу а также существует прирост ресурсов раз в минуту в количестве в зависимости от того сколько у вас щахт и крестьян в них. <br><br>';
	echo 'Вот такая игра на PHP MySQL Ajax. Играйте, изучайте исходники, смотрите видео на <a href=https://www.youtube.com/channel/UC-3MAaVSL_-OSoKd16tkK0A>канале</a>.';
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

$s = 'game.php';
echo '<input type = button value = "Назад к игре" class="btn btn-success" onClick = javascript:document.location.href="'.$s.'">';

echo '&nbsp;&nbsp;&nbsp;';

if ($num==5)
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