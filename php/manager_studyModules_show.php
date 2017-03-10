<?php
error_reporting(0);
require_once './closed/session.php';
require_once './closed/module.php';
require_once './closed/user.php';

$s=new Session();
$u=new user();
$session=$s->getCurrentSession();
if(!$session||($session['sessiongroupid']!=1)){
    echo json_encode(array('result'=>'redirection'));
    require_once 'logout.php';
    exit(0);
}else{
    $user=$u->getUserById($session['sessionuserid']);
    $m=new module();
    $moudle=$m->getModuleList();
    echo json_encode(array('username'=>$user['username'],'photo'=>$user['photo'],'list'=>$moudle));
};
?>