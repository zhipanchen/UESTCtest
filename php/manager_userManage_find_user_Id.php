<?php
/**
 * Created by PhpStorm.
 * User: Ziyu-Fu
 * Date: 2017/2/15
 * Time: 11:48
 */
error_reporting(0);
    $userid=$_POST['userid'];
    require_once './closed/user.php';
    $u = new user();
    $user = $u->getUserById($userid);
    echo json_encode(array('result'=>$user));
?>