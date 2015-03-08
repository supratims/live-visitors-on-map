<?php

//return live visitors from the ga super proxy
//url response format
//{'kind': 'analytics#realtimeData', 'rows': [['Glasgow', '55.864235', '-4.251806', '1']], 'totalResults': 1 ...}
function get_live_visitors(&$error){
	$url='INSERT YOUR OWN URL HERE';
	//echo $url.PHP_EOL;
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPGET, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    		'Content-Type: application/json',
    		'Accept: application/json'
	));
	$response=curl_exec($ch);
	$retcode=curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	if ($retcode!=200){
		$error=json_decode($response,true,10);
	}
	else {
		$result=json_decode($response,true,10);
		//echo $result['rows'];
		return $result['rows'];
	}
}
$errors='';
$result=get_live_visitors($errors);
if (!empty($errors)) {
	//var_dump($errors);
	echo json_encode($errors);
}
else {
	$formatted_resp=[];
	foreach($result as $res){
		$formatted_resp[$res[0]]=[$res[0],$res[1],$res[2],$res[3]];
	}
	echo json_encode($formatted_resp);
}


