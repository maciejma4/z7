<?php require_once "session_check.php";
$plik = $_GET["name"];
unlink($plik);
print'Usunieto:'.$_GET["name"];
header("refresh:2;url=index.php" );
?>

