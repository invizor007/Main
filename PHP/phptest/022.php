<?php
$db=mysql_connect("localhost", "pma", "") or die("Could connect mysql");//соединение с БД, параметры стандартные
mysql_select_db("test") or die("Could not select database");//выбор базы данных
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

mysql_close();
?>
