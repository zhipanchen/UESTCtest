<?php
/**
 * Created by PhpStorm.
 * User: ziyu-fu
 * Date: 17-1-8
 * Time: 下午3:54
 */
error_reporting(0);
require_once './closed/user.php';
$userid=$_POST['userid'];
$oldpassword=$_POST['oldpassword'];
$password=$_POST['password'];
$u = new user();
$user = $u->getUserById($userid);
if(($user['userpassword']==md5($oldpassword))&&(strlen($password)>=6)&&(strlen($password)<=16))
{
    $u->modUserPassWord($userid,$password);
    echo json_encode(array('result'=>'success'));
}
else
{
    echo json_encode(array('result'=>'false'));
}
?>