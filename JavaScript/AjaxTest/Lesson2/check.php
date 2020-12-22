<?php
	sleep(1);
	if ($_POST['name'] == "Admin")
		echo "Fail";
	else
		echo $_POST['name']." - Success";
?> 