<?php require_once "session_check.php";

function removeDir($path) {
	$dir = new DirectoryIterator($path);
	foreach ($dir as $fileinfo) {
		if ($fileinfo->isFile() || $fileinfo->isLink()) {
			unlink($fileinfo->getPathName());
		} elseif (!$fileinfo->isDot() && $fileinfo->isDir()) {
			removeDir($fileinfo->getPathName());
		}
	}
	rmdir($path);
}

$katalog = $_GET["name"];;
removeDir($katalog);
print'Usunieto:'.$_GET["name"];

header("refresh:2;url=index.php" );
?>

