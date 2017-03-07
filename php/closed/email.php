<?php

/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2016/12/31
 * Time: 22:33
 */
class email
{
    public function sendActiveLinkToUser($username,$useremail,$key)
    {
        require_once 'user.php';
        $u = new user();
        $user = $u->getUserByUserName($username);
        require_once 'encrypt.php';
        $e = new encrypt();
        $crypt = $e->passport_encrypt($user['userid'],$key);
        $link = LINK.$crypt;
        $to = $useremail;
        $subject = "在线答题系系统用户激活";
        ini_set('SMTP','smtp.yueeer.cn');
        ini_set('smtp_port',25);
        ini_set('sendmail_from',"Administrator@yueeer.cn");
        $header="From:在线答题系统 <Administrator@yueeer.cn>\n";
        $header.="Return-Path:<Administrator@yueeer.cn>\n";
        $header.="MIME-Version:1.0\n";
        $header.="Content-type:text/html; charset=utf-8\n";
        $header.="Content-Transfer-Encoding:8bit\r\n";
        $message = "点击"."<a href=\"".$link."\">此处</a>"."以完成注册。";
        mail($to,$subject,$message,$header);
    }

    public function sendRandEmailToUser($useremail)
    {
        srand((double)microtime()*1000000);//create a random number feed.
        $ychar="0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z";
        $list=explode(",",$ychar);
        $authnum="";
        for($i=0;$i<6;$i++){
            $randnum=rand(0,35); // 10+26;
            $authnum.=$list[$randnum];
        }
        $to = $useremail;
        require_once 'user.php';
        $u = new user();
        $user = $u->getUserByUserEmail($useremail);
        $subject = "在线答题系统验证码";
        $message = "你好".$user['username']."!\n"."验证码是：".$authnum;
        ini_set('SMTP','smtp.yueeer.cn');
        ini_set('smtp_port',25);
        ini_set('sendmail_from',"Administrator@yueeer.cn");
        mail($to,$subject,$message);
        return $authnum;
    }
}