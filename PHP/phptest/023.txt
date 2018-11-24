<html>

<?php
$db=mysql_connect("localhost", "pma", "") or die("Could connect mysql");//соединение с БД, параметры стандартные
mysql_select_db("test") or die("Could not select database");//выбор базы данных

		$query = "INSERT INTO new_tab1 (ID, name) VALUES (7, '7');";//формируем строку с sql запросом
		mysql_query($query);//получаем результат его выполнения			
		
        $query = "SELECT * FROM new_tab1";//формируем строку с sql запросом
        $result = mysql_query($query);//получаем результат его выполнения
        if (!$result) die("bad sql");//если нет результата выводим соответствующее сообщение об ошибке
        print "\n";//Печатаем результаты
        while ($line = mysql_fetch_row($result)) 
            {
	    print "||";
            foreach ($line as $col_value) {print $col_value."||";}
            print "<br>";
        }
		
		$query = "DELETE FROM new_tab1 WHERE id=7";//формируем строку с sql запросом
		mysql_query($query);//получаем результат его выполнения			

mysql_close();
?>
