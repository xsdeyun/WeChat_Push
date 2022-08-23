# WeChat_Push
利用邮箱给女朋友、对象、朋友或者自己发送消息

## 打开邮箱官网申请SMTP 
我这里用的网易邮箱
开启SMTP服务 会给你一个密钥 复制出来
打开mail.php文件填写配置信息
![](https://s1.328888.xyz/2022/08/23/bzZLh.png)

![](https://s1.328888.xyz/2022/08/23/b74ZU.png)


## SMTP服务器配置信息填写
``` 
    //服务器配置
    $mail->CharSet ="UTF-8";                     //设定邮件编码
    $mail->SMTPDebug = 0;                        // 调试模式输出
    $mail->isSMTP();                             // 使用SMTP
    $mail->Host = '官方smtp地址';                // SMTP服务器
    $mail->SMTPAuth = true;                      // 允许 SMTP 认证
    $mail->Username = '你的邮箱';                // SMTP 用户名  发件人的邮箱 即邮箱的用户名
    $mail->Password = '密钥';             // SMTP 密码  部分邮箱是授权码(例如163邮箱)
    $mail->SMTPSecure = 'ssl';                    // 允许 TLS 或者ssl协议
    $mail->Port = 465;                            // 服务器端口 25 或者465 具体要看邮箱服务器支持

    $mail->setFrom('你的邮箱', '邮件主题');  //发件人
    $mail->addAddress($email,$name);  // 收件人

    $mail->addReplyTo('你的邮箱', 'info'); //回复的时候回复给哪个邮箱 建议和发件人一致

```

## 邮件发送消息配置

```
$email="收件人的邮箱"; //收件人的邮箱
$name="Hello 早上好..."; //收件人的姓名 
$title="今日份早安，请查收";//邮件标题
$city="成都";//天气城市
$tianhkey="";//天行数据key  去官网申请 官网地址https://www.tianapi.com/

恋爱天数  生日天数 填写
"loveday"=>getComputetime("2021-02-14"), //恋爱日期
"birthday1"=>getbirthdaytime("2022-12-28"), //生日1
"birthday2"=>getbirthdaytime("2023-05-02"), //生日2
```

## 定时发送
![](https://s1.328888.xyz/2022/08/23/bzlyr.png)
可以利用Linux的Corn或者宝塔的计划任务，反正只要每天能定时访问一次指定的地址即可。

指定地址：http://你的域名或者IP/index.php

## 效果预览
![](https://s1.328888.xyz/2022/08/23/b7Vcw.png)

