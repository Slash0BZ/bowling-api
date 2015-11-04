<?php
include './class.php';
session_start();

if ($_GET['type'] == 'setleagueID'){
	if ($_POST['league'] != NULL){
		$_SESSION['leagueID'] = $_POST['league'];
		echo $_SESSION['leagueID'];
		Header("Location:./welcome.php");
	}
	else if($_POST['leagueName'] != NULL){
		$ret = user::createLeague($_SESSION['token'], $_POST['leagueName']);
		if ($retList->name == $_POST['leagueName'])	$_SESSION['leagueID'] = $ret->id;
		else echo "Error Occurred When Creating New League\n";
		echo $_SESSION['leagueID'];
		Header("Location:./welcome.php");
	}
}

if ($_GET['type'] == 'createBowler'){
	if($_POST['bowlerName'] != NULL){
		$ret = user::createBowler($_SESSION['token'], $_POST['bowlerName']);
		if ($ret->name != NULL){
			Header("Location:./welcome.php");
		}
	}
}

if ($_GET['type'] == 'addBowler'){
	user::addBowler($_SESSION['token'], $_POST['bowlerN'], $_SESSION['leagueID']);
	Header("Location:./welcome.php");
}

if ($_GET['type'] == 'buyTicket'){
	$lotteryID = user::showLottery($_SESSION['token'], $_SESSION['leagueID']);
	$lotteryID = end($lotteryID)->id;
	user::buyTicket($_SESSION['token'], $_SESSION['leagueID'], $lotteryID, $_POST['bowlerL']);
	Header("Location:./welcome.php");
}

if ($_GET['type'] == 'draw'){
	$lotteryID = user::showLottery($_SESSION['token'], $_SESSION['leagueID']);
	$lotteryID = end($lotteryID)->id;
	$retInfo = user::drawTicket($_SESSION['token'], $_SESSION['leagueID'], $lotteryID);
	user::recordRoll($_SESSION['token'], $_SESSION['leagueID'], $lotteryID, $_SESSION['pin_count']);
	$_SESSION['pin_count'] = $_SESSION['pin_count'] + 1;
	$message = "Location:./welcome.php?winning_id=861&lottery_id=".$retInfo->lottery_id;
	if ($retInfo->error != NULL)
		$message = "Location:./welcome.php?winning_id=861&error=".$retInfo->error;
	Header($message);
}

?>
