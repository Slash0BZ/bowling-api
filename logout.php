<?php
session_start();
if ($_GET['type'] == NULL){
	session_destroy();
	Header("Location:./index.php");
}
if ($_GET['type'] == "leagueID"){
	$_SESSION['leagueID'] = NULL;
	Header("Location:./welcome.php");
}


?>
