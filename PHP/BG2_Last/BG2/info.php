<html>
<head>
<title>Магическая арена</title>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
</head>
<link rel="stylesheet" href="bootstrap-3.3.2-dist/css/bootstrap.min.css">
<link rel="stylesheet" href="css/loginstyles.css">

<body>
<div class="PanelGameName">
Магическая арена
</div>

<div class="PanelInfo">
<?php
$db = mysqli_connect("localhost","bg2user","","bg2");
if (mysqli_connect_errno()) 
{
	echo "Connect failed: %s\n".mysqli_connect_error();
	exit();
}
mysqli_set_charset($db, 'utf8');


echo 'Информация об игре "Магическая арена:"';
echo '<br><br>';

if (!isset($_GET['page'])) $_GET['page']=0;
if ($_GET['page']==0)
{
	echo 'Магическая арена  - демонстрационная браузерная игра на PHP<br>';
	echo '<h4>Коротко об игре:</h4>';
	echo '<p>';
	echo 'Вы играете одним из героев: ассасин, гладиатор, маг, рыцарь, монах, шаман. Ваша цель - развивать героя, набирая опыт в сражениях и охотах.';
	echo 'За каждое выигранное сражения дают артефакт. В сражении можно атаковать и пользоваться заклинаниями.';
	echo 'У героя есть 3 характеристики - сила, ловкость, интеллект. Сила увеличивает здоровье героя, ловкость - урон, интеллект - количество маны.';
	echo 'Характеристики растут при повышении уровня героя. У разных героев изначально разные характеристики, что показано на следующей странице.';
	echo '</p>';
}

if ($_GET['page']==1)
{
	$query = 'SELECT id,name,s_s,s_a,s_i from t_person_info';
	$result = mysqli_query($db,$query);
	echo '<table border=1>';
	echo '<tr> <td>№</td> <td>Герой</td> <td>Сила</td> <td>Ловкость</td> <td>Интеллект</td> </tr>';
	while ($line = mysqli_fetch_row($result))
	{
		echo '<tr>';
		for ($i=0;$i<5;$i++)
		{
			echo '<td>'.$line[$i].'</td>';
		}
		echo '</tr>';		
	}
	echo '</table>';
	echo 'Характеристики также могут быть увеличены благодаря артефактам. <br><br> На слайде ниже информация об артефактах в игре.';
}

if ($_GET['page']==2)
{
	echo 'Обувь<br>';
	$query = 'SELECT id,name,bonus_s,bonus_a,bonus_i from t_art_info where place = 3';
	$result = mysqli_query($db,$query);
	echo '<table border=1>';
	echo '<tr> <td>№</td> <td>Название</td> <td>+Сила</td> <td>+Ловкость</td> <td>+Интеллект</td> </tr>';
	while ($line = mysqli_fetch_row($result))
	{
		echo '<tr>';
		for ($i=0;$i<5;$i++)
		{
			echo '<td>'.$line[$i].'</td>';
		}
		echo '</tr>';		
	}
	echo '</table>';
	
	echo '<br>Броня<br>';
	$query = 'SELECT id,name,bonus_s,bonus_a,bonus_i from t_art_info where place = 2';
	$result = mysqli_query($db,$query);
	echo '<table border=1>';
	echo '<tr> <td>№</td> <td>Название</td> <td>+Сила</td> <td>+Ловкость</td> <td>+Интеллект</td> </tr>';
	while ($line = mysqli_fetch_row($result))
	{
		echo '<tr>';
		for ($i=0;$i<5;$i++)
		{
			echo '<td>'.$line[$i].'</td>';
		}
		echo '</tr>';		
	}
	echo '</table>';
}

if ($_GET['page']==3)
{
	echo 'Шлемы<br>';
	$query = 'SELECT id,name,bonus_s,bonus_a,bonus_i from t_art_info where place = 1';
	$result = mysqli_query($db,$query);
	echo '<table border=1>';
	echo '<tr> <td>№</td> <td>Название</td> <td>+Сила</td> <td>+Ловкость</td> <td>+Интеллект</td> </tr>';
	while ($line = mysqli_fetch_row($result))
	{
		echo '<tr>';
		for ($i=0;$i<5;$i++)
		{
			echo '<td>'.$line[$i].'</td>';
		}
		echo '</tr>';		
	}
	echo '</table>';
	echo '<br>Базовый урон героя 10 и увеличивается за каждую единицу ловкости на 2. Но в дополнение к этому урону еще можно использовать заклинания.';
	echo '<br><br>Подробнее о них на следующей странице';
}

if ($_GET['page']==4)
{
	$query = "SELECT name,descr,mana from t_card_info";
	$result = mysqli_query($db,$query);
	echo '<ul>';
	while ($line = mysqli_fetch_row($result))
	{
		echo '<li><i>'. $line[0].' </i>'.$line[1].'('.$line[2].' маны)';	
	}
	echo '</ul>';

}

if ($_GET['page']==5)
{
	echo 'Заклинания нужно грамотно применять, а также важно предугадывать куда атакует противник и блокировать его удар.';
	echo 'При удачной блокировке урон снижается наполовину';
	echo '<br><br>';
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

$s = 'hero.php';
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