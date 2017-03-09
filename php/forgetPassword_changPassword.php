<?php
    require_once './closed/user.php';
    $u = new user();
    $userEmail=$_POST['userEmail'];
    $password=$_POST['newPassword'];
    $user = $u->getUserByUserEmail($userEmail);
    $u->modUserPassWord($user['userid'],$password);
    echo json_encode(array('result'=>'success'));
//{"result":"success"}
?>