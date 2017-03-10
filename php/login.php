<?php
error_reporting(0);
require_once './closed/config.php';
require_once './closed/session.php';
require_once './closed/user.php';
require_once './closed/clearOnTime.php';
$s = new Session();
$u = new user();
$username=$_POST['username'];
$password=$_POST['password'];
clearOnTime();
$user=$u->getUserByUserName($username);
if($user)
{
    $s->clearSession($user['username']);
    if($user['userstate']==0)
    {
        $message['state']=3;
    }
    else
    {
        if($user['userpassword']==md5($password))
        {
            $message['state']=$user['usergroupid'];
            $s->setSession($user);
        }
        else
        {
            $message['state']=0;
        }
    }
}
else
{
    $message['state']=0;
}

echo json_encode($message);
?>