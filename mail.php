
<?php
$email=$_POST["email"];
$name=$_POST["name"];
$title=$_POST["title"];
$content=$_POST["content"];


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailermaster/src/Exception.php';
require 'PHPMailermaster/src/PHPMailer.php';
require 'PHPMailermaster/src/SMTP.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
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


    

    //Content
    $mail->isHTML(true);                                
    // 是否以HTML文档格式发送  发送后客户端可直接显示对应HTML内容
    $mail->Subject = $title;
    $mail->Body    = $content;

    $mail->send();
    echo json_encode(["code"=>200,"msg"=>"发送成功"]);
} catch (Exception $e) {
    echo json_encode(["code"=>300,"msg"=>"邮件发送失败!","log"=>$mail->ErrorInfo]);
}

?>


