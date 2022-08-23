<?php

// 模板
// {{date.DATA}} 
// {{pipi.DATA}} 

// 城市：{{city.DATA}} 
// 天气：{{weather.DATA}} 
// 最低气温: {{min_temperature.DATA}}
// 最高气温: {{max_temperature.DATA}} 
// 今日建议：{{tips.DATA}} 
// 今天是我们恋爱的第{{love_day.DATA}}天 
// 距离小宝生日还有{{birthday1.DATA}}天 
// 距离我的生日还有{{birthday2.DATA}}天

// {{note_en.DATA}} 
// {{note_ch.DATA}}


$appid="wxd460dc747824b5d9";   // 公众号 appid
$secret="bd2dce7b0786ae4c75de88273f6c9a9d"; // 公众号 secret
$touser="obmB75jc_GTn9LiV8oA8MQZY07CQ";  // 用户 touser
$template_id="-YwzhNSJMes8MaMkT9QQ9fX5cEmk1mrUAVse2O8KM1g"; //模板 id
$tianhkey="";
$city="成都";// 天气城市

$postData=postweixin($appid,$secret,$touser,$template_id,$city,$tianhkey);
$jsonData=json_decode($postData,true);
if($jsonData["errcode"]==0){
    echo json_encode(["code"=>200,"msg"=>"推送成功！"]);
}else {
    echo json_encode(["code"=>200,"msg"=>"推送失败！"]);
}

function postweixin($appid,$secret,$touser,$template_id,$city,$tianhkey){
    $token_url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
    $access_token=json_decode(Curl($token_url),true)["access_token"];
    $tep_url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
    $data=[
        "touser"=>$touser,
        "template_id"=>$template_id,
        "url"=>"http://weixin.qq.com/download",
        "topcolor"=>"#FF0000",
        "data"=>[
            
            "date"=>[ 
                "value"=>getDatetime(),
                "color"=>randColor()
            ],
            "pipi"=>[
                "value"=>caihongpi($tianhkey),
                "color"=>randColor()
            ],
            "city"=>[ 
                "value"=>$city,
                "color"=>randColor()
            ],
            "weather"=>[
                 "value"=>getWeather($city)["dayText"],
                 "color"=>randColor()
            ],
            "min_temperature"=>[
                "value"=>getWeather($city)["low"],
                 "color"=>randColor()
            ],
            "max_temperature"=>[
                "value"=>getWeather($city)["high"],
                 "color"=>randColor()
            ],
            "tips"=>[
                 "value"=>"今日建议",
                 "color"=>randColor()
            ],
            "love_day"=>[
                "value"=>getComputetime("2022-06-07"),
                "color"=>randColor() 
            ],
            "birthday1"=>[
                "value"=>getbirthdaytime("2022-11-11"),
                "color"=>randColor() 
            ],
            "birthday2"=>[
                "value"=>getbirthdaytime("2023-01-01"),
                "color"=>randColor() 
            ],
            "note_en"=>[
                "value"=>cibawen()["content"],
                "color"=>randColor() 
            ],
            "note_ch"=>[
                "value"=>cibawen()["note"],
                "color"=>randColor() 
            ]
        ]
    ];
    
    return Curl_Post($tep_url,json_encode($data,true)); 
}

// 词霸 每日句子
function cibawen(){
    $ciba=json_decode(Curl("http://open.iciba.com/dsapi/"),true);
    return $ciba;
}


// 彩虹屁文案
function caihongpi($tianhkey){
    $caihongpi=json_decode(Curl("http://api.tianapi.com/caihongpi/index?key=$tianhkey"),true);
    return $caihongpi["newslist"][0]["content"];
}

// 天气请求

function getWeather($city){
    $ID=json_decode(Curl("https://weather.cma.cn/api/autocomplete?q=".urlencode($city)),true);
    $Info=explode("|",$ID['data'][0])[0];
    $weather=json_decode(Curl("https://weather.cma.cn/api/weather/$info"),true);
    return $weather["data"]["daily"][0];
}

// 今日时间
function getDatetime(){
    $date=date("Y-m-d");
    $weekarray=array("日","一","二","三","四","五","六"); 
    $week="  星期".$weekarray[date("w")];
    return $date.$week;
}

// 时间计算
function getComputetime($time){
    $time1=strtotime($time); 
    $time2=strtotime(date("Y-m-d"));
    $diff_seconds = $time2 - $time1;
    $diff_days = $diff_seconds/86400;
    return $diff_days;
}
// 生日计算
function getbirthdaytime($time){
    $time1=strtotime($time); 
    $time2=strtotime(date("Y-m-d"));
    $diff_seconds = $time1 - $time2;
    $diff_days = $diff_seconds/86400;
    return $diff_days;
}

// 随机颜色
function randColor(){
   $colors = array();
   for($i = 0;$i<6;$i++){
       $colors[] = dechex(rand(0,15));
   }
   return '#'.implode('',$colors);
} 

//CURL
function Curl($url) {
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$data = curl_exec($curl);
	curl_close($curl);
	return $data;
}

//POST提交
function Curl_Post($remote_server, $post_string) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $remote_server);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'xsdeyun');
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}

?>
