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
	
	<title>Markowicz z7 - rejestracja </title>
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
	Powtórz hasło:<br>
	<input type="password" name="repeat_password" >
	<br>
	<input type="submit" value="Zarejestruj" name="button">
</form> 

<br><a href="index.php">Strona główna.</a></br>

<?php
if(isset($_POST['button'])){
	if(($_POST['username']!= null)&&($_POST['password']!=null)&&($_POST['repeat_password']!=null)){
		if(((strlen($_POST['username']))> 3)&&((strlen($_POST['username']))< 15)){
			$username=$_POST['username'];
			require_once "connect.php";	
			$matching = mysqli_query($connection, "SELECT * FROM users WHERE username='$username'") or die ("Błąd zapytania: $db_name");
			if(mysqli_fetch_array($matching)){
				echo '<font color="red">Istnieje już użytkownik o takiej nazwie!</font>';
			}else{
				if($_POST ['password']==$_POST ['repeat_password']){
					$password = $_POST['password'];
					mysqli_query($connection, "INSERT INTO users (id,username,password) VALUES ('','$username','$password')") or die ("Błąd zapisu. Nie udało się zarejestrować!");
					mysqli_close($connection);
					mkdir("$username");
					echo '<font color="green">Rejestracja przebiegła pomyślnie!</font>'; 
				}else{
					echo '<font color="red">Hasła nie są identyczne!</font>';
				}
			}
		}else{
			echo '<font color="red">Nazwa użytkownika powinna zawierać od 4 do 14 znaków!</font>';
		}
	}else{
		echo'<font color="red">Uzupełnij wszystkie pola!</font>';
	}
}

?>
	
	</div>
</body>
</html>