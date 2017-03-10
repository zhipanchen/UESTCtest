<?php

require_once './closed/session.php';
require_once './closed/user.php';

$s=new Session();
$u=new user();
$session=$s->getCurrentSession();
if(!$session){
    echo json_encode(array('result'=>'redirection'));
}else{
    $user=$u->getUserById($session['sessionuserid']);
    echo json_encode(array('user'=>$user));
};
//{"user":{"userid":"1","username":"peadmin","useremail":"531489023@qq.com","userphone":"123","userpassword":"244153a2599be7685c32d2281f57ae67","userregip":"127.0.0.1","userregtime":"0","userlogtime":"0","usergroupid":"1","photo":"123","usertruename":"admin","usercode":"123","userstate":"1"}}
?>
