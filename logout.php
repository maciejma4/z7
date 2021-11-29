<?php
	session_start();//rozpoczecie sesji
	session_unset();//zakonczenie sesji
	header('Location: index.php');//przeniesienie do pliku index.php czyli do logowania
?>