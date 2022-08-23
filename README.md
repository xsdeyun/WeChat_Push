# WeChat_Push
利用微信公众号给女朋友、对象、朋友或者自己发送消息

## 登录微信公众平台测试号申请地址
https://mp.weixin.qq.com/debug/cgi-bin/sandbox?t=sandbox/login
![](https://s1.328888.xyz/2022/08/23/byzfp.png)

## 填写配置信息
![](https://s1.328888.xyz/2022/08/23/byq1y.png)
![](https://s1.328888.xyz/2022/08/23/bzjAk.png)
将从微信公众平台获取到的Token、appid、secret、template_id填写到代码里面中。
在代码中填写对应的日期
``` 
$appid="";   // 公众号 appid
$secret=""; // 公众号 secret
$touser="";  // 用户 touser
$template_id=""; //模板 id
$tianhkey="";//天行数据key  去官网申请 官网地址https://www.tianapi.com/
$city="成都";// 天气城市

```

## 模板代码
{{date.DATA}} 
{{pipi.DATA}} 

城市：{{city.DATA}} 
天气：{{weather.DATA}} 
最低气温: {{min_temperature.DATA}}
最高气温: {{max_temperature.DATA}} 
今日建议：{{tips.DATA}} 
今天是我们恋爱的第{{love_day.DATA}}天 
距离小宝生日还有{{birthday1.DATA}}天 
距离我的生日还有{{birthday2.DATA}}天

{{note_en.DATA}} 
{{note_ch.DATA}}

## 定时发送
![](https://s1.328888.xyz/2022/08/23/bzlyr.png)
可以利用Linux的Corn或者宝塔的计划任务，反正只要每天能定时访问一次指定的地址即可。

指定地址：http://你的域名或者IP/index.php


