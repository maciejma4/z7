<?php           
	session_start();
	if ((isset($_SESSION['loggedin'])) && ($_SESSION['loggedin']==true))
	{
		echo "<script>window.location.href='login.php';</script>";
		exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>Markowicz Z7 - logowanie</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link id="pagestyle" rel="stylesheet" href="style1.css" type="text/css" />
</head>

<body>
	<div id="container">
<form method="post">
	Nazwa użytkownika:<br>
	<input type="text" name="username" >
	<br>
	Hasło:<br>
	<input type="password" name="password" >
	<br>
	<input type="submit" value="Zaloguj">
</form> 
</br><a href="rejestracja.php">Rejestracja</a></br>
<?php
	if ((isset($_POST ['username'])) && (isset($_POST ['password'])))
	{
		$username = $_POST ['username']; 
		$password = $_POST ['password'];
		require_once "connect.php";	
		
		$result_1 = mysqli_query($connection, "SELECT * FROM users WHERE username='$username'")
					or die ("Błąd zapytania: $db_name");
		$db_raw = mysqli_fetch_array($result_1);
		if(!$db_raw)												
		{
			mysqli_query($connection, "INSERT INTO loginerror (user) VALUES ('$username')") or die ("Błąd zapisu. Nie udało się zapisać!");
			mysqli_close($connection);
			echo "Niepoprawna nazwa użytkownika lub hasło!";
		}
		else
		{
			if($db_raw['password']==$password)
			{
				$_SESSION ['loggedin'] = true;
				$_SESSION ['id']  = $db_raw ['id'];
				
				mysqli_close($connection);
				echo "<script>window.location.href='login.php';</script>";
			}
			else
			{
				mysqli_query($connection, "INSERT INTO loginerror (user) VALUES ('$username')") or die ("Błąd zapisu. Nie udało się zapisać!");
				mysqli_close($connection);
				echo "Niepoprawna nazwa użytkownika lub hasło!";	
			}
		}
	}
?>	
	</div>
</body>
</html>