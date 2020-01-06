<?php
header("content-type:text/html;charset=utf-8");
ini_set("magic_quotes_runtime",0);
require 'class.phpmailer.php';
require 'class.smtp.php';

function send_mail($to,$fromname,$title,$content){
    try {
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->CharSet='UTF-8'; //设置邮件的字符编码，这很重要，不然中文乱码
        $mail->SMTPAuth = true; //开启认证
        $mail->Port = 25; //端口请保持默认
        $mail->Host = "smtp.163.com"; //使用QQ邮箱发送
        $mail->Username = "17010057955@163.com"; //这个可以替换成自己的邮箱
        $mail->Password = "WangLin123456"; //注意 这里是写smtp的授权码 写的不是QQ密码，此授权码不可用
//$mail->IsSendmail(); //如果没有sendmail组件就注释掉，否则出现“Could not execute: /var/qmail/bin/sendmail ”的错误提示
        $mail->AddReplyTo("17010057955@163.com","mckee");//回复地址
        $mail->From = "17010057955@163.com";
        $mail->FromName = $fromname;
        //$to = $to;
        $mail->AddAddress($to);
        $mail->Subject = $title;
        $mail->Body = $content;
        $mail->AltBody = "To view the message, please use an HTML compatible email viewer!"; //当邮件不支持html时备用显示，可以省略
        $mail->WordWrap = 80; // 设置每行字符串的长度
//$mail->AddAttachment("f:/test.png"); //可以添加附件
        $mail->IsHTML(true);
        $mail->Send();
        return  returnData(1,"发送成功");

    } catch (phpmailerException $e) {
        return returnData(2,"邮件发送失败：".$e->errorMessage()."请联系管理");
    }



}
//环境 PHP5.3亲测可用
?>