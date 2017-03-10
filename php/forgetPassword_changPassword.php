<?php
error_reporting(0);
    require_once './closed/user.php';
    $u = new user();
    $userEmail=$_POST['userEmail'];
    $password=$_POST['newPassword'];
    $user = $u->getUserByUserEmail($userEmail);
    if($user&&(strlen($password)>=6)&&(strlen($password)<=16))
    {
        $u->modUserPassWord($user['userid'],$password);
        echo json_encode(array('result'=>'success'));
    }
?>