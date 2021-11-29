<?php
	//plik wymagany do łączenia się z bazą danych
	$db_host	 = "mysql01.maciejma4.beep.pl";
	$db_user 	 = "zad7";
	$db_password = "zadanie7";
	$db_name 	 = "z7-z7";
	$connection = mysqli_connect ($db_host, $db_user, $db_password, $db_name);
	if (!$connection) 
	{
		echo "MySQL connection problem. " . PHP_EOL;
		echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
		echo "Error: " . mysqli_connect_error() . PHP_EOL;
		exit;
	}
?>