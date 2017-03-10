<?php
$args['username']=$_POST['username'];
$args['useremail']=$_POST['useremail'];
$args['userphone']=$_POST['userphone'];
$args['userpassword']=$_POST['userpassword'];
$args['usertruename']=$_POST['usertruename'];
$args['usercode']=$_POST['usercode'];

$username=$args['username'];
$useremail=$args['useremail'];
$userphone=$args['userphone'];
$userpassword=md5($args['userpassword']);
$usertruename=$args['usertruename'];
$usercode=$args['usercode'];

require_once './closed/user.php';
require_once './closed/session.php';
$u = new user();
$s = new Session();
if($u->getUserByUserName($username))
{
    echo json_encode(array('result'=>1));
}
else
{
    if($u->getUserByUserEmail($useremail))
    {
        echo json_encode(array('result'=>2));
    }
    else
    {
        $user = $u->getUserByUserTrueName($usertruename);
        if ($user && ($usercode == $user['usercode']))
        {
            echo json_encode(array('result'=>3));
        }
        else
        {
            $u->addUser($args);
            $t_user = $u->getUserByUserName($args['username']);
//            require_once './closed/email.php';
//            $e = new email();
//            $e->sendActiveLinkToUser($username,$useremail,SEC);
//            $s->setSession($t_user);
            echo json_encode(array('result'=>5));
        }
    }
}
?>