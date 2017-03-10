<?php
error_reporting(0);
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
require_once './closed/myTime.php';
$t = new My_time();
$time_now = time();
$time_set = $t->getRegTime();
if(($time_set['timestart']>$time_now) || ($time_set['timeend']<$time_now) || ($time_set['timestate']==0))
{
    echo json_encode(array('result'=>404));
    exit(0);
}
$u = new user();
$s = new Session();
$fob=array('<','>',',','.','?','/',';',':','"',"'",'[',']','{','}','|','\\','+','=','-','_','!','@','#','$','%','^','&','*','(',')','~','`');
if((strlen($args['userpassword'])<6) ||(strlen($args['userpassword'])>16))
{
    echo json_encode(array('result'=>10));
    exit(0);
}
if (!preg_match("/^[_0-9a-zA-Z]{6,16}$/i",$username))
{
    echo json_encode(array('result'=>11));
    exit(0);
}
if (!preg_match("/^[_0-9]{10,20}$/i",$usercode))
{
    echo json_encode(array('result'=>12));
    exit(0);
}
if (!preg_match("/^[_0-9]{11,11}$/i",$userphone))
{
    echo json_encode(array('result'=>13));
    exit(0);
}
$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
if (!preg_match($pattern,$useremail))
{
    echo json_encode(array('result'=>14));
    exit(0);
}
foreach ($fob as $f)
{
    if(strpos($usertruename,$f) !== false)
    {
        echo json_encode(array('result'=>15));
        exit(0);
    }
}
if((strlen($usertruename)<=0) && (strlen($usertruename)>10))
{
    echo json_encode(array('result'=>15));
    exit(0);
}
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