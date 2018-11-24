<html>

<?php

class db_operation{
	private $def_usr_name="pma";
	private $def_host_name="localhost";
	private $def_db_name="test";
	private $def_table_name="new_tab1";
	private $query="SELECT * FROM new_tab1";
	private $db;//=mysql_connect($def_db_name, $def_host_name, "");
	
	public function assoc_db($usr_name,$host_name,$db_name)
	{
		$db=mysql_connect($usr_name, $host_name, "") or die("Could connect mysql");
		mysql_select_db($db_name) or die("Could not select database");
	}
	
	public function create_tbl($table_name,$var_array,$only_text)
	{
		$query="CREATE TABLE".$table_name."AS(".$var_array.")";
		if ($only_text) echo $query; else mysql_query($query);
	}
	
	public function drop_tbl($table_name,$only_text)
	{
		$query="DROP TABLE".$table_name;
		if ($only_text) echo $query; else mysql_query($query);
	}
	
	public function ins_val($table_name,$var_array,$only_text)
	{
		$query="INSERT INTO ".$table_name." VALUES ".$var_array;
		if ($only_text) echo $query; else mysql_query($query);
	}
	
	public function del_val($table_name,$var_array,$only_text)
	{
		$query="DELETE FROM ".$table_name." WHERE ".$var_array;
		if ($only_text) echo $query; else mysql_query($query);
	}	
	
	public function out_table_inf($table_name,$var_array,$only_text)
	{
		$query = "SELECT * FROM ".$table_name." WHERE ".$var_array;
        if ($only_text) echo $query; else $result=mysql_query($query);
        if (!$result) die("bad sql");
        print "\n";
        while ($line = mysql_fetch_row($result)) 
            {
			print "||";
			foreach ($line as $col_value) {print $col_value."||";}
			print "<br>";
			}
	}
	
	public function close_db_conn()
	{
		mysql_close();
	}	
}

$db_op=new db_operation();
$db_op->assoc_db("localhost","pma","test");
$db_op->out_table_inf("new_tab1","id=5",false);
$db_op->close_db_conn();
?>
