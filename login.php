<?php require_once "session_check.php";
?>
<!DOCTYPE HTML>
<html lang="pl">

<head>
	<meta charset="utf-8" />
	<title>Markowicz z7 - panel uzytkownika</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<link id="pagestyle" rel="stylesheet" href="style1.css" type="text/css" />
</head>

<body>

<div id="container">
		<div  style="text-align:right;width:1000px;">
			<a href="logout.php">wyloguj</a>
		</div>
		<div  class="rectangle" style="text-align:center;">
<?php
	require_once "connect.php";
	$id=$_SESSION['id'];
	$result = mysqli_query($connection, "SELECT * FROM users WHERE id='$id'")
					or die ("Błąd zapytania: $db_name");
	$db_raw = mysqli_fetch_array($result);
	echo '<h1>Witaj '.$db_raw['username'].'!</h1>';
	$me=$db_raw['username'];	
	
	$rezultat = mysqli_query($connection, "SELECT * FROM loginerror ORDER BY id DESC LIMIT 1");
	while ($wiersz = mysqli_fetch_array ($rezultat)) {
			$id = $wiersz[0];
			$uzytkownik = $wiersz[1];
			$datagodzina = $wiersz[2];
	}
	echo 'Twoje ostatnie błędne logowanie było: ';
	print $datagodzina;	
	echo '</br></br>';
?>
		</div>
		
		<div style="text-align:left;border: 5px solid  red;padding:5px;">
		<h3>Twoje pliki i foldery:</h3>
<?php
if(!$path){
	$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "z7/";
$path .= $me;
$down .= $me;
}	
	$down .=$_GET['id'];
	$path.=$_GET['id'];

if ($dir = scandir($path)) {
	echo '<ul>';
	$y=$path."/..";
	if($x = scandir($y)){
			if(in_array($me,$x)){
				foreach($dir as $file){
					if($file != '.' && $file != '..'){
						if(count(explode(".",$file)) == 1){
							echo '<li><a href="login.php?id='.$_GET['id'].'/'.$file.'">'.$file.'</a><a href="removedir.php?name='.$path.'/'.$file.'">USUN FOLDER </a></li>'; //TU SPRAWDZIC
							echo '</br>';
						}else{
							echo '<li><a href="'.$down.'/'.$file.'" download>'.$file.'</a> <a href="removefile.php?name='.$me.'/'.$file.'">USUN PLIK </a>';
							echo '</li>';
							/**echo '<li><a href="'.$_GET['id'].'/'.$file.'" download>'.$file.'</a></li>';*/
							/**echo '<li><a href="login.php?id='.$_GET['id'].'/'.$file.'">'.$file.'</a></li>';*/
							echo '</br>';
							}
					}
				}
				echo '</ul>';
			}else{
				foreach($dir as $file){
						if(((count(explode(".",$file))) == 1)||($file == '.')||($file == '..')){
							echo '<li><a href="login.php?id='.$_GET['id'].'/'.$file.'">'.$file.'</a><a href="removedir.php?name='.$path.'/'.$file.'">USUN FOLDER </a></li>'; //TU SPRAWDZIC 
							echo '</br>';
						}else{
							echo '<li><a href="'.$down.'/'.$file.'" download>'.$file.'</a><a href="removefile.php?name='.$down.'/'.$file.'">USUN PLIK </a> </li>';
							echo '</br>';
						}
				}
				echo '</ul>';
			}
	}
}else{
echo'no cos poszlo nie tak';
}
?>	
		</div>
		<div style="float:left;padding:10px;">
		<h1>Dodawanie folderu:</h1>
			<form method="post">
				Nazwa folderu:<br/>
				<input type="text" name="dirname"><br/>
				<input type="submit" value="Dodaj katalog" name="folder"><br/>
			</form>
<?php	
		if(isset($_POST['folder'])){
			$variable.=$path;
			$variable.="/";
			$variable.=$_POST['dirname'];
			if(!file_exists($variable)){
			mkdir("$variable");
			echo("<meta http-equiv='refresh' content='1'>");
			}else{
				echo '</br>';
			echo 'Folder o takiej nazwie już istnieje!';}
		}
?>	
		</div>
	
		<div style="float:right;padding:10px;">
		<h1>Dodawanie pliku:</h1>
			<form method="POST" ENCTYPE="multipart/form-data">
				<input type="file" name="plik"/>
				<input type="submit" value="Wyślij plik"/>
			</form>
<?php 
			if (is_uploaded_file($_FILES['plik']['tmp_name'])) { 
				echo 'Odebrano plik: '.$_FILES['plik']['name'].'<br/>';
				move_uploaded_file($_FILES['plik']['tmp_name'],
				"$path/".$_FILES['plik']['name']);
				echo("<meta http-equiv='refresh' content='2'>");
			} 
?>
		</div>
		<div style="clear:both;"></div>	
</div>
</body>
</html>