<?php
// header('Content-type: application/json');


$email="收件人邮箱"; //收件人的邮箱
$name="Hello 早上好..."; //收件人的姓名 
$title="今日份早安，请查收";//邮件标题
$city="成都";//天气城市
$tianhkey="";//天行数据key  去官网申请 官网地址https://www.tianapi.com/

echo postemail($email,$name,$title,$city);

function postemail($email,$name,$title,$city){
    $data=[
        "caihongpi"=>caihongpi(),
        "time"=>getDatetime(),
        "city"=>$city,
        "weather"=>getWeather($city)["dayText"],
        "maxTemp"=>getWeather($city)["high"],
        "minTemp"=>getWeather($city)["low"],
        "loveday"=>getComputetime("2022-03-14"),
        "birthday1"=>getbirthdaytime("2022-11-11"),
        "birthday2"=>getbirthdaytime("2023-11-11"),
        "note_en"=>cibawen()["content"],
        "note_ch"=>cibawen()["note"],
    ];
    $content = str_replace(['{{$caihongpi}}','{{$time}}','{{$city}}','{{$weather}}','{{$maxTemp}}','{{$minTemp}}','{{$loveday}}','{{$birthday1}}','{{$birthday2}}','{{$note_en}}','{{$note_ch}}'],$data,file_get_contents('template/dat.tpl'));
     $post_data = array(
      'email' => $email,
      'name' => $name,
      'title' => $title,
      'content' => $content,
    );
    return Curl_Post('http://file.qingyunjian.cn/email/mail.php', $post_data);
}

// 词霸 每日句子
function cibawen(){
    $ciba=json_decode(Curl("http://open.iciba.com/dsapi/"),true);
    return $ciba;
}


// 彩虹屁文案
function caihongpi(){
    $caihongpi=json_decode(Curl("http://api.tianapi.com/caihongpi/index?key=f95705018076647e52821565ef3292ef"),true);
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