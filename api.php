<?php
session_start();
if ($_GET['type'] == 'login'){
	if (checkLogin($_POST['email'], $_POST['password']) == 1){
		$_SESSION['token'] = base64_encode($_POST['email'].":".$_POST['password']);
		$_SESSION['pin_count'] = 1;
		HEADER("Location:./index.php");
		}
	else{
		echo "fail";
	}
}
else if ($_GET['type'] == 'signup'){
	if ($_POST['spassword'] == $_POST['srepassword']){
		echo "signup process";
		if (signup($_POST['semail'], $_POST['spassword']) == 1){
			echo "Success!\n";
			echo "<a href='./index.php'>Main Page</a>\n";
		}
		else{
			echo "This Email Address is invalid.\n";
		}
	}
	else{
		echo "Passwords do not match\n";
	}
}
else if ($_GET['type'] == 'createLeague'){
	if (createLeague($_SESSION['token'], $_POST['leagueName']) == 1){
		echo "successfully created\n";
	}
	else {
		echo "Error\n";
	}
}
else if ($_GET['type'] == 'getLeague'){
	$ret = showLeague($_SESSION['token']);
	print_r($ret);
}
else if ($_GET['type'] == "getOneLeague"){
	$ret = getOneLeague($_SESSION['token'], $_POST['leagueID']);
	print_r($ret);
}
else if ($_GET['type'] == "createBowler"){
	if (createBowler($_SESSION['token'], $_POST['bowlerName']) == 1){
		echo "successfully created\n";
	}
	else {
		echo "Error\n";
	}
}
else if ($_GET['type'] == 'getBowler'){
	$ret = getBowler($_SESSION['token']);
	print_r($ret);
}
else if ($_GET['type'] == "getOneBowler"){
	$ret = getOneBowler($_SESSION['token'], $_POST['BowlerID']);
	print_r($ret);
}
else if ($_GET['type'] == "addBowler"){
	$ret = addBowler($_SESSION['token'], $_POST['aBowlerID'], $_POST['aLeagueID']);
	print_r($ret);
}
else if ($_GET['type'] == 'showBowlerInLeague'){
	$ret = showBowler($_SESSION['token'], $_POST['sLeagueID']);
	print_r($ret);
}
else if ($_GET['type'] == 'showLottery'){
	$ret = showLottery($_SESSION['token'], $_POST['ssLeagueID']);
	print_r($ret);
}
else if ($_GET['type'] == 'buyTicket'){
	$ret = buyTicket($_SESSION['token'], $_POST['blid'],$_POST['bltid'], $_POST['bbid']);
	print_r($ret);
}
else if ($_GET['type'] == 'showTicket'){
	$ret = showTicket($_SESSION['token'], $_POST['sslid'],$_POST['ssltid']);
	print_r($ret);
}
else if ($_GET['type'] == 'drawTicket'){
	$ret = drawTicket($_SESSION['token'], $_POST['dlid'],$_POST['dltid']);
	recordTicket($_SESSION['token'], $_POST['dlid'], $_POST['dltid']);
	$_SESSION['pin_count'] = $_SESSION['pin_count'] + 1;	
	print_r($ret);
}


function http_post_data($url, $data_string, $customHeader) {  
            $ch = curl_init();  
            curl_setopt($ch, CURLOPT_POST, 1);  
            curl_setopt($ch, CURLOPT_URL, $url);  
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);  
	if ($customHeader == NULL){
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
                'Content-Type: application/json; charset=utf-8',  
                'Content-Length: ' . strlen($data_string))  
            );  
	}
	else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(  
                'Content-Type: application/json; charset=utf-8',  
                'Authorization: '.$customHeader,  
                'Content-Length: ' . strlen($data_string))  
            );  
	}
	
            ob_start();  
            curl_exec($ch);  
            $return_content = ob_get_contents();  
            ob_end_clean();  
      
            $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
            return array($return_code, $return_content);  
}

function http_get_data($url, $customHeader){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json; charset=utf-8',
		'Authorization: '.$customHeader)
	);
	ob_start();
	curl_exec($ch);
	$return_content = ob_get_contents();
	ob_end_clean();

	$return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	return array($return_code, $return_content);
}

function http_put_data($url, $data, $customHeader){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json; charset=utf-8',
		'Authorization: '.$customHeader)
	);
	ob_start();
	curl_exec($ch);
	$return_content = ob_get_contents();
	ob_end_clean();

	$return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	return array($return_code, $return_content);
}

function checkLogin($email, $password){	
    $loginUrl = "http://bowling-api.nextcapital.com/api/login/";
    $data = json_encode(array());   
    $token = base64_encode($email.":".$password);
    list($return_code, $return_content) = http_post_data($loginUrl, $data, $token);  
    $retList = json_decode($return_content);
    if ($retList->id != NULL && $retList->email != NULL) return 1;
    else return 0;

}

function signup($email, $password){
	$requestUrl = "http://bowling-api.nextcapital.com/api/users";
	$dataset = json_encode(array("email"=>$email, "password"=>$password));
	list($return_code, $return_content) = http_post_data($requestUrl, $dataset, NULL);
	$retList = json_decode($return_content);
	if ($retList->email == $email && $retList->id != NULL){
		return 1;
	}
	else {
		return 0;
	}
}

function createLeague($token, $name){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues";
	$dataset = json_encode(array("name"=>$name));
	list($return_code, $return_content) = http_post_data($requestUrl, $dataset, $token);
	$retList = json_decode($return_content);
	print_r($retList);
	if ($retList->name == $name && $retList->id != NULL){
		return 1;
	}
	else {
		return 0;
	}
}	

function showLeague($token){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues";
	list($return_code, $return_content) = http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}

function getOneLeague($token, $lid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid;
	list($return_code, $return_content) = http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}

function createBowler($token, $name){
	$requestUrl = "http://bowling-api.nextcapital.com/api/bowlers";
	$dataset = json_encode(array("name"=>$name));
	list($return_code, $return_content) = http_post_data($requestUrl, $dataset, $token);
	$retList = json_decode($return_content);
	print_r($retList);
	if ($retList->name == $name && $retList->id != NULL){
		return 1;
	}
	else {
		return 0;
	}
}

function getBowler($token){
	$requestUrl = "http://bowling-api.nextcapital.com/api/bowlers";
	list($return_code, $return_content) = http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}	

function getOneBowler($token, $bid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/bowlers/".$bid;
	list($return_code, $return_content) = http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}

function addBowler($token, $bid, $lid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/bowlers";
	$dataset = json_encode(array("bowler_id"=>$bid));
	list($return_code, $return_content) = http_put_data($requestUrl, $dataset, $token);
	$retList = json_decode($return_content);
	print_r($retList);
	return $retList;
}

function showBowler($token, $lid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/bowlers";
	list($return_code, $return_content) = http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}	

function showLottery($token, $lid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/lotteries";
	list($return_code, $return_content) = http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}

function buyTicket($token, $lid, $lotteryid, $bid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/lotteries/".$lotteryid."/tickets";
	$dataset = json_encode(array("bowler_id"=>$bid));
	list($return_code, $return_content) = http_post_data($requestUrl, $dataset, $token);
	$retList = json_decode($return_content);
	return $retList;
}

function showTicket($token, $lid, $lotteryid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/lotteries/".$lotteryid."/tickets";
	list($return_code, $return_content) = http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}

function drawTicket($token, $lid, $lotteryid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/lotteries/".$lotteryid."/roll";
	list($return_code, $return_content) = http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}

function recordRoll($token, $lid, $lotteryid, $pin_count){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/lotteries/".$lotteryid."/roll";
	$dataset = json_encode(array("pin_count"=>$pin_count));
	list($return_code, $return_content) = http_put_data($requestUrl, $dataset, $token);
	$retList = json_decode($return_content);
	print_r($retList);
	return $retList;
}

function recordTicket($token, $lid, $ltid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/lotteries/".$ltid."/roll/";
	$dataset = json_encode(array("pin_count"=>$_SESSION['pin_count']));
	list($return_code, $return_content) = http_put_data($requestUrl, $dataset, $token);
	$retList = json_decode($return_content);
	print_r($retList);
	return $retList;
}
		

	

?>
