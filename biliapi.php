<?php
/*
 * @Author: McShin team
 * © 2021-2021 McShin team. All rights reserved.
*/
header('Content-Type:application/json');
header("Access-Control-Allow-Origin: *");
$aid = $_GET["aid"];
$sort = $_GET["mode"];
$uid = $_GET["uid"];
$uidnull = empty($uid);
if (!isset($_GET["uid"])){
    if (!isset($_GET["mode"])){
    $bilijson = file_get_contents("https://api.bilibili.com/x/v2/reply/main?jsonp=jsonp&next=0&type=1&oid={$aid}&mode=1");
    }else{
        $bilijson = file_get_contents("https://api.bilibili.com/x/v2/reply/main?jsonp=jsonp&next=0&type=1&oid={$aid}&mode={$sort}");
    }
} else{
	$video_json = file_get_contents("https://api.bilibili.com/x/space/arc/search?mid={$uid}&ps=30&tid=0&pn=1&keyword=&order=pubdate&jsonp=jsonp");
	$video_json = json_decode($video_json , true ,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	$aid = $video_json['data']['list']['vlist'][0]['aid'];
	if (!isset($_GET["mode"])){
    $bilijson = file_get_contents("https://api.bilibili.com/x/v2/reply/main?jsonp=jsonp&next=0&type=1&oid={$aid}&mode=1");
    }else{
        $bilijson = file_get_contents("https://api.bilibili.com/x/v2/reply/main?jsonp=jsonp&next=0&type=1&oid={$aid}&mode={$sort}");
    }
}
$bilijson = str_replace('\n', '<br />', $bilijson);
$json_obj = json_decode($bilijson , true ,JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
if ($json_obj['code'] == '-400'){
    echo("{\n");
    echo("\"error\":");
    echo ("\"".$json_obj['code']."\"\n");
    echo("}");
}else{
  for ($i = 0; $i <= 20; $i++) {
  	$a = $i + 1;
  	$isnull = empty($json_obj['data']['replies'][$a]['member']['mid']);
  	if ($i == 0){
  	    echo("[{\n");
  	}else{
  	echo("{\n");
  	}
  	echo("\"mid\":");
  	echo ("\"".$json_obj['data']['replies'][$i]['member']['mid']."\",\n");
  	echo("\"uname\":");
  	echo ("\"".$json_obj['data']['replies'][$i]['member']['uname']."\",\n");
  	echo("\"avatar\":");
  	echo ("\"".$json_obj['data']['replies'][$i]['member']['avatar']."\",\n");
  	echo("\"message\":");
  	echo ("\"".$json_obj['data']['replies'][$i]['content']['message']."\",\n");
  	$time = date('Y-m-d h:i:s',$json_obj['data']['replies'][$i]['ctime']);
  	echo("\"ctime\":");
  	echo ("\"".$time."\"\n");
  	if ($isnull) {
  		echo("}]");
  		break;
  	} else {
  		echo("},");
  	}
  }
}
?>