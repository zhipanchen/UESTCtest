<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午8:39
 */

    $usercode=$_POST['usercode'];
    require_once './closed/user.php';
    $u = new user();
    $user = $u->getUserByUserCode($usercode);
    echo json_encode(array('result'=>$user));
//{"result":[{"userid":"2","username":"xiaohua","useremail":"123","userphone":"123","userpassword":"123","userregip":"123","userregtime":"0","userlogtime":"0","usergroupid":"2","photo":"123","usertruename":"123","usercode":"123","userstate":"0"},{"userid":"3","username":"xiaohua","useremail":"123","userphone":"123","userpassword":"123","userregip":"123","userregtime":"0","userlogtime":"0","usergroupid":"123","photo":"123","usertruename":"123","usercode":"123","userstate":"0"}]}
?>