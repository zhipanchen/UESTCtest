<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午8:39
 */
error_reporting(0);
    $usercode=$_POST['usercode'];
    require_once './closed/user.php';
    $u = new user();
    $user = $u->getUserByUserCode($usercode);
    echo json_encode(array('result'=>$user));
?>