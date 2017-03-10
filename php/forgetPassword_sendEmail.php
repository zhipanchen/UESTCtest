<?php
error_reporting(0);
$useremail = $_POST['userEmail'];
require_once './closed/user.php';
require_once './closed/email.php';
$useremail="531489023@qq.com";
$e = new email();
$u = new user();
$user = $u->getUserByUserEmail($useremail);
$result=array();
$rand = $e->sendRandEmailToUser($useremail);
$result['result']=$rand;
$result['state']=0;
if($user)
{
    $result['state']=1;
}
echo json_encode($result);
?>