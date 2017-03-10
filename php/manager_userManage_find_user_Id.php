<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/15
 * Time: 11:48
 */
    $userid=$_POST['userid'];
    require_once './closed/user.php';
    $u = new user();
    $user = $u->getUserById($userid);
    echo json_encode(array('result'=>$user));
//{"result":{"userid":"1","username":"peadmin","useremail":"531489023@qq.com","userphone":"123","userpassword":"244153a2599be7685c32d2281f57ae67","userregip":"127.0.0.1","userregtime":"0","userlogtime":"0","usergroupid":"1","photo":"photo\/c4ca4238a0b923820dcc509a6f75849b.jpg","usertruename":"admin","usercode":"123","userstate":"1"}}
?>