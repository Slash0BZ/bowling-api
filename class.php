<?php
class user{


static public function http_get_data($url, $customHeader){
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

static public function http_post_data($url, $data_string, $customHeader) {  
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

static public function http_put_data($url, $data, $customHeader){
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

static public function showLeague($token){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues";
	list($return_code, $return_content) = user::http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);
	return $retList;
}

static public function createLeague($token, $name){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues";
	$dataset = json_encode(array("name"=>$name));
	list($return_code, $return_content) = user::http_post_data($requestUrl, $dataset, $token);
	$retList = json_decode($return_content);
	return $retList;
}	

static public function getOneLeague($token, $lid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid;
	list($return_code, $return_content) = user::http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}

static public function createBowler($token, $name){
	$requestUrl = "http://bowling-api.nextcapital.com/api/bowlers";
	$dataset = json_encode(array("name"=>$name));
	list($return_code, $return_content) = user::http_post_data($requestUrl, $dataset, $token);
	$retList = json_decode($return_content);
	return $retList;
}

static public function getBowler($token){
	$requestUrl = "http://bowling-api.nextcapital.com/api/bowlers";
	list($return_code, $return_content) = user::http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}

static public function getOneBowler($token, $bid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/bowlers/".$bid;
	list($return_code, $return_content) = user::http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}

static public function addBowler($token, $bid, $lid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/bowlers";
	$dataset = json_encode(array("bowler_id"=>$bid));
	list($return_code, $return_content) = user::http_put_data($requestUrl, $dataset, $token);
	$retList = json_decode($return_content);
	return $retList;
}

static public function showBowler($token, $lid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/bowlers";
	list($return_code, $return_content) = user::http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}	

static public function showLottery($token, $lid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/lotteries";
	list($return_code, $return_content) = user::http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}

static public function buyTicket($token, $lid, $lotteryid, $bid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/lotteries/".$lotteryid."/tickets";
	$dataset = json_encode(array("bowler_id"=>$bid));
	list($return_code, $return_content) = user::http_post_data($requestUrl, $dataset, $token);
	$retList = json_decode($return_content);
	return $retList;
}

static public function showTicket($token, $lid, $lotteryid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/lotteries/".$lotteryid."/tickets";
	list($return_code, $return_content) = user::http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}

static public function drawTicket($token, $lid, $lotteryid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/lotteries/".$lotteryid."/roll";
	list($return_code, $return_content) = user::http_get_data($requestUrl, $token);
	$retList = json_decode($return_content);	
	return $retList;
}

static public function recordRoll($token, $lid, $lotteryid, $pin_count){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/lotteries/".$lotteryid."/roll";
	$dataset = json_encode(array("pin_count"=>$pin_count));
	list($return_code, $return_content) = user::http_put_data($requestUrl, $dataset, $token);
	$retList = json_decode($return_content);
	return $retList;
}

static public function recordTicket($token, $lid, $ltid){
	$requestUrl = "http://bowling-api.nextcapital.com/api/leagues/".$lid."/lotteries/".$ltid."/roll/";
	$dataset = json_encode(array("pin_count"=>$_SESSION['pin_count']));
	list($return_code, $return_content) = user::http_put_data($requestUrl, $dataset, $token);
	$retList = json_decode($return_content);
	return $retList;
}

}

?>
